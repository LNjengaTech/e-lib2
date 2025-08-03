<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Loan;
use App\Models\Fine;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckOverdueLoans extends Command
{
    protected $signature = 'loans:check-overdue';
    protected $description = 'Checks for overdue loans and applies fines if necessary.';

    protected $dailyFineAmount = 10.00; // Ksh. 10.00 per day
    protected $gracePeriodDays = 7;

    public function handle()
    {
        $this->info('Checking for overdue loans...');
        Log::info('loans:check-overdue command started.');
        Log::info('Current time: ' . Carbon::now()->toDateTimeString());
        Log::info('Grace period: ' . $this->gracePeriodDays . ' days.');

        $overdueCutoffDate = Carbon::now()->subDays($this->gracePeriodDays);
        Log::info('Loans due before this date will be considered for fine: ' . $overdueCutoffDate->toDateTimeString());

        $overdueLoans = Loan::whereNull('returned_at')
                            ->where('due_date', '<', $overdueCutoffDate)
                            ->get();

        $finesAppliedCount = 0;

        $this->info("Found " . $overdueLoans->count() . " potential overdue loans.");
        Log::info("Found " . $overdueLoans->count() . " potential overdue loans.");

        if ($overdueLoans->isEmpty()) {
            $this->info('No overdue loans found that meet the criteria.');
            Log::info('No overdue loans found that meet the criteria. Command finished.');
            return Command::SUCCESS;
        }

        foreach ($overdueLoans as $loan) {
            // Precompute related values to avoid interpolation issues
            $bookTitle = $loan->book?->title ?? 'N/A';
            $userName = $loan->user?->name ?? 'N/A';
            $dueDateStr = $loan->due_date?->toDateTimeString() ?? 'N/A';

            Log::info("Processing loan ID: {$loan->id}, Book: {$bookTitle}, User: {$userName}, Due Date: {$dueDateStr}");

            DB::beginTransaction();
            try {
                // Ensure we compute days overdue as difference from due_date to now
                $daysOverdue = (int) abs(Carbon::now()->diffInDays($loan->due_date));
                $daysToFine = $daysOverdue - $this->gracePeriodDays;

                Log::info("  - Days overdue (total): {$daysOverdue}, Days to fine (past grace): {$daysToFine}");

                if ($daysToFine <= 0) {
                    $this->warn("Skipping loan ID {$loan->id}: Not yet past the grace period for fining or already handled.");
                    Log::warning("  - Skipping loan ID {$loan->id}: Not yet past the grace period for fining or already handled (daysToFine <= 0).");
                    DB::rollBack();
                    continue;
                }

                $existingDailyFine = Fine::where('loan_id', $loan->id)
                                         ->where('reason', 'like', 'Overdue by %')
                                         ->whereDate('issued_at', Carbon::today())
                                         ->first();

                if ($existingDailyFine) {
                    $this->warn("Skipping loan ID {$loan->id}: Daily fine already applied for today.");
                    Log::warning("  - Skipping loan ID {$loan->id}: Daily fine already applied for today.");
                    DB::rollBack();
                    continue;
                }

                $fineAmount = $this->dailyFineAmount;

                $fine = Fine::create([
                    'user_id' => $loan->user_id,
                    'loan_id' => $loan->id,
                    'amount' => $fineAmount,
                    'reason' => 'Overdue by ' . $daysOverdue . ' days: ' . ($loan->book?->title ?? 'Unknown Book'),
                    'issued_at' => Carbon::now(),
                    'status' => 'outstanding',
                ]);
                Log::info("  - Fine created for loan ID {$loan->id}. Fine ID: {$fine->id}, Amount: {$fine->amount}");

                $user = User::find($loan->user_id);
                if ($user) {
                    $user->increment('fee_balance', $fine->amount);
                    Log::info("  - User ID {$user->id} fee_balance incremented by {$fine->amount}. New balance: {$user->fee_balance}");
                } else {
                    Log::error("  - User not found for loan ID {$loan->id}. User ID: {$loan->user_id}");
                }

                if ($loan->status !== 'overdue') {
                    $loan->update(['status' => 'overdue']);
                    Log::info("  - Loan ID {$loan->id} status updated to 'overdue'.");
                }

                DB::commit();
                $finesAppliedCount++;

                $this->info("Applied fine of Ksh. " . number_format($fineAmount, 2) . " for loan ID {$loan->id} (User: {$userName}, Book: {$bookTitle}).");
                Log::info("  - Transaction committed for loan ID {$loan->id}. Fine applied successfully.");

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error applying fine for loan ID {$loan->id}: " . $e->getMessage(), ['exception_trace' => $e->getTraceAsString()]);
                $this->error("Failed to apply fine for loan ID {$loan->id}. Error: " . $e->getMessage());
            }
        }

        $this->info("Finished checking overdue loans. Applied {$finesAppliedCount} new fines.");
        Log::info('loans:check-overdue command finished. Fines applied: ' . $finesAppliedCount);
        return Command::SUCCESS;
    }
}

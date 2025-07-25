<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogue extends Model
{
    use HasFactory;
    public function scopeFilter($query, array $filters)
    {
        //search
        if ($filters['search'] ?? false) {
            $query->where('tags', 'like', '%' . request('search') . '%')
                ->orWhere('title', 'like', '%' . request('search') . '%')
                ->orWhere('description', 'like', '%' . request('search') . '%')
                ->orWhere('category', 'like', '%' . request('search') . '%')
                ->orWhere('author', 'like', '%' . request('search') . '%');
        }

        //tags
        if ($filters['tags'] ?? false) {
            $query->where('tags', 'like', '%' . $filters['tags'] . '%');
        }

        //category
         if ($filters['category'] ?? false) {
            $query->where('category', 'like', '%' . $filters['category'] . '%');
        }
    }
}
<x-home-sections class="pb-10">
    <h2 class="font-bold text-2xl max-1000px:text-xl mb-10 max-890px:text-center font-mono">Frequently Asked Questions
    </h2>
    <section>
        <article class="py-4 border-b border-light/40">
            <p id="q1" class="flex justify-between items-center cursor-pointer group ">
                <span class="group-hover:text-light/50 transition-all">How do I borrow a book?</span>
                {{-- <i class="fa-solid fa-chevron-up group-hover:text-light/80 transition-all"></i> --}}
                <i class="fa-solid fa-chevron-down"></i>
            </p>

            <p id="a1" class="hidden pt-5 text-light/90">
                To borrow a book, ensure you are a registered student with all school fees cleared for the term.
                Visit the library catalogue, search for your desired book, and place a borrow request.
                Once approved, the book will be reserved for you, and you can collect it in person from the library.
            </p>
        </article>

        <article class="py-4 border-b border-light/40">
            <p id="q2" class="flex justify-between items-center cursor-pointer group ">
                <span class="group-hover:text-light/50 transition-all">How do I return a book?</span>
                {{-- <i class="fa-solid fa-chevron-up group-hover:text-light/80 transition-all"></i> --}}
                <i class="fa-solid fa-chevron-down"></i>
            </p>

            <p id="a2" class="hidden pt-5 text-light/90">
                Please return the book in person at the library counter. Once processed, the return will be updated in
                your dashboard. If the book is returned after the due date, a late fee will be applied based on the
                number of overdue days.
            </p>
        </article>

        <article class="py-4 border-b border-light/40">
            <p id="q3" class="flex justify-between items-center cursor-pointer group ">
                <span class="group-hover:text-light/50 transition-all">How do I borrow a book?</span>
                {{-- <i class="fa-solid fa-chevron-up group-hover:text-light/80 transition-all"></i> --}}
                <i class="fa-solid fa-chevron-down"></i>
            </p>

            <p id="a3" class="hidden pt-5 text-light/90">
                To borrow a book, you need to be a bonafied student, and have completed your fees for the school term.
                Go to the library catalogue, search for your preferred book and borrow.
            </p>
        </article>

        <article class="py-4 ">
            <p id="q4" class="flex justify-between items-center cursor-pointer group ">
                <span class="group-hover:text-light/50 transition-all">How do I find the book I want?</span>
                {{-- <i class="fa-solid fa-chevron-up group-hover:text-light/80 transition-all"></i> --}}
                <i class="fa-solid fa-chevron-down"></i>
            </p>

            <p id="a4" class="hidden pt-5 text-light/90">
                Use the search bar above to enter the title, author, or keywords related to the book you want. If the
                book is available in the library catalogue, it will be displayed in the search results for you to select
                and borrow.
            </p>
        </article>
    </section>
    <script>
        const q1 = document.getElementById('q1')
        const a1 = document.getElementById('a1')
        const q2 = document.getElementById('q2')
        const a2 = document.getElementById('a2')
        const q3 = document.getElementById('q3')
        const a3 = document.getElementById('a3')
        const q4 = document.getElementById('q4')
        const a4 = document.getElementById('a4')

        q1.addEventListener('click', (e) => {
            a1.classList.toggle('hidden');
            e.target.classList.toggle('text-light/50')
        });

        q2.addEventListener('click', (e) => {
            a2.classList.toggle('hidden');
            e.target.classList.toggle('text-light/50')
        })

        q3.addEventListener('click', () => {
            a3.classList.toggle('hidden');
            e.target.classList.toggle('text-light/50')
        })
        q4.addEventListener('click', () => {
            a4.classList.toggle('hidden');
            e.target.classList.toggle('text-light/50')
        })
    </script>
</x-home-sections>

<x-home-sections class="py-4 pb-4 mb-2 max-630px:mb-0">
    <footer>
        &copy; <span id="currentYear"></span>
    </footer>
    <script>
        document.getElementById('currentYear').textContent = new Date().getFullYear();
    </script>
</x-home-sections>
  
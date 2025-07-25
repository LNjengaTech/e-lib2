document.addEventListener("DOMContentLoaded", function () {
    const sidebar = document.getElementById("sidebar");
    const openBtn = document.getElementById("openSidebar");
    const closeBtn = document.getElementById("closeSidebar");
    if (openBtn && closeBtn && sidebar) {
        openBtn.addEventListener("click", function () {
            sidebar.classList.remove("max-630px:hidden");
            openBtn.classList.add("hidden");
            closeBtn.classList.remove("hidden");
        });
        closeBtn.addEventListener("click", function () {
            sidebar.classList.add("max-630px:hidden");
            openBtn.classList.remove("hidden");
            closeBtn.classList.add("hidden");
        });
    }
});
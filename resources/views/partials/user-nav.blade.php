<header class="bg-light text-dark flex justify-between items-center w-full px-1">
    <article class="flex items-center text-sm">
        <a href="" class="fa-solid fa-user text-3xl"></a>
        <div class="flex flex-col px-2">
            <span class="font-bold">Your Name</span>
            <span>User</span>
        </div>
    </article>

    <article class="flex items-center gap-3 text-sm">
        <div class="flex flex-col">
            <p id="user-time" class="font-bold"></p>
            <p id="user-day"></p>
        </div>

        <a href="" class="fa-solid fa-gear text-2xl"></a>
    </article>

    <script>
        const date = new Date();
        let hours = date.getHours();
        let minutes = date.getMinutes();
        let day = date.getDay();
        const month = date.getMonth();
        const year = date.getFullYear();
        let get_date = new Date().getDate();
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thur', 'Fri', 'Sat'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        function updateTime() {
            if (hours < 10) {
                hours = "0" + hours;
            }
            if (minutes < 10) {
                minutes = "0" + minutes;
            }
            if (get_date < 10) {
                get_date = "0" + get_date;
            }
            const time = hours + ":" + minutes;
            const userTime = document.getElementById('user-time').innerText = time;
            const userDay = document.getElementById('user-day').innerText = days[day];
            const userMonth = document.getElementById('user-day').innerText += ", " + months[month];
            const userDate = document.getElementById('user-day').innerText += " " + get_date;
        }
        updateTime();
        //update time after every 1 minute
        setInterval(updateTime, 1 * 60000);
    </script>
</header>

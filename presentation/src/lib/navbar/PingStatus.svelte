<script>
    let alive = true;
    let lastCheck = Date.now();
    export let interval;
    export let loggedIn;
    //randomly change status
    setInterval(() => {
        pingAPI();
    }, interval * 1000 * 60);

    const pingAPI = async () => {
        //TODO: Make a function to ping API, and update status, to check if service is alive.
        // let response = await fetch("http://localhost:5000/api/ping");
        // if (response.ok) {
        //     alive = true;
        // } else {
        //     alive = false;
        // }
        // lastCheck = Date.now();

        alive = Math.random() > 0.3 ? true : false;
        lastCheck = Date.now();
    };
</script>

<button class="relative" on:click={pingAPI}>
    <div class="flex flex-col text-xs text-white mr-3">
        <div class="px-4 text-xs {loggedIn ? 'text-white' : 'text-red-500'}">
            {loggedIn ? "Welcome Admin" : "Not logged in"}
        </div>
        <p>Service is {alive ? "alive" : "down"}</p>
        <p>Last check: {new Date(lastCheck).toLocaleTimeString("it-IT")}</p>
    </div>
    <div
        class="{alive
            ? 'bg-green-400'
            : 'bg-red-400'} transition-all h-4 w-4 rounded-full absolute top-0 -right-2"
    />
    <div
        class="{alive
            ? 'bg-green-400'
            : 'bg-red-400'} transition-all animate-ping h-4 w-4 rounded-full absolute top-0 -right-2"
    />
</button>

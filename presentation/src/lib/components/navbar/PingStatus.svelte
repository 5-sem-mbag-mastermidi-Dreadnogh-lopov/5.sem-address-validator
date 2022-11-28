<script>
    import { pageStore, loggedIn } from "../../stores/page.store";
    import { notifications } from "../../stores/notifications";
    let alive = true;
    let lastCheck = Date.now();
    export let interval;

    //randomly change status
    setInterval(() => {
        pingAPI();
    }, interval * 1000 * 60);

    const pingAPI = async () => {
        //TODO: Make a function to ping API, and update status, to check if service is alive.
        try {
            let response = await fetch("http://localhost:80/api/alive");
            if (response.ok) {
                alive = true;
            } else {
                throw new Error("API is not alive");
            }
        } catch (error) {
            alive = false;
            notifications.danger("API is not responding", 1000);
        }
        lastCheck = Date.now();
    };
    //goto login page if not logged in
    function gotoLogin() {
        if (!$loggedIn) {
            pageStore.loginPage();
        }
    }
</script>

<button class="relative" on:click={pingAPI}>
    <div class="flex flex-col text-xs text-white mr-3">
        <button
            class="px-4 text-xs {$loggedIn ? 'text-white' : 'text-red-500'}"
            on:click={gotoLogin}
        >
            {$loggedIn ? "Welcome Admin" : "Not logged in"}
        </button>
        <p>
            Service is
            <span class="{alive ? 'text-green-400' : 'text-red-400'} ">
                {alive ? "alive" : "down"}
            </span>
        </p>
        <p>
            Last check: <span class="font-bold"
                >{new Date(lastCheck).toLocaleTimeString("it-IT")}</span
            >
        </p>
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

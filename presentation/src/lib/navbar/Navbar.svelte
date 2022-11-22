<script>
    import PingStatus from "./PingStatus.svelte";
    import { JWT } from "../stores/login.store.js";
    //Constants
    import {
        activeMenu,
        LOGIN_BTN,
        ADMIN_TOOL_BTN,
        API_TEST_BTN,
    } from "../stores/page.store.js";
    //how often to ping API in minutes
    let interval = 1;
    //Methods
    $: loggedIn = $JWT !== undefined;

    let pages = [LOGIN_BTN, ADMIN_TOOL_BTN, API_TEST_BTN];
    const handleClick = (page) => {
        if (page === LOGIN_BTN) {
            activeMenu.set(LOGIN_BTN);
        } else if (page === ADMIN_TOOL_BTN && loggedIn) {
            activeMenu.set(ADMIN_TOOL_BTN);
        } else if (page === API_TEST_BTN) {
            activeMenu.set(API_TEST_BTN);
        } else {
            alert("You need to login first");
        }
    };
</script>

<div class="flex items-center navbar overflow-hidden bg-zinc-700 shadow-xl">
    {#each pages as page}
        <!-- content here -->
        <button
            href="_blank"
            class="p-4 text-white {$activeMenu == page
                ? 'bg-green-500 font-bold'
                : 'hover:bg-zinc-600'}
                transition-all"
            on:click={() => {
                handleClick(page);
            }}>{page}</button
        >
    {/each}

    <div class="px-4 ml-auto -mt-2">
        <PingStatus {interval} {loggedIn} />
    </div>
</div>

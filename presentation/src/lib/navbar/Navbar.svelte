<script>
    import PingStatus from "./PingStatus.svelte";
    //Constants
    import {
        pageStore,
        loggedIn,
        LOGIN_BTN,
        ADMIN_TOOL_BTN,
        API_TEST_BTN,
    } from "../stores/page.store.js";
    //how often to ping API in minutes
    let interval = 1;
    //Methods

    let pages = [LOGIN_BTN, ADMIN_TOOL_BTN, API_TEST_BTN];
    const handleClick = (page) => {
        if (page === LOGIN_BTN) {
            pageStore.loginPage();
        } else if (page === ADMIN_TOOL_BTN) {
            pageStore.adminPage();
        } else if (page === API_TEST_BTN) {
            pageStore.apiTestPage();
        } else if (page === "logout") {
            pageStore.logout();
        }
    };
</script>

<div class="flex items-center navbar overflow-hidden bg-zinc-700 shadow-xl">
    {#each pages as page}
        {#if !$loggedIn || ($loggedIn && page !== LOGIN_BTN)}
            <button
                class="p-4 text-white {$pageStore == page
                    ? 'bg-green-500 font-bold'
                    : 'hover:bg-zinc-600'}
                transition-all"
                on:click={() => {
                    handleClick(page);
                }}>{page}</button
            >
        {:else}
            <button
                class="p-4 text-white {$pageStore == page
                    ? 'bg-green-500 font-bold'
                    : 'hover:bg-zinc-600'}
                transition-all"
                on:click={() => {
                    handleClick("logout");
                }}>logout</button
            >
        {/if}
    {/each}

    <div class="px-4 ml-auto -mt-2">
        <PingStatus {interval} />
    </div>
</div>

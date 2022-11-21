<script>
    import {
        activeMenu,
        LOGIN_BTN,
        ADMIN_TOOL_BTN,
        API_TEST_BTN,
    } from "../stores/page.store.js";
    import PingStatus from "./PingStatus.svelte";
    import { JWT } from "../stores/login.store.js";

    //Constants

    //Methods
    $: loggedIn = $JWT !== null || $JWT !== undefined || $JWT !== "";
    console.log($JWT);
</script>

<div class="flex items-center navbar">
    <!-- svelte-ignore a11y-click-events-have-key-events -->
    <button
        href="_blank"
        class:active={$activeMenu == LOGIN_BTN}
        on:click={() => {
            activeMenu.set(LOGIN_BTN);
        }}>{LOGIN_BTN}</button
    >
    <button
        class:active={$activeMenu == ADMIN_TOOL_BTN}
        on:click={() => {
            if ($JWT !== ("" || undefined || null)) {
                console.log($JWT);
                activeMenu.set(ADMIN_TOOL_BTN);
            } else {
                alert("You are not logged in");
            }
        }}
    >
        {ADMIN_TOOL_BTN}
    </button>
    <button
        href="_blank"
        class:active={$activeMenu == API_TEST_BTN}
        on:click={() => {
            activeMenu.set(API_TEST_BTN);
        }}>{API_TEST_BTN}</button
    >
    <div class="px-4 ml-auto {loggedIn ? 'text-green-500' : 'text-red-500'}">
        JWT
    </div>
    {@debug loggedIn}
    <div class="px-4 ml-auto"><PingStatus /></div>
</div>

<style>
    /* Add a black background color to the top navigation */
    .navbar {
        background-color: #333;
        overflow: hidden;
    }

    /* Style the links inside the navigation bar */
    .navbar button {
        float: left;
        color: #f2f2f2;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
    }

    /* Change the color of links on hover */
    .navbar button:hover {
        background-color: #ddd;
        color: black;
    }

    /* Add a color to the active/current link */
    .navbar button.active {
        background-color: #04aa6d;
        color: white;
    }
</style>

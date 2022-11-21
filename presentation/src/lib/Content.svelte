<script>
    import Login from "./login/Login.svelte";
    import AdminTool from "./adminTool/AdminTool.svelte";
    import ApiTest from "./apiTestTool/ApiTestTool.svelte";
    import {
        activeMenu,
        LOGIN_BTN,
        ADMIN_TOOL_BTN,
        API_TEST_BTN,
    } from "./stores/page.store";
</script>

{#if $activeMenu == LOGIN_BTN}
    <Login />
{/if}

{#if $activeMenu == ADMIN_TOOL_BTN}
    <AdminTool />
{/if}

{#if $activeMenu == API_TEST_BTN}
    <ApiTest />
{/if}

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
    let options = [
        { name: LOGIN_BTN, component: Login },
        { name: ADMIN_TOOL_BTN, component: AdminTool },
        { name: API_TEST_BTN, component: ApiTest },
    ];
    $: activeComponent = options.find(
        (option) => option.name === $activeMenu
    ).component;
</script>

<svelte:component this={activeComponent} />

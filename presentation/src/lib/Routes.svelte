<script>
    //Components
    import Login from "./components/login/Login.svelte";
    import AdminTool from "./components/adminTool/AdminTool.svelte";
    import ApiTest from "./components/apiTestTool/ApiTestTool.svelte";
    import Toast from "./toast.svelte";
    //Stores
    import { notifications } from "./stores/notifications.js";
    import {
        pageStore,
        LOGIN_BTN,
        ADMIN_TOOL_BTN,
        API_TEST_BTN,
    } from "./stores/page.store";
    import { onMount } from "svelte";

    let options = [
        { name: LOGIN_BTN, component: Login },
        { name: ADMIN_TOOL_BTN, component: AdminTool },
        { name: API_TEST_BTN, component: ApiTest },
    ];

    $: activeComponent = options.find(
        (option) => option.name === $pageStore
    ).component;

    onMount(() => {
        const jwt = localStorage.getItem("jwt");
        if (jwt) {
            pageStore.apiTestPage();
        }
    });

</script>


<div class="max-w-[100vw] overflow-hidden"> 
    <svelte:component this={activeComponent} />
    <Toast />
</div>

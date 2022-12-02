<script>
    import { pageStore } from "../../stores/page.store.js";
    import { notifications } from "../../stores/notifications.js";
    import { fly } from "svelte/transition";
    let password = "";
    let errors = false;

    async function submitLogin(password) {
        //Send password to API
        let response = await fetch(
            import.meta.env.VITE_API_HOST + "api/v1/login?password=" + password
        );
        if (response.ok) {
            errors = false;
            let { jwt } = await response.json();
            localStorage.setItem("jwt", jwt);
            pageStore.adminPage();
            notifications.success("Login successful", 1000);
        } else {
            errors = true;
            notifications.danger("Login failed, Wrong password", 1000);
        }
    }
</script>

<div
    class="flex flex-col items-center pt-12 h-[50vh] justify-around"
    in:fly={{x:-500, duration: 300 }}
>
    <p class="text-lg">
        To enter the <span class="font-bold">Admin tool</span>, type the
        <span class="font-bold">masterpassword</span> below
    </p>
    <div class="flex flex-col items-center">
        <label class="font-bold" for="passwordInput">Password</label><br />
        <input
            bind:value={password}
            class="p-1 border-2  outline-0 transition-all rounded focus:shadow-md focus:scale-105 {errors
                ? 'border-red-500 '
                : 'border-green-500'}"
            type="text"
            name="Password"
            id="passwordInput"
        />
    </div>
    <button
        on:click={() => submitLogin(password)}
        class="p-2 border text-white hover:text-green-500 shadow rounded bg-green-500 m-2 -mt-16 w-44 transition-all hover:scale-105 hover:bg-white hover:border-green-500"
        >Login</button
    >
</div>

<style>
</style>

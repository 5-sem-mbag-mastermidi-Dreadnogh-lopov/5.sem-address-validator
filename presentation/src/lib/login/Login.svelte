<script>
    import { JWT } from "../stores/login.store.js";
    let password = "";

    //TODO: Implement functional JWT auth to work with API call.
    function submitLogin(password) {
        //Send password to API
        //let response = await post("http://localhost:5000/api/auth", password);
        //let jwt = validateJwt(reponse);
        //if(jwt !== undefined)
        //    JWT.set(jwt);
        JWT.set(password);
    }
</script>

<div class="flex flex-col items-center pt-12 h-[30vh] justify-around">
    <p class="text-lg pb-6">
        To enter the <span class="font-bold">Admin tool</span>, type the
        <span class="font-bold">masterpassword</span> below
    </p>
    <div class="flex flex-col items-center">
        <label class="font-bold" for="passwordInput">Password</label><br />
        <input
            bind:value={password}
            class="p-1 border-2 border-green-500 outline-0 transition-all rounded focus:shadow-md focus:scale-105"
            type="password"
            name="Password"
            id="passwordInput"
        />
    </div>
    <button
        on:click={() => submitLogin(password)}
        class="p-2 border text-white hover:text-green-500 shadow rounded bg-green-500 m-2 w-44 transition-all hover:scale-105 hover:bg-white hover:border-green-500"
        >Login</button
    >
</div>

<style>
</style>

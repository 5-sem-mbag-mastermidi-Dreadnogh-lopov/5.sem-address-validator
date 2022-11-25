<script>
    let address = [
        { name: "Street", value: "" },
        { name: "Zipcode", value: "" },
        { name: "City", value: "" },
        { name: "CountryCode", value: "" },
        { name: "State", value: "" },
    ];

    //TODO: Implement functional to work with API call.
    function submitRequest() {
        alert("Request Submitted");
    }
</script>

<div class="flex flex-col items-center pt-12 m-h-[50vh] justify-around">
    <p class="text-lg">
        Enter the <span class="font-bold">Address</span>, to see if it exists in
        the cache database or can be verified elsewhere
    </p>

    <div class="p-6 flex flex-col items-end">
        {#each address as { name, value }}
            <!-- content here -->
            <div class="flex flex-col p-1">
                <label for={name}>{name}</label>
                <input
                    bind:value
                    class="border-2 border-green-500 outline-0 transition-all rounded focus:shadow-md focus:scale-105"
                    type="text"
                    {name}
                    id={name}
                    maxlength="50"
                />
            </div>
        {/each}
    </div>
    <button
        on:click={() => submitRequest()}
        class="p-2 mt-1 border text-white hover:text-green-500 shadow rounded bg-green-500 m-2  w-44 transition-all hover:scale-105 hover:bg-white hover:border-green-500"
        >Submit Request</button
    >
</div>

<style>
</style>

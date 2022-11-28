<script>
    import Spinner from "./../Spinner.svelte";

    import { getCache } from "../stores/cache.store.js";
    let search = "";
    let data;
    const searchCache = async () => {
        data = getCache(search);
    };
</script>

<form
    on:submit|preventDefault={searchCache}
    class="border-4 border-green-500 m-3 rounded-md p-1 overflow-hidden flex shadow-lg "
>
    <input
        type="text"
        name="seach"
        id="search"
        class="outline-0 border-0 w-full pl-2 text-gray-700"
        bind:value={search}
    />
    <button type="submit" class="pr-1"
        ><svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-search"
            width="36"
            height="36"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="#22c55e"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <circle cx="10" cy="10" r="7" />
            <line x1="21" y1="21" x2="15" y2="15" />
        </svg></button
    >
    {#await data}
        <Spinner />
    {:catch error}
        error
    {/await}
</form>

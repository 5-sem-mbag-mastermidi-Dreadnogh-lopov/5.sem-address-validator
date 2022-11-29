<script>
    import { slide } from "svelte/transition";
    import {
        cache,
        removeCache,
        updateCache,
        JSONToDisplay,
    } from "../../stores/cache.store.js";
    export let item;
</script>

<div
    class="flex flex-col p-2 bg-white border rounded gap-3"
    transition:slide={{ duration: 300 }}
>
    <button
        on:click={() => updateCache(item)}
        class="hover:bg-green-500 stroke-green-500 hover:stroke-white px-1 rounded-sm flex items-center cursor-pointer text-green-500 hover:text-white gap-1 transition-colors"
    >
        <p>Save</p>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-device-floppy"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path
                d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"
            />
            <circle cx="12" cy="14" r="2" />
            <polyline points="14 4 14 8 8 8 8 4" />
        </svg>
    </button>
    <button
        on:click={() => removeCache(item)}
        class="hover:bg-green-500 stroke-green-500 hover:stroke-white px-1 rounded-sm flex items-center cursor-pointer text-green-500 hover:text-white gap-1 transition-colors"
    >
        <p>Delete</p>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-trash"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <line x1="4" y1="7" x2="20" y2="7" />
            <line x1="10" y1="11" x2="10" y2="17" />
            <line x1="14" y1="11" x2="14" y2="17" />
            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
        </svg></button
    >
    <button
        on:click={() => {
            window.open(
                `https://www.google.com/maps/@${item.latitude},${item.longitude},18.75z`,
                "_blank"
            );
        }}
        class="hover:bg-green-500 stroke-green-500 hover:stroke-white px-1 rounded-sm flex items-center cursor-pointer text-green-500 hover:text-white gap-1 transition-colors"
    >
        <p>Maps</p>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-map-pin"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <circle cx="12" cy="11" r="3" />
            <path
                d="M17.657 16.657l-4.243 4.243a2 2 0 0 1 -2.827 0l-4.244 -4.243a8 8 0 1 1 11.314 0z"
            />
        </svg>
    </button>
    <button
        on:click={() => {
            JSONToDisplay.set(JSON.parse(item.response_json));
        }}
        class="hover:bg-green-500 stroke-green-500 hover:stroke-white px-1 rounded-sm flex items-center cursor-pointer text-green-500 hover:text-white gap-1 transition-colors"
    >
        <p>JSON</p>
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="icon icon-tabler icon-tabler-layers-linked"
            width="16"
            height="16"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            fill="none"
            stroke-linecap="round"
            stroke-linejoin="round"
        >
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path
                d="M19 8.268a2 2 0 0 1 1 1.732v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-8a2 2 0 0 1 2 -2h3"
            />
            <path
                d="M5.003 15.734a2 2 0 0 1 -1.003 -1.734v-8a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-3"
            />
        </svg>
    </button>
</div>

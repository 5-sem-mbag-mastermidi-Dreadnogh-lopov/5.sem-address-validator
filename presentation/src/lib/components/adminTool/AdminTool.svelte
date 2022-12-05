<script>
    import TableButtons from "./TableButtons.svelte";
    import CacheSearch from "./CacheSearch.svelte";
    import {
        cache,
        updateCache,
        JSONToDisplay,
    } from "../../stores/cache.store.js";
    import JSONEditor from "./JSONedit/JSONEditor.svelte";
    import { clickOutside } from "../../util/clickOutside.js";
    import { fly } from "svelte/transition";

    const closeJSONEditor = () => {
        JSONToDisplay.set(null);
    };
</script>
<svelte:head>
    <title>AdminTool</title>
</svelte:head>
<div class="flex flex-col overflow-visible" in:fly={{x:-500, duration: 300 }}>
    <CacheSearch />
    <table
        class="text-sm text-left text-gray-500 w-1/2 mx-auto shadow overflow-visible"
    >
        <thead class="text-xs text-gray-700 uppercase bg-gray-200">
            <tr>
                <th scope="col" class="py-3 px-1"> Adresse </th>
                <th scope="col" class="py-3 px-1"> By </th>
                <th scope="col" class="py-3 px-1"> Contry Code </th>
                <th scope="col" class="py-3 px-1"> Contry name </th>
                <th scope="col" class="py-3 px-1"> Latitude </th>
                <th scope="col" class="py-3 px-1"> Longitude </th>
                <th scope="col" class="py-3 px-1"> Mainland </th>
                <th scope="col" class="py-3 px-1"> Region </th>
                <th scope="col" class="py-3 px-1"> Gade Navn </th>
                <th scope="col" class="py-3 px-1"> Gade Nummer </th>
                <th scope="col" class="py-3 px-1"> Post Nr. </th>
                <th />
            </tr>
        </thead>
        <tbody id="resultTableBody">
            {#each $cache as item}
                <tr
                    class="bg-white border-b hover:shadow-xl transition-shadow relative overflow-visible hover:z-5"
                >
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.address_formatted}
                        />
                    </td>
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.city}
                        />
                    </td>
                    <td class="py-4 px-1 flex gap-2">
                        <img
                            src="https://www.countryflagicons.com/FLAT/16/{item.country_code}.png"
                            alt=""
                            class="select-none drag-none pointer-events-none"
                        />
                        <input
                            class="outline-0"
                            type="text"
                            bind:value={item.country_code}
                        />
                    </td>
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.country_name}
                        />
                    </td>
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.latitude}
                        />
                    </td>
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.longitude}
                        />
                    </td>
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.mainland}
                        />
                    </td>
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.state}
                        />
                    </td>
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.street_name}
                        />
                    </td>
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.street_number}
                        />
                    </td>
                    <td class="py-4 px-1"
                        ><input
                            class="outline-0"
                            type="text"
                            bind:value={item.zip_code}
                        />
                    </td>
                    <td class="flex gap-2 items-center relative mr-10">
                        <button
                            on:click={() => updateCache(item)}
                            class="stroke-green-500"
                        >
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-device-floppy overflow-visible"
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <path
                                    d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"
                                />
                                <circle cx="12" cy="14" r="2" />
                                <polyline points="14 4 14 8 8 8 8 4" />
                            </svg>
                        </button>
                        <div class="group/item overflow-visible">
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-dots "
                                width="24"
                                height="24"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="#22c55e"
                                fill="none"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                            >
                                <path
                                    stroke="none"
                                    d="M0 0h24v24H0z"
                                    fill="none"
                                />
                                <circle cx="5" cy="12" r="1" />
                                <circle cx="12" cy="12" r="1" />
                                <circle cx="19" cy="12" r="1" />
                            </svg>
                            <div
                                class="absolute z-10 scale-100 -bottom-[125px] -left-8 hidden group-hover/item:block transition-all duration-600 shadow-xl"
                            >
                                <TableButtons {item} />
                            </div>
                        </div>
                    </td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>

{#if $JSONToDisplay}
    <div
        use:clickOutside
        on:click_outside={closeJSONEditor}
        transition:fly={{x:-500, duration: 500 }}
        class="absolute z-100 scale-100 top-40 left-1/4 p-2 bg-green-500 rounded
        shadow-xl"
    >
        <JSONEditor />
    </div>
{/if}

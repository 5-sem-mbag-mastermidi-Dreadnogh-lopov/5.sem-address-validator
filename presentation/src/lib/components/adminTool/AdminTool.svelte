<script>
    import CacheSearch from "./CacheSearch.svelte";
    import {
        cache,
        removeCache,
        updateCache,
    } from "../../stores/cache.store.js";
</script>

<div class="flex flex-col ">
    <CacheSearch />
    <table class="text-sm text-left text-gray-500 w-screen">
        <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
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
                    class="bg-white border-b hover:shadow-xl hover:scale-100 transition-shadow"
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
                            src="https://countryflagsapi.com/svg/{item.country_code}"
                            alt=""
                            class="w-4 select-none drag-none pointer-events-none"
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
                    <td class="">
                        <button on:click={() => updateCache(item)}
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-device-floppy"
                                width="16"
                                height="16"
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
                                <path
                                    d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"
                                />
                                <circle cx="12" cy="14" r="2" />
                                <polyline points="14 4 14 8 8 8 8 4" />
                            </svg></button
                        >
                        <button on:click={() => removeCache(item)}
                            ><svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="icon icon-tabler icon-tabler-trash"
                                width="16"
                                height="16"
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
                                <line x1="4" y1="7" x2="20" y2="7" />
                                <line x1="10" y1="11" x2="10" y2="17" />
                                <line x1="14" y1="11" x2="14" y2="17" />
                                <path
                                    d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"
                                />
                                <path
                                    d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"
                                />
                            </svg></button
                        >
                    </td>
                </tr>
            {/each}
        </tbody>
    </table>
</div>

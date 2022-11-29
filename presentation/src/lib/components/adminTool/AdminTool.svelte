<script>
    import TableButtons from "./TableButtons.svelte";
    import CacheSearch from "./CacheSearch.svelte";
    import {
        cache,
        removeCache,
        updateCache,
    } from "../../stores/cache.store.js";
    import { fly } from "svelte/transition";
</script>

<div class="flex flex-col">
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
            </tr>
        </thead>
        <tbody id="resultTableBody">
            {#each $cache as item}
                <tr
                    class="bg-white border-b hover:shadow-xl transition-shadow group/item relative overflow-visible hover:z-5"
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
                    <div
                        class="absolute z-10 scale-100 right-6 -bottom-16 invisible group-hover/item:visible transition-all duration-600"
                    >
                        <TableButtons {item} />
                    </div>
                </tr>
            {/each}
        </tbody>
    </table>
</div>

<script>
    import { notifications } from "./../../stores/notifications.js";
    import Spinner from "../Spinner.svelte";
    import { fly } from "svelte/transition";

    let address = [
        { name: "Street", value: "", key: "street" },
        { name: "Zipcode", value: "", key: "zip_code" },
        { name: "City", value: "", key: "city" },
        { name: "CountryCode", value: "", key: "country_code" },
        { name: "State", value: "", key: "state" },
    ];

    let tableData = [];
    let waiting;
    //TODO: Implement functional to work with API call.
    async function submitRequest() {
        try {
            waiting = fetchAddressWash();
        } catch (error) {
            notifications.danger("failed getting address", 1000);
        }
    }

    const fetchAddressWash = async () => {
        const obj = address.reduce(
            (obj, item) =>
                Object.assign(
                    obj,
                    item.value ? { [item.key]: item.value } : false
                ),
            {}
        );
        console.log("obj", obj);

        const data = new URLSearchParams(obj).toString();
        let response = await fetch(
            import.meta.env.VITE_API_HOST + "/api/v1/address?" + data,
            {
                method: "POST",
                headers: {
                    Accept: "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(obj),
            }
        );

        if (response.ok) {
            let responseJson = await response.json();

            responseJson.date = new Date();
            insertAddressTotable(responseJson);
        } else if (response.status === 422) {
            let responseJson = await response.json();
            console.log("responseJson", responseJson);
            Object.values(responseJson.errors).forEach((error) => {
                notifications.warning(error[0], 2000);
            });
        } else {
            notifications.danger("failed getting address", 2000);
        }
    };
    function insertAddressTotable(responseJson) {
        tableData = [responseJson, ...tableData];
    }

    function clearTable() {
        tableData = [];
    }
</script>

{#await waiting}
    <Spinner />
{/await}
<div
    class="flex flex-col items-center pt-12 m-h-[50vh] justify-around"
    in:fly={{ x: 500, duration: 300 }}
>
    <p class="text-lg">
        Enter the <span class="font-bold">Address</span>, to see if it exists in
        the cache database or can be verified elsewhere
    </p>

    <form
        class="p-6 flex flex-col items-end"
        on:submit|preventDefault={submitRequest}
    >
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
        <button
            type="submit"
            class="p-2 mt-1 border text-white hover:text-green-500 shadow rounded bg-green-500 m-2  w-44 transition-all hover:scale-105 hover:bg-white hover:border-green-500"
            >Submit Request</button
        >
    </form>

    <div class="p-12">
        <div class="relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 ">
                    <tr>
                        <th scope="col" class="py-3 px-6"> Date </th>
                        <th scope="col" class="py-3 px-6"> Confidence </th>
                        <th scope="col" class="py-3 px-6"> Streetname </th>
                        <th scope="col" class="py-3 px-6"> Street Number </th>
                        <th scope="col" class="py-3 px-6"> Zipcode </th>
                        <th scope="col" class="py-3 px-6"> City </th>
                        <th scope="col" class="py-3 px-6"> Country </th>
                        <th scope="col" class="py-3 px-6"> Country Code </th>
                    </tr>
                </thead>
                <tbody id="resultTableBody">
                    {#each tableData as item}
                        <tr
                            class="bg-white border-b hover:shadow-xl hover:scale-100 transition-shadow"
                        >
                            <td class="py-4 px-6 ">
                                {item.date.toString().substring(0, 25)}
                            </td>
                            <td class="py-4 px-6  font-medium ">
                                {item["confidence"]}
                            </td>
                            <td class="py-4 px-6"> {item.street_name} </td>
                            <td class="py-4 px-6"> {item.street_number} </td>
                            <td class="py-4 px-6"> {item.zip_code} </td>
                            <td class="py-4 px-6"> {item.city} </td>
                            <td class="py-4 px-6"> {item.country_name} </td>
                            <td class="py-4 px-6"> {item.country_code} </td>
                        </tr>
                    {/each}
                </tbody>
            </table>
        </div>
        <div class="flex justify-end p-2 ">
            <button
                on:click={clearTable}
                class="underline hover:text-green-500 transition-all "
                >Clear</button
            >
        </div>
    </div>
</div>

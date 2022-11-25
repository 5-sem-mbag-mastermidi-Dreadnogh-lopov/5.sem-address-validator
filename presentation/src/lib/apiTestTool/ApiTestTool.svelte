<script>
    let address = [
        { name: "Street", value: "", key: "street" },
        { name: "Zipcode", value: "", key: "zip_code" },
        { name: "City", value: "", key: "city" },
        { name: "CountryCode", value: "", key: "country_code" },
        { name: "State", value: "", key: "state" },
    ];

    let tableData = [];

    //TODO: Implement functional to work with API call.
    async function submitRequest() {
        const obj = address.reduce(
            (obj, item) =>
                Object.assign(
                    obj,
                    item.value != "" ? { [item.key]: item.value } : false
                ),
            {}
        );
        const data = new URLSearchParams(obj).toString();
        let response = await fetch("http://localhost/api/v1/datawash?" + data);

        if (response.ok) {
            let responseJson = await response.json();
            responseJson.date = new Date();
            insertAddressTotable(responseJson);
        } else {
            //Toast popup functionality here, no data found.
            console.log("Toast popup");
        }
    }

    function insertAddressTotable(responseJson) {
        tableData = [responseJson, ...tableData];
    }

    function clearTable() {
        tableData = [];
    }
</script>

<div class="flex flex-col items-center pt-12 m-h-[50vh] justify-around">
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
        <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                >
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
                        <tr class="bg-white border-b ">
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

                    <!--<tr
                        class="bg-gray-50 border-b dark:bg-gray-800 dark:border-gray-700"
                    >
                        <th
                            scope="row"
                            class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                        >
                            Confidence
                        </th>
                        <td class="py-4 px-6"> Streetname </td>
                        <td class="py-4 px-6"> StreetNumber </td>
                        <td class="py-4 px-6"> Zipcode </td>
                        <td class="py-4 px-6"> City </td>
                        <td class="py-4 px-6"> Country </td>
                        <td class="py-4 px-6"> Country Code </td>
                    </tr>-->
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

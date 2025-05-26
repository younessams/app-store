<template>
    <div class="bg-gray-100 p-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Recent Orders</h2>
                    <button
                        class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600"
                    >
                        + Create Order
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table
                        class="min-w-full bg-white border border-gray-200 rounded-lg"
                    >
                        <thead>
                            <tr
                                class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal"
                            >
                                <th class="py-3 px-4 text-left">Order ID.</th>
                                <th class="py-3 px-4 text-left">Date</th>
                                <th class="py-3 px-4 text-left">Product</th>
                                <th class="py-3 px-4 text-left">
                                    Customer Name
                                </th>
                                <th class="py-3 px-4 text-left">Email ID</th>
                                <th class="py-3 px-4 text-left">Phone No.</th>
                                <th class="py-3 px-4 text-left">Address</th>
                                <th class="py-3 px-4 text-left">
                                    Payment Type
                                </th>
                                <th class="py-3 px-4 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm">
                            <tr
                                class="border-b border-gray-200 hover:bg-gray-50"
                            >
                                <td class="py-3 px-4">#RB5625</td>
                                <td class="py-3 px-4">29 April 2024</td>
                                <td class="py-3 px-4">
                                    <img
                                        src="https://cdn-icons-png.flaticon.com/128/1157/1157109.png"
                                        alt="Laptop"
                                        class="w-6 h-6"
                                    />
                                </td>
                                <td class="py-3 px-4">Anna M. Hines</td>
                                <td class="py-3 px-4">anna.hines@mail.com</td>
                                <td class="py-3 px-4">(+1)-555-1564-261</td>
                                <td class="py-3 px-4">Burr Ridge/Illinois</td>
                                <td class="py-3 px-4">Credit Card</td>
                                <td class="py-3 px-4">
                                    <span class="text-green-500 font-semibold"
                                        >● Complete</span
                                    >
                                </td>
                            </tr>
                            <tr
                                class="border-b border-gray-200 hover:bg-gray-50"
                            >
                                <td class="py-3 px-4">#RB9652</td>
                                <td class="py-3 px-4">25 April 2024</td>
                                <td class="py-3 px-4">
                                    <img
                                        src="https://cdn-icons-png.flaticon.com/128/2920/2920327.png"
                                        alt="Camera"
                                        class="w-6 h-6"
                                    />
                                </td>
                                <td class="py-3 px-4">Judith H. Fritsche</td>
                                <td class="py-3 px-4">judith.fritsche.com</td>
                                <td class="py-3 px-4">(+57)-305-5579-759</td>
                                <td class="py-3 px-4">SULLIVAN/Kentucky</td>
                                <td class="py-3 px-4">Credit Card</td>
                                <td class="py-3 px-4">
                                    <span class="text-green-500 font-semibold"
                                        >● Complete</span
                                    >
                                </td>
                            </tr>
                            <tr
                                class="border-b border-gray-200 hover:bg-gray-50"
                            >
                                <td class="py-3 px-4">#RB5984</td>
                                <td class="py-3 px-4">25 April 2024</td>
                                <td class="py-3 px-4">
                                    <img
                                        src="https://cdn-icons-png.flaticon.com/128/4812/4812441.png"
                                        alt="Smartwatch"
                                        class="w-6 h-6"
                                    />
                                </td>
                                <td class="py-3 px-4">Peter T. Smith</td>
                                <td class="py-3 px-4">peter.smith@mail.com</td>
                                <td class="py-3 px-4">(+33)-655-5187-93</td>
                                <td class="py-3 px-4">Yreka/California</td>
                                <td class="py-3 px-4">PayPal</td>
                                <td class="py-3 px-4">
                                    <span class="text-green-500 font-semibold"
                                        >● Complete</span
                                    >
                                </td>
                            </tr>
                            <tr
                                class="border-b border-gray-200 hover:bg-gray-50"
                            >
                                <td class="py-3 px-4">#RB3625</td>
                                <td class="py-3 px-4">21 April 2024</td>
                                <td class="py-3 px-4">
                                    <img
                                        src="https://cdn-icons-png.flaticon.com/128/724/724664.png"
                                        alt="Phone"
                                        class="w-6 h-6"
                                    />
                                </td>
                                <td class="py-3 px-4">Emmanuel J. Delcid</td>
                                <td class="py-3 px-4">
                                    emmanuel.delicid@mail.com
                                </td>
                                <td class="py-3 px-4">(+30)-693-5553-637</td>
                                <td class="py-3 px-4">Atlanta/Georgia</td>
                                <td class="py-3 px-4">PayPal</td>
                                <td class="py-3 px-4">
                                    <span class="text-orange-500 font-semibold"
                                        >● Processing</span
                                    >
                                </td>
                            </tr>
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">#RB8652</td>
                                <td class="py-3 px-4">18 April 2024</td>
                                <td class="py-3 px-4">
                                    <img
                                        src="https://cdn-icons-png.flaticon.com/128/1157/1157109.png"
                                        alt="Laptop"
                                        class="w-6 h-6"
                                    />
                                </td>
                                <td class="py-3 px-4">William J. Cook</td>
                                <td class="py-3 px-4">william.cook@mail.com</td>
                                <td class="py-3 px-4">(+91)-855-5446-150</td>
                                <td class="py-3 px-4">Rosenberg/Texas</td>
                                <td class="py-3 px-4">Credit Card</td>
                                <td class="py-3 px-4">
                                    <span class="text-orange-500 font-semibold"
                                        >● Processing</span
                                    >
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div
                    class="flex justify-between items-center mt-4 text-gray-600 text-sm"
                >
                    <span
                        >Showing <strong>5</strong> of
                        <strong>90,521</strong> orders</span
                    >
                    <div class="flex space-x-2">
                        <button
                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200"
                        >
                            ←
                        </button>
                        <button
                            class="px-3 py-1 bg-orange-500 text-white rounded-md"
                        >
                            1
                        </button>
                        <button
                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200"
                        >
                            2
                        </button>
                        <button
                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200"
                        >
                            3
                        </button>
                        <button
                            class="px-3 py-1 border border-gray-300 rounded-md hover:bg-gray-200"
                        >
                            →
                        </button>
                    </div>
                </div>
            </div>
        </div>
</template>
<template>
    <div class="bg-gray-100">

        <!-- Dashboard Content -->
        <div class="p-6 grid grid-cols-1 lg:grid-cols-4 gap-6">
            <!-- Sales Overview -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Total Sales</h2>
                <p class="text-2xl font-bold text-green-600">$15,240</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Total Orders</h2>
                <p class="text-2xl font-bold text-blue-600">320</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Total Customers</h2>
                <p class="text-2xl font-bold text-yellow-600">1,245</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">Pending Orders</h2>
                <p class="text-2xl font-bold text-red-600">12</p>
            </div>
        </div>

        <!-- Charts -->
        <div class="bg-gray-100 px-4 mb-6">
            <!-- Overview Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <h2 class="text-sm font-semibold text-gray-600">
                        Total Revenue
                    </h2>
                    <p class="text-xl font-bold text-blue-600">
                        ${{ totalRevenue }}
                    </p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <h2 class="text-sm font-semibold text-gray-600">
                        Total Sales
                    </h2>
                    <p class="text-xl font-bold text-green-600">
                        {{ totalSales }}
                    </p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md text-center">
                    <h2 class="text-sm font-semibold text-gray-600">
                        Best-Selling Product
                    </h2>
                    <p class="text-lg font-bold text-purple-600">
                        {{ topProducts[0].name }}
                    </p>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-4">
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-sm font-semibold mb-2">Monthly Revenue</h2>
                    <div class="h-40">
                        <Bar
                            :data="revenueData"
                            :options="{
                                responsive: true,
                                maintainAspectRatio: false,
                            }"
                        />
                    </div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <h2 class="text-sm font-semibold mb-2">
                        Sales by Category
                    </h2>
                    <div class="h-40">
                        <Doughnut
                            :data="categoryData"
                            :options="{
                                responsive: true,
                                maintainAspectRatio: false,
                            }"
                        />
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Recenet table -->
        <Order_recent />

    </div>
</template>

<script setup>
import Main from './Main.vue';
import Order_recent from "./Order_recent.vue";

import { ref } from "vue";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    LinearScale,
    BarElement,
} from "chart.js";
import { Doughnut, Bar } from "vue-chartjs";


defineOptions({
  layout: Main, // Assign layout dynamically
});

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    ArcElement,
    CategoryScale,
    LinearScale,
    BarElement
);

const totalRevenue = ref(45200);
const totalSales = ref(920);
const topProducts = ref([
    { name: "Smartphone X", sales: 320 },
    { name: "Running Shoes", sales: 210 },
    { name: "Wireless Headphones", sales: 180 },
]);

const revenueData = {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
    datasets: [
        {
            label: "Revenue ($)",
            backgroundColor: "#3b82f6",
            data: [5000, 7000, 8500, 9000, 12000, 10200],
        },
        {
            label: "Sales (u)",
            backgroundColor: "#f59e0b",
            data: [4000, 6000, 10000, 9000, 10200, 12000],
        },
    ],
};

const categoryData = {
    labels: ["Electronics", "Clothing", "Accessories", "Cars"],
    datasets: [
        {
            backgroundColor: ["#10b981", "#f59e0b", "#ef4444", "#4359"],
            data: [45, 30, 20, 5], // Find the total sum: Percentage=(Number/Total)×100
        },
    ],
};
</script>

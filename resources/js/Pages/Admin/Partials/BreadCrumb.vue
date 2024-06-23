<template>
    <div class="grid grid-cols-1 lg:grid-cols-3 lg:gap-x-6 gap-x-0 lg:gap-y-0 gap-y-6">
        <div class="col-span-2">
            <div class="card">
                <div class="card-body">
                    <div class="sm:flex block justify-between mb-5">
                        <h4 class="text-gray-600 text-lg font-semibold sm:mb-0 mb-2">Sales Overview</h4>
                        <select name="cars" id="cars"
                                class=" border-gray-400 text-gray-500 rounded-md text-sm border-[1px] focus:ring-0 sm:w-auto w-full">
                            <option value="volvo">March2023</option>
                            <option value="saab">April2023</option>
                            <option value="mercedes">May2023</option>
                            <option value="audi">June2023</option>
                        </select>
                    </div>
                    <div id="chart"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
</script>

<script setup>
import { ref } from 'vue'
import {
    useVueTable,
    FlexRender,
    getCoreRowModel,
    getPaginationRowModel,
    getSortedRowModel,
    getFilteredRowModel,
} from '@tanstack/vue-table'

const props = defineProps({
    data: Object,
    columns: Array,
    pageSize: {
        type: Number,
        default: 5
    },
})

const data = ref(props.data)

const sorting = ref([])
const filter = ref('')

const table = useVueTable({
    data: data.value,
    columns: props.columns,
    getCoreRowModel: getCoreRowModel(),
    getPaginationRowModel: getPaginationRowModel(),
    getSortedRowModel: getSortedRowModel(),
    getFilteredRowModel: getFilteredRowModel(),
    state: {
        get sorting() {
            return sorting.value
        },
        get globalFilter() {
            return filter.value
        },
    },
    onSortingChange: updaterOrValue => {
        sorting.value =
            typeof updaterOrValue === 'function'
                ? updaterOrValue(sorting.value)
                : updaterOrValue
    },
    initialState: {
      pagination: {
        pageSize: props.pageSize,
      },
    },
})
</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-2 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle px-4 sm:px-6 lg:px-8">
                    <div class="my-4 sm:flex sm:justify-end">
                        <input
                            type="text"
                            class="border border-gray-400 rounded-xl px-2 py-2"
                            placeholder="Search"
                            v-model="filter"
                        />
                    </div>
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr
                            v-for="headerGroup in table.getHeaderGroups()"
                            :key="headerGroup.id"
                        >
                            <th
                                v-for="header in headerGroup.headers"
                                :key="header.id"
                                scope="col"
                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 whitespace-nowrap"
                                :class="{
                                    'cursor-pointer select-none': header.column.getCanSort(),
                                    'text-right': header.column.columnDef.header === 'Actions',
                                }"
                                @click="header.column.getToggleSortingHandler()?.($event)"
                            >
                                <FlexRender
                                    :render="header.column.columnDef.header"
                                    :props="header.getContext()"
                                />
                                {{ { asc: '↑', desc: '↓' }[header.column.getIsSorted()] }}
                                {{ header.column.getCanSort() && !header.column.getIsSorted() ? '↕' : '' }}
                            </th>
                        </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">
                        <tr
                            v-for="(row, index) in table.getRowModel().rows"
                            :key="row.id"
                            class="cursor-pointer hover:bg-gray-100"
                            :class="{
                                'bg-gray-50': index % 2 === 0
                            }"
                        >
                            <td
                                v-for="cell in row.getVisibleCells()"
                                :key="cell.id"
                                class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"
                            >
                                <FlexRender
                                    :render="cell.column.columnDef.cell"
                                    :props="cell.getContext()"
                                />
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex flex-wrap justify-center sm:justify-end gap-4 items-center mt-5 scale-95 sm:scale-100">
                <div class="space-x-4 order-1">
                    <select @change="table.setPageSize($event.target.value)" class="rounded-xl border-gray-300">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="text-nowrap order-4 sm:order-2">
                    Page {{ table.getState().pagination.pageIndex + 1 }} of
                    {{ table.getPageCount() }} -
                    {{ table.getFilteredRowModel().rows.length }} results
                </div>
                <div class="flex flex-nowrap space-x-2 order-3">
                    <button
                        class="border border-gray-300 rounded-full px-2 py-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        @click="table.setPageIndex(0)"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m18.75 4.5-7.5 7.5 7.5 7.5m-6-15L5.25 12l7.5 7.5" />
                        </svg>
                    </button>
                    <button
                        class="border border-gray-300 rounded-full px-2 py-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="!table.getCanPreviousPage()"
                        @click="table.previousPage()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button
                        class="border border-gray-300 rounded-full px-2 py-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        :disabled="!table.getCanNextPage()"
                        @click="table.nextPage()"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                    <button
                        class="border border-gray-300 rounded-full px-2 py-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        @click="table.setPageIndex(table.getPageCount() - 1)"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m5.25 4.5 7.5 7.5-7.5 7.5m6-15 7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

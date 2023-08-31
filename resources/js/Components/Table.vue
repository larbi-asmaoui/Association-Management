<template>
    <!-- <el-input v-model="search" size="large" placeholder="Type to search" /> -->
    <el-table :data="filteredData" style="width: 100%">
        <el-table-column
            align="center"
            v-for="column in columns"
            :key="column.field"
            :label="column.label"
            :prop="column.field"
        >
            <!-- Customize the column content using scoped slots if needed -->
        </el-table-column>
        <el-table-column align="center">
            <template #header>
                <el-input
                    v-model="search"
                    size="large"
                    placeholder="Type to search"
                />
            </template>
            <template #default="scope">
                <el-button size="small" @click="handleEdit(scope.row)">
                    <Pencil />
                </el-button>
                <span class="ml-1"></span>
                <el-button
                    size="small"
                    type="danger"
                    @click="handleDelete(scope.row)"
                >
                    <TrashCan />
                </el-button>
            </template>
        </el-table-column>
    </el-table>
    <el-divider></el-divider>
    <div style="text-align: center">
        <el-pagination
            background
            layout="prev, pager, next"
            :page-size="pageSize"
            :total="total"
        >
        </el-pagination>
    </div>
</template>
<script setup>
import { computed, ref } from "vue";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
const props = defineProps({
    columns: {
        type: Array,
        required: true,
    },
    rows: {
        type: Array,
        required: true,
    },
    handleEdit: {
        type: Function,
        required: true,
    },
    handleDelete: {
        type: Function,
        required: true,
    },
});
const pageSize = ref(1);
const total = ref(0);
const search = ref("");

// Define the computed property outside of the setup function
const filteredData = computed(
    () =>
        props.rows.filter(
            (data) =>
                !search.value ||
                data.name.toLowerCase().includes(search.value.toLowerCase()),
        ),
    (total.value = props.rows.length),
    console.log(total.value),
);
</script>

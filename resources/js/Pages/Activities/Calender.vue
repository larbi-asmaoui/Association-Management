<script>
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>

<script setup>
import { reactive, ref, toRaw, onMounted, watchEffect } from "vue";
import { useForm, router } from "@inertiajs/vue3";
import { usePage } from "@inertiajs/vue3";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";
import listPlugin from "@fullcalendar/list";
import timeGridPlugin from "@fullcalendar/timegrid";

const props = defineProps({
    activities: {
        type: Object,
        default: () => ({}),
    },
    groupes: {
        type: Object,
        default: () => ({}),
    },
});

const page = usePage();

const calendarOptions = reactive({
    plugins: [dayGridPlugin, interactionPlugin, listPlugin, timeGridPlugin],
    initialView: "dayGridMonth",
    headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
    },
    eventColor: "#4e73df",
    themeSystem: "bootstrap",
    navLinks: true,
    editable: false,
    selectable: false,
    locale: "ar",
    numberLocale: "fr",

    events: toRaw(props.activities),

    eventClick(info) {
        router.get(route("activities.edit", info.event.id));
    },
});

onMounted(() => {
    calendarOptions.events = toRaw(props.activities);
});

const eventRefreshKey = ref(0);

watchEffect(() => {
    eventRefreshKey.value++; // This will force the FullCalendar component to refresh
}, props.activities);

const form = useForm({
    id: "",
    title: "",
    description: "",
    start: "",
    end: "",
    location: "",
});

const submit = () => {
    form.post(route("activities.store"), {
        onSuccess: () => {
            closeModal();
            form.reset("title", "description", "start", "end", "location");
            page.value.$inertia.$refresh(); // This will refresh the page
        },
    });
};

const isModalOpen = ref(false);
const isDropdownOpen = ref(false);

const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const toggleModal = () => {
    isModalOpen.value = !isModalOpen.value;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const isPopoverVisible = ref(false);
const popoverContent = ref("");
const popoverX = ref(0);
const popoverY = ref(0);

const handleEventClick = ({ el, event }) => {
    const rect = el.getBoundingClientRect();

    popoverContent.value = event.title;
    popoverX.value = rect.right;
    popoverY.value = rect.top;
    isPopoverVisible.value = true;
};
</script>

<template>
    <div class="bg-white p-6 shadow-sm">
        <FullCalendar v-bind:options="calendarOptions" :key="eventRefreshKey" />
    </div>
</template>

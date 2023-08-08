<template>
    {{ formDiplome.files }}
    <!-- Add diploma -->
    <a-modal
        @cancel="closeAddDiplomeModal"
        :footer="null"
        v-model:open="isAddDiplomeModalOpen"
        :title="$t('supervisors.diplome_add')"
    >
        <form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
            @submit.prevent="submitDiplome"
        >
            <div>
                <label
                    for="title"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("classes.category") }}</label
                >
                <input
                    v-model="formDiplome.name"
                    type="text"
                    name="title"
                    id="title"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 :bg-gray-600 :border-gray-500 :placeholder-gray-400 :text-white"
                />
            </div>
            <label
                for="title"
                class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                >images</label
            >

            <a-upload
                :customRequest="addFile"
                list-type="picture-card"
                @preview="handlePreview"
            >
                <div v-if="formDiplome.files.length < 8">
                    <plus-outlined />
                    <div style="margin-top: 8px">Upload</div>
                </div>
            </a-upload>
            <a-modal
                :open="previewVisible"
                :title="previewTitle"
                :footer="null"
                @cancel="handleCancel"
            >
                <img alt="example" style="width: 100%" :src="previewImage" />
            </a-modal>

            <div class="mt-5 flex justify-end gap-x-2">
                <button
                    type="submit"
                    class="py-2 px-3 inline-flex justify-center bg-sky-400 items-center gap-2 rounded-md border font-semibold text-white focus:outline-none"
                >
                    {{ $t("buttons.ajouter") }}
                </button>
            </div>
        </form>
    </a-modal>

    <!-- attach classes -->
    <a-modal
        @cancel="closeAddClasseModal"
        :footer="null"
        v-model:open="isAddClasseModalOpen"
        :title="$t('classes.modal_ajouter')"
    >
        <form
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
            class="space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
            @submit.prevent="attachClasses"
        >
            <div>
                <label
                    for="title"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("classes.category") }}</label
                >
                <Multiselect
                    v-model="selectedCategory"
                    :close-on-select="true"
                    :searchable="true"
                    :create-option="true"
                    :options="formattedCategories"
                />
            </div>
            <div>
                <label
                    for="title"
                    class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                    >{{ $t("classes.classes") }}</label
                >
                <Multiselect
                    v-model="formClasses.classes"
                    mode="tags"
                    :close-on-select="false"
                    :searchable="true"
                    :create-option="true"
                    :options="formattedClasses"
                />
            </div>
            <div class="mt-5 flex justify-end gap-x-2">
                <button
                    type="submit"
                    class="py-2 px-3 inline-flex justify-center bg-sky-400 items-center gap-2 rounded-md border font-semibold text-white focus:outline-none"
                >
                    {{ $t("buttons.ajouter") }}
                </button>
            </div>
        </form>
    </a-modal>

    <div class="w-auto py-4 px-2 h-screen">
        <h2
            class="text-xl font-semibold text-black-600 mb-4"
            :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
        >
            {{ $t("supervisors.info_supervisor") }}
        </h2>
        <a-config-provider :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'">
            <a-card :bordered="false" class="h-screen">
                <a-tabs
                    v-model:activeKey="activeKey"
                    :tab-position="$i18n.locale === 'ar' ? 'right' : 'left'"
                    :style="{ height: '200px' }"
                >
                    <!-- Info perso -->
                    <a-tab-pane
                        key="1"
                        :tab="$t('supervisors.info_supervisor')"
                    >
                        <a-row :gutter="16" type="flex" justify="center">
                            <a-col :md="24" :lg="16">
                                <form
                                    class="flex flex-col gap-2 space-y-2 px-2 lg:px-2 pb-2 sm:pb-2 xl:pb-2"
                                    :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                                    @submit.prevent="submit"
                                >
                                    <div>
                                        <label
                                            for="title"
                                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                            >{{ $t("supervisors.first_name")
                                            }}<span class="text-red-600"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            :disabled="!isEnabled"
                                            :class="{
                                                'bg-slate-100 cursor-not-allowed':
                                                    !isEnabled,
                                            }"
                                            v-model="form.first_name"
                                            type="text"
                                            name="title"
                                            id="title"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        />
                                        <span
                                            v-if="form.errors.first_name"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.first_name }}
                                        </span>
                                    </div>

                                    <div>
                                        <label
                                            for="title"
                                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                            >{{ $t("supervisors.last_name")
                                            }}<span class="text-red-600"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            :disabled="!isEnabled"
                                            :class="{
                                                'bg-slate-100 cursor-not-allowed':
                                                    !isEnabled,
                                            }"
                                            v-model="form.last_name"
                                            type="text"
                                            name="title"
                                            id="title"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        />
                                        <span
                                            v-if="form.errors.last_name"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.last_name }}
                                        </span>
                                    </div>

                                    <div>
                                        <label
                                            for="cin"
                                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                            >{{ $t("adherents.input_cin")
                                            }}<span class="text-red-600"
                                                >*</span
                                            ></label
                                        >
                                        <input
                                            :disabled="!isEnabled"
                                            :class="{
                                                'bg-slate-100 cursor-not-allowed':
                                                    !isEnabled,
                                            }"
                                            v-model="form.cin"
                                            type="text"
                                            name="cin"
                                            id="cin"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        />
                                        <span
                                            v-if="form.errors.cin"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.cin }}
                                        </span>
                                    </div>
                                    <div>
                                        <label
                                            for="date_of_birth"
                                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                            >{{
                                                $t(
                                                    "adherents.input_date_naissance",
                                                )
                                            }}<span class="text-red-600"
                                                >*</span
                                            >
                                        </label>

                                        <input
                                            :disabled="!isEnabled"
                                            :class="{
                                                'bg-slate-100 cursor-not-allowed':
                                                    !isEnabled,
                                            }"
                                            v-model="form.date_of_birth"
                                            type="date"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                            placeholder="Select date"
                                            name="date_of_birth"
                                        />
                                        <span
                                            v-if="form.errors.date_of_birth"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.date_of_birth }}
                                        </span>
                                    </div>

                                    <div>
                                        <label
                                            for="hs-about-hire-us-1"
                                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                            >{{ $t("adherents.input_addresse")
                                            }}<span class="text-red-600"
                                                >*</span
                                            ></label
                                        >
                                        <textarea
                                            :disabled="!isEnabled"
                                            :class="{
                                                'bg-slate-100 cursor-not-allowed':
                                                    !isEnabled,
                                            }"
                                            v-model="form.address"
                                            id="address"
                                            name="address"
                                            rows="2"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        ></textarea>
                                        <span
                                            v-if="form.errors.address"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.address }}
                                        </span>
                                    </div>
                                    <div>
                                        <label
                                            for="tel"
                                            class="text-sm font-medium text-gray-900 block mb-2 :text-gray-300"
                                            >{{
                                                $t("adherents.input_telephone")
                                            }}
                                        </label>
                                        <input
                                            :disabled="!isEnabled"
                                            :class="{
                                                'bg-slate-100 cursor-not-allowed':
                                                    !isEnabled,
                                            }"
                                            v-model="form.tel"
                                            type="text"
                                            name="tel"
                                            id="tel"
                                            autocomplete="text"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        />
                                        <span
                                            v-if="form.errors.tel"
                                            class="text-xs text-red-600 mt-1"
                                            id="hs-validation-name-error-helper"
                                        >
                                            {{ form.errors.tel }}
                                        </span>
                                    </div>
                                    <div
                                        class="mt-5 flex justify-start gap-x-2"
                                    >
                                        <button
                                            v-if="isEnabled"
                                            type="submit"
                                            class="py-2 px-3 inline-flex justify-center bg-sky-400 items-center gap-2 rounded-md border font-semibold text-white focus:outline-none"
                                        >
                                            {{ $t("buttons.enregistrer") }}
                                        </button>
                                        <button
                                            type="button"
                                            @click="toggleEnabled"
                                            class="py-2 px-3 inline-flex justify-center bg-sky-400 items-center gap-2 rounded-md border font-semibold text-white focus:outline-none"
                                        >
                                            <Pencil />
                                        </button>
                                    </div>
                                </form>
                            </a-col>
                            <a-col
                                :order="1"
                                :md="24"
                                :lg="8"
                                :style="{ maxHeight: '180px' }"
                                class="flex justify-start items-center flex-col gap-2"
                            >
                                <ImageUpload
                                    v-model="form.image"
                                    :default-src="'/storage/' + form.image"
                                />

                                <el-button
                                    v-if="isEnabled"
                                    type="primary"
                                    :icon="Edit"
                                    circle
                                    @click="updateImage"
                                />
                            </a-col>
                        </a-row>
                    </a-tab-pane>

                    <!-- diploma -->
                    <a-tab-pane key="2" :tab="$t('supervisors.diplomes')">
                        <div
                            class="gap-2 py-1 mb-2 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
                        >
                            <a-tooltip>
                                <template #title>
                                    {{
                                        $t("supervisors.diplome_add")
                                    }}</template
                                >
                                <el-button
                                    @click="isAddDiplomeModalOpen = true"
                                    class="me-auto"
                                    type="primary"
                                    size="large"
                                >
                                    <Plus />
                                </el-button>
                            </a-tooltip>
                        </div>
                        <a-config-provider
                            :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                        >
                            <a-table
                                :columns="diplomaColumns"
                                :data-source="diplomaRows"
                                :pagination="{
                                    pageSize: pageSize.value,
                                    showSizeChanger: true,
                                    pageSizeOptions: ['10', '20', '30', '40'],
                                }"
                            >
                                <template v-slot:action="{}">
                                    <el-button type="danger" size="small"
                                        ><TrashCan
                                    /></el-button>
                                </template> </a-table
                        ></a-config-provider>
                    </a-tab-pane>

                    <!-- classes -->
                    <a-tab-pane key="3" :tab="$t('supervisors.classes')">
                        <div
                            class="gap-2 py-1 mb-2 justify-between items-center block sm:flex md:divide-x md:divide-gray-100 dark:divide-gray-700"
                        >
                            <a-tooltip>
                                <template #title>
                                    {{ $t("classes.modal_ajouter") }}</template
                                >
                                <el-button
                                    class="me-auto"
                                    type="primary"
                                    size="large"
                                    @click="isAddClasseModalOpen = true"
                                >
                                    <Plus />
                                </el-button>
                            </a-tooltip>
                        </div>
                        <a-config-provider
                            :direction="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
                        >
                            <a-table
                                :columns="columns"
                                :data-source="rows"
                                :pagination="{
                                    pageSize: pageSize.value,
                                    showSizeChanger: true,
                                    pageSizeOptions: ['10', '20', '30', '40'],
                                }"
                            >
                                <template v-slot:action="{ record }">
                                    <el-button
                                        type="danger"
                                        size="small"
                                        @click="detachClasse(record.id)"
                                        ><TrashCan
                                    /></el-button>
                                </template> </a-table
                        ></a-config-provider>
                    </a-tab-pane>
                </a-tabs>

                <!-- <avatar-modal ref="modal" @ok="setavatar" /> -->
            </a-card>
        </a-config-provider>
    </div>
</template>

<script>
import MainLayout from "../../Layouts/MainLayout.vue";
import AvatarModal from "../../Components/AvatarModal.vue";
export default {
    layout: MainLayout,
    components: {
        AvatarModal,
    },
    data() {
        return {
            // cropper
            preview: {},
            option: {
                // img: "/avatar2.jpg",
                img: "",
                info: true,
                size: 1,
                outputType: "jpeg",
                canScale: false,
                autoCrop: true,
                autoCropWidth: 180,
                autoCropHeight: 180,
                fixedBox: true,
                fixed: true,
                fixedNumber: [1, 1],
            },
        };
    },
};
</script>
<script setup>
import Multiselect from "@vueform/multiselect";
import Swal from "sweetalert2";
import Toast from "../../utils.js";
import { Edit } from "@element-plus/icons-vue";
import defaultImg from "../../../assets/image.jpeg";
import ImageUpload from "../../Components/ImageUpload.vue";
import Plus from "vue-material-design-icons/Plus.vue";
import TrashCan from "vue-material-design-icons/TrashCan.vue";
import Pencil from "vue-material-design-icons/Pencil.vue";
import { router, useForm } from "@inertiajs/vue3";
import { ref, computed, watchEffect, onMounted } from "vue";
import { PlusOutlined } from "@ant-design/icons-vue";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = (error) => reject(error);
    });
}

const addFile = async ({ file, onSuccess, onError }) => {
    console.log(file);
    try {
        formDiplome.files.push(file);
        setTimeout(() => {
            onSuccess("ok");
        }, 1000); // 1 second delay
    } catch (e) {
        onError(e);
    }
};
const previewVisible = ref(false);
const previewImage = ref("");
const previewTitle = ref("");

const handleCancel = () => {
    previewVisible.value = false;
    previewTitle.value = "";
};
const handlePreview = async (file) => {
    if (!file.url && !file.preview) {
        file.preview = (await getBase64(file.originFileObj)).toString();
    }
    previewImage.value = file.url || file.preview;
    previewVisible.value = true;
    previewTitle.value =
        file.name || file.url.substring(file.url.lastIndexOf("/") + 1);
};

const isEnabled = ref(false);

const selectedCategory = ref(null);
const selectedClasses = ref([]);

const props = defineProps({
    supervisor: {
        type: Object,
        default: () => ({}),
    },
    categories: {
        type: Object,
        default: () => [],
    },
});
const toggleEnabled = () => {
    isEnabled.value = !isEnabled.value;
};
const isAddClasseModalOpen = ref(false);
const closeAddClasseModal = () => {
    isAddClasseModalOpen.value = false;
    selectedCategory.value = null;
    formClasses.classes = [];
};

const isAddDiplomeModalOpen = ref(false);

const closeAddDiplomeModal = () => {
    isAddDiplomeModalOpen.value = false;
    // selectedDiplome.value = null;
    // formDiplomes.diplomes = [];
};

const pageSize = ref(10);

const formDiplome = useForm({
    name: "",
    files: [],
});

const form = useForm({
    id: props.supervisor.id,
    first_name: props.supervisor.first_name,
    last_name: props.supervisor.last_name,
    cin: props.supervisor.cin,
    tel: props.supervisor.tel,
    address: props.supervisor.address,
    date_of_birth: props.supervisor.date_of_birth,
    image: props.supervisor.image,
});

const columns = computed(() => [
    {
        title: "#",
        dataIndex: "id",
        key: "id",
    },
    {
        title: t("classes.table_nom"),
        dataIndex: "name",
        key: "name",
        sorter: {
            compare: (a, b) => a.name.localeCompare(b.name),
        },
        multipe: 1,
    },
    {
        title: t("classes.category"),
        dataIndex: "category",
        key: "category",
        sorter: {
            compare: (a, b) => a.category.localeCompare(b.category),
        },
    },
    {
        title: t("classes.adherent_count"),
        key: "adherents_count",
        dataIndex: "adherents_count",
        sorter: {
            compare: (a, b) => a.adherents_count - b.adherents_count,
        },
    },
    {
        title: "Action",
        key: "action",
        slots: { customRender: "action" },
    },
]);
const rows = computed(() =>
    Object.values(props.supervisor.classes).map((classe) => ({
        id: classe.id,
        name: classe.name,
        category: classe.category.name,
        adherents: classe.adherents,
        adherents_count: classe.adherents.length,
    })),
);

const diplomaColumns = computed(() => [
    {
        title: "#",
        dataIndex: "id",
        key: "id",
    },
    {
        title: "name",
        dataIndex: "name",
        key: "name",
    },

    {
        title: "Action",
        key: "action",
        slots: { customRender: "action" },
    },
]);

const diplomaRows = computed(() =>
    Object.values(props.supervisor.diplomes).map((diplome) => ({
        id: diplome.id,
        name: diplome.name,
    })),
);

const formClasses = useForm({
    classes: [],
});

const updateImage = () => {
    if (!form.image) {
        Toast.fire({
            icon: "error",
            title: t("toasts.modif_error"),
        });
        return;
    }

    router.post(
        `/supervisors/updateImage/${props.supervisor.id}`,
        {
            _method: "put",
            headers: {
                "Content-Type": "multipart/form-data",
            },
            image: form.image,
        },
        {
            onSuccess: () => {
                Toast.fire({
                    icon: "success",
                    title: t("toasts.modif_success"),
                });
            },
            onError: () => {
                Toast.fire({
                    icon: "error",
                    title: t("toasts.modif_error"),
                });
            },
        },
    );
};

const submit = () => {
    form.put(route("supervisors.update", form.id), {
        // forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            Toast.fire({
                icon: "success",
                title: t("toasts.modif_success"),
            });
        },
        onError: () => {
            Toast.fire({
                icon: "success",
                title: t("toasts.modif_error"),
            });
        },
    });
};

const submitDiplome = () => {
    router.post(
        `/supervisors/${form.id}/diplomes`,
        {
            _method: "post",
            headers: {
                "Content-Type": "multipart/form-data",
            },
            name: formDiplome.name,
            file_paths: formDiplome.files,
        },
        {
            onSuccess: () => {
                closeAddDiplomeModal();
                Toast.fire({
                    icon: "success",
                    title: t("toasts.modif_success"),
                });
            },
            onError: () => {
                Toast.fire({
                    icon: "success",
                    title: t("toasts.modif_error"),
                });
            },
        },
    );

    formDiplome.post(route("diplomes.store", form.id), {
        // forceFormData: true,
        preserveScroll: true,
        onSuccess: () => {
            Toast.fire({
                icon: "success",
                title: t("toasts.modif_success"),
            });
            isEnabled.value = false;
        },
        onError: () => {
            Toast.fire({
                icon: "success",
                title: t("toasts.modif_error"),
            });
        },
    });
};

const detachClasse = (id) => {
    Swal.fire({
        text: t("modals_questions.supprimer"),
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: t("buttons.supprimer"),
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(`/supervisors/${props.supervisor.id}/classes/${id}`, {
                preserveScroll: true,
                onSuccess: () => {
                    Toast.fire({
                        icon: "success",
                        title: t("toasts.supp_success"),
                    });
                },
                onError: () => {
                    Toast.fire({
                        icon: "error",
                        title: t("toasts.supp_error"),
                    });
                },
            });
        }
    });
};
const formattedCategories = computed(() =>
    Object.values(props.categories).map((category) => ({
        value: category.id,
        label: category.name,
    })),
);

const formattedClasses = computed(() =>
    Object.values(selectedClasses.value).map((classe) => ({
        value: classe.id,
        label: classe.name,
    })),
);
const selectClasses = () => {
    const category = props.categories.find(
        (cat) => cat.id === selectedCategory.value,
    );

    if (category) {
        const supervisorClassIds = props.supervisor.classes.map(
            (cls) => cls.id,
        );
        selectedClasses.value = category.classes.filter(
            (cls) => !supervisorClassIds.includes(cls.id),
        );
    } else {
        selectedClasses.value = [];
    }
};

const attachClasses = () => {
    router.post(
        `/supervisors/${props.supervisor.id}/classes`,
        {
            _method: "post",
            headers: {
                "Content-Type": "multipart/form-data",
            },
            classes: formClasses.classes,
        },
        {
            onSuccess: () => {
                Toast.fire({
                    icon: "success",
                    title: t("toasts.modif_success"),
                });
                closeAddClasseModal();
            },
            onError: () => {
                Toast.fire({
                    icon: "error",
                    title: t("toasts.modif_error"),
                });
            },
        },
    );
};

watchEffect(() => {
    selectClasses();
});
const activeKey = ref("1");
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>
/* you can make up upload button and sample style by using stylesheets */
.ant-upload-select-picture-card i {
    font-size: 32px;
    color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
    margin-top: 8px;
    color: #666;
}
</style>

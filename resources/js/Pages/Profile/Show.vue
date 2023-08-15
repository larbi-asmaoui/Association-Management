<script>
import RootLayout from "../../Layouts/RootLayout.vue";

export default {
    layout: RootLayout,
};
</script>

<script setup>
import DeleteUserForm from "@/Pages/Profile/Partials/DeleteUserForm.vue";
import LogoutOtherBrowserSessionsForm from "@/Pages/Profile/Partials/LogoutOtherBrowserSessionsForm.vue";
import SectionBorder from "@/Components/SectionBorder.vue";
import TwoFactorAuthenticationForm from "@/Pages/Profile/Partials/TwoFactorAuthenticationForm.vue";
import UpdatePasswordForm from "@/Pages/Profile/Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "@/Pages/Profile/Partials/UpdateProfileInformationForm.vue";
import { useI18n } from "vue-i18n";
const { t } = useI18n();
defineProps({
    confirmsTwoFactorAuthentication: Boolean,
    sessions: Array,
});
</script>

<template>
    <h3
        class="text-gray-700 text-3xl mb-8 font-medium"
        :class="$i18n.locale === 'ar' ? 'text-right' : 'text-left'"
    >
        {{ $t("profile.titre") }}
    </h3>
    <div class="mt-4" :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'">
        <!-- <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"> -->
        <div v-if="$page.props.jetstream.canUpdateProfileInformation">
            <UpdateProfileInformationForm :user="$page.props.auth.user" />

            <SectionBorder />
        </div>

        <div v-if="$page.props.jetstream.canUpdatePassword">
            <UpdatePasswordForm />

            <SectionBorder />
        </div>

        <template v-if="$page.props.jetstream.hasAccountDeletionFeatures">
            <DeleteUserForm />
        </template>
    </div>
</template>

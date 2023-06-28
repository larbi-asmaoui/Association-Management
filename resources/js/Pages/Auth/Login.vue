<script setup>
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { useI18n } from "vue-i18n";
const { t } = useI18n();

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: "",
    password: "",
    remember: false,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        remember: form.remember ? "on" : "",
    })).post(route("login"), {
        onFinish: () => form.reset("password"),
    });
};
</script>

<template>
    <Head title="Login" />

    <AuthenticationCard>
        <!-- <template #logo>
            <AuthenticationCardLogo />
        </template> -->

        <form
            class="mt-8 space-y-6"
            @submit.prevent="submit"
            :dir="$i18n.locale === 'ar' ? 'rtl' : 'ltr'"
        >
            <div>
                <label
                    for="email"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >{{ $t("profile.input_email") }}</label
                >
                <input
                    v-model="form.email"
                    type="email"
                    name="email"
                    id="email"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    placeholder="name@gmail.com"
                    required
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>
            <div>
                <label
                    for="password"
                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                    >{{ $t("profile.input_mot_de_passe") }}</label
                >
                <input
                    v-model="form.password"
                    type="password"
                    name="password"
                    id="password"
                    placeholder="••••••••"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                    required
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>
            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox v-model:checked="form.remember" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{
                        $t("profile.remember_me")
                    }}</span>
                </label>
            </div>
            <div class="flex items-center justify-start me-4">
                <PrimaryButton
                    class="me-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    {{ $t("profile.login") }}
                </PrimaryButton>
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    {{ $t("profile.forgot") }}
                </Link>
            </div>
            <!-- <div
                class="text-sm text-center font-medium text-gray-500 dark:text-gray-400"
            >
                Pas de compte ?
                <Link
                    :href="route('register')"
                    class="text-primary-700 hover:underline dark:text-primary-500"
                >
                    Créer un compte
                </Link>
            </div> -->
        </form>
    </AuthenticationCard>
</template>

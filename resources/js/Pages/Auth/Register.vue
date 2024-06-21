<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const errors = ref({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const validate = () => {
    let valid = true;

    // Validate name
    if (form.name.length < 2 || form.name.length > 20) {
        errors.value.name = 'El nombre debe tener entre 2 y 20 caracteres.';
        valid = false;
    } else {
        errors.value.name = '';
    }

    // Validate email
    if (form.email.length < 2 || form.email.length > 60) {
        errors.value.email = 'El email debe tener entre 2 y 60 caracteres.';
        valid = false;
    } else {
        errors.value.email = '';
    }

    // Validate password
    if (form.password.length < 2 || form.password.length > 30) {
        errors.value.password = 'La contraseña debe tener entre 2 y 30 caracteres.';
        valid = false;
    } else {
        errors.value.password = '';
    }

    // Validate password confirmation
    if (form.password_confirmation.length < 2 || form.password_confirmation.length > 30) {
        errors.value.password_confirmation = 'La confirmación de la contraseña debe tener entre 2 y 30 caracteres.';
        valid = false;
    } else {
        errors.value.password_confirmation = '';
    }

    return valid;
};

const submit = () => {
    if (validate()) {
        form.post(route('register'), {
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    }
};

blur(form, validate);
</script>

<template>
    <GuestLayout>
        <Head title="Creación de cuenta" />

        <!-- Imagen de fondo -->
        <div class="fixed inset-0 z-0 bg-cover bg-center" style="background-image: url('/storage/images/elotes.jpg');"></div>

        <!-- Contenido -->
        <div class="relative z-10 min-h-screen flex flex-col items-center justify-center">
            <form @submit.prevent="submit" class="w-full max-w-xl p-8 bg-white bg-opacity-75 rounded-lg shadow-md dark:bg-gray-800 dark:bg-opacity-75">
                <div>
                    <InputLabel for="name" value="Nombre" />

                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="errors.name" />

                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="mt-4">
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="errors.email" />

                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password" value="Contraseña" />

                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="errors.password" />

                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="mt-4">
                    <InputLabel for="password_confirmation" value="Repetir contraseña" />

                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="errors.password_confirmation" />

                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link
                        :href="route('login')"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        ¿Posee una cuenta?
                    </Link>

                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Crear cuenta
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const errors = ref({
    email: '',
    password: '',
});

const validate = () => {
    let valid = true;

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

    return valid;
};

const submit = () => {
    if (validate()) {
        form.post(route('login'), {
            onFinish: () => form.reset('password'),
        });
    }
};
</script>

<template class="gradient-background">
    <GuestLayout class="gradient-background">
        <Head title="Log in" />

        <div>
            <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                {{ status }}
            </div>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="email" value="Email" />

                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
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
                        autocomplete="current-password"
                    />

                    <InputError class="mt-2" :message="errors.password" />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="block mt-4">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Recuerdame :)</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Iniciar sesión
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </GuestLayout>
</template>

<style scoped>
.gradient-background {
    background: linear-gradient(to right, #91EAE4, #86A8E7, #7F7FD5);
    color: white;
}
</style>

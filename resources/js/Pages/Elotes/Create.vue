<template>
    <Head title="Crear Elote" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Crear Elote</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                <input type="text" v-model="form.nombre" class="mt-1 block w-full" id="nombre" required>
                            </div>

                            <div class="mb-4">
                                <label for="precio" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                                <input type="number" v-model="form.precio" class="mt-1 block w-full" id="precio" required>
                            </div>

                            <div class="mb-4">
                                <label for="cantidad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                                <input type="number" v-model="form.cantidad" class="mt-1 block w-full" id="cantidad" required>
                            </div>

                            <div class="mb-4">
                                <label for="imagen" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagen (URL)</label>
                                <input type="text" v-model="form.imagen" class="mt-1 block w-full" id="imagen">
                            </div>

                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Elote</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    precio: '',
    imagen: '',
    cantidad: ''
});

const submit = () => {
    form.post(route('elotes.store'));
};
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>

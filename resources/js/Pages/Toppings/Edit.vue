<template>
    <Head title="Editar Topping" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Editar Topping</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="updateTopping">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                <input v-model="form.nombre" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700" required />
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Precio</label>
                                <input v-model="form.precio" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700" required />
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Actualizar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3';

const { props } = usePage();
const topping = props.topping;

const form = useForm({
    nombre: topping.nombre || '',
    precio: topping.precio || '',
});

const updateTopping = () => {
    form.put(route('toppings.update', topping.id));
};
</script>

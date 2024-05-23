<template>
    <Head title="Suministros" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Suministros</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <img src="/images/logo1.jpg" alt="Logo" class="mb-4">
                        
                        <p class="text-lg font-semibold mb-2">Control de Suministros</p>
                        <button @click="goToCreate('topping')" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Agregar Topping</button>
                        
                        <table class="min-w-full bg-white dark:bg-red-800">
                            <thead>
                                <tr>
                                    <th class="py-2">Nombre</th>
                                    <th class="py-2">Precio</th>
                                    <th class="py-2">Cantidad</th>
                                    <th class="py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="topping in toppings" :key="topping.id" class="bg-gray-100 dark:bg-gray-700">
                                    <td class="py-2 px-4">{{ topping.nombre }}</td>
                                    <td class="py-2 px-4">${{ topping.precio }}</td>
                                    <td class="py-2 px-4">{{ topping.cantidad }}</td>
                                    <td class="py-2 px-4">
                                        <button @click="editTopping(topping.id)" class="bg-green-500 text-white px-2 py-1 rounded mr-2">Editar</button>
                                        <button @click="deleteTopping(topping.id)" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <p class="text-lg font-semibold mt-6 mb-2">Control de Elotes</p>
                        <button @click="goToCreate('elote')" class="bg-blue-500 text-white px-4 py-2 rounded mb-4">Agregar Elote</button>
                        
                        <table class="min-w-full bg-white dark:bg-green-800">
                            <thead>
                                <tr>
                                    <th class="py-2">Nombre</th>
                                    <th class="py-2">Precio</th>
                                    <th class="py-2">Cantidad</th>
                                    <th class="py-2">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="elote in elotes" :key="elote.id" class="bg-gray-100 dark:bg-gray-700">
                                    <td class="py-2 px-4">{{ elote.nombre }}</td>
                                    <td class="py-2 px-4">${{ elote.precio }}</td>
                                    <td class="py-2 px-4">{{ elote.cantidad }}</td>
                                    <td class="py-2 px-4">
                                        <button @click="editElote(elote.id)" class="bg-green-500 text-white px-2 py-1 rounded mr-2">Editar</button>
                                        <button @click="deleteElote(elote.id)" class="bg-red-500 text-white px-2 py-1 rounded">Eliminar</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3';

const { props } = usePage();
const elotes = props.elotes || [];
const toppings = props.toppings || [];

const goToCreate = (type) => {
    const routeName = type === 'elote' ? 'elotes.create' : 'toppings.create';
    router.get(route(routeName));
};

const editElote = (id) => {
    router.get(route('elotes.edit', id));
};

const editTopping = (id) => {
    router.get(route('toppings.edit', id));
};

const deleteElote = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este elote?')) {
        router.delete(route('elotes.destroy', id));
    }
};

const deleteTopping = (id) => {
    if (confirm('¿Estás seguro de que deseas eliminar este topping?')) {
        router.delete(route('toppings.destroy', id));
    }
};
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>

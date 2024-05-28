<template>
    <Head title="Pedidos" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Suministros</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <img src="/storage/images/logo1.jpg" alt="Logo" class="mb-4 lg:px-20">

                        <p class="text-6xl font-semibold mb-2">¡Solicitar elotes!</p>

                        <form @submit.prevent="addToCart('elote')">
                            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <template v-for="elote in elotes" :key="elote.id">
                                    <label class="flex items-center justify-between border-2 rounded-md p-4 bg-white dark:bg-gray-700 text-black dark:text-white" :class="{ 'bg-blue-100 border-blue-500': selectedElotes.includes(elote.id) }">
                                        <div class="flex items-center">
                                            <input type="checkbox" :value="elote.id" v-model="selectedElotes" class="form-checkbox h-6 w-6 text-blue-600 rounded-md">
                                            <span class="ml-2 text-lg font-semibold">{{ elote.nombre }} - ${{ elote.precio }}</span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                            <div class="mb-4">
                                <label for="eloteQuantity" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Cantidad de elotes:</label>
                                <input type="number" id="eloteQuantity" v-model.number="eloteQuantity" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                    
                     

                        <p class="text-1xl font-semibold mt-6 mb-2">Control de Elotes</p>
                     
                            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <template v-for="topping in toppings" :key="topping.id">
                                    <label class="flex items-center justify-between border-2 rounded-md p-4 bg-white dark:bg-gray-700 text-black dark:text-white" :class="{ 'bg-blue-100 border-blue-500': selectedToppings.includes(topping.id) }">
                                        <div class="flex items-center">
                                            <input type="checkbox" :value="topping.id" v-model="selectedToppings" class="form-checkbox h-6 w-6 text-blue-600 rounded-md">
                                            <span class="ml-2 text-lg font-semibold">{{ topping.nombre }} - ${{ topping.precio }}</span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Agregar al carrito</button>
                        </form>

                        <div class="mt-12">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tu carrito de compras</h2>
                            <div v-if="carrito.length === 0">
                                <p>El carrito está vacío</p>
                            </div>
                            <div v-else>
                                <div class="Carrito-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div v-for="(item, index) in carrito" :key="index" class="Elote-card flex flex-col items-center justify-center border-2 rounded-md p-4 bg-white dark:bg-gray-700 text-black dark:text-white shadow-md">
                                        <h3 class="text-2xl font-bold mb-4">Orden</h3>
                                        <p class="mb-2">Tipo de Elote: {{ item.tipoElote }}</p>
                                        <p class="mb-2">Cantidad de elotes: {{ item.cantidad }}</p>
                                        <p class="mb-2">Toppings:</p>
                                        <ul class="mb-4">
                                            <li v-for="topping in item.toppings" :key="topping.id">{{ topping.nombre }}</li>
                                        </ul>
                                        <p class="mb-4">Precio total: ${{ item.precioTotal }}</p>
                                        <button @click="removeFromCart(index)" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                                    </div>
                                </div>
                                <button @click="checkout" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Realizar Pedido</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

const { props } = usePage();
const elotes = props.elotes || [];
const toppings = props.toppings || [];
let selectedElotes = [];
let selectedToppings = [];
let eloteQuantity = 1;

const carrito = ref([
    {
        tipoElote: 'Esquite',
        cantidad: 3,
        toppings: [{ id: 1, nombre: 'Crema' }, { id: 2, nombre: 'Queso' }],
        precioTotal: 45
    },
    {
        tipoElote: 'Cocido',
        cantidad: 2,
        toppings: [{ id: 3, nombre: 'Mantequilla' }, { id: 4, nombre: 'Sal' }],
        precioTotal: 36
    }
]);

const addToCart = (type) => {
    let items = [];
    if (type === 'elote') {
        items = selectedElotes.map(eloteId => ({
            id: eloteId,
            type: 'elote',
            quantity: eloteQuantity
        }));
    } else if (type === 'topping') {
        items = selectedToppings.map(toppingId => ({
            id: toppingId,
            type: 'topping',
            quantity: 1 // Default quantity for toppings
        }));
    }

    if (items.length > 0) {
        router.get(route('cart.addItems', { items }));
    }
};

const removeFromCart = (index) => {
    carrito.value.splice(index, 1);
};

const checkout = () => {
    // Lógica para realizar el pedido
    alert('Pedido realizado');
};
</script>

<style scoped>
.Carrito-container {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
}

.Elote-card {
    background-color: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding: 1rem;
    width: 100%;
    max-width: 300px;
    transition: background-color 0.3s ease;
}

.Elote-card:hover {
    background-color: #f0f0f0;
}

.Elote-card h3 {
    font-size: 1.25rem;
    margin-bottom: 0.5rem;
}

.Elote-card p {
    margin: 0.25rem 0;
}

.Elote-card ul {
    list-style: none;
    padding: 0;
}

.Elote-card li {
    background-color: #e0e0e0;
    border-radius: 0.25rem;
    display: inline-block;
    margin: 0.25rem;
    padding: 0.25rem 0.5rem;
}
</style>

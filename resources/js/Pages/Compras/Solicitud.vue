<script setup>
import { ref, onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
const { props } = usePage();
const elotes = props.elotes || [];
const toppings = props.toppings || [];
const carrito = ref(props.carritos || []);

let selectedElotes = ref([]);
let selectedToppings = ref([]);
let eloteQuantity = ref(1);

const error = ref(null);
const AgregarAlCarrito = async () => {
    let items = [];

    selectedElotes.value.forEach(eloteId => {
        items.push({
            elote_id: eloteId,
            cantidad: eloteQuantity.value,
            toppings: selectedToppings.value.map(toppingId => ({ id: toppingId, cantidad: eloteQuantity.value }))
        });
    });

    console.log('Items to add:', items); // Ver qué se le manda al carrito

    if (items.length > 0) {
        try {
            const response = await router.post(route('solicitud.store'), { items });
           
            resetForm(); // Restablece el formulario después de agregar al carrito
        } catch (error) {
            console.error('Error al agregar al carrito:', error);
        }
    }
};

const resetForm = () => {
    selectedElotes.value = [];
    selectedToppings.value = [];
    eloteQuantity.value = 1;
};


const EliminarDelCarrito = async (index) => {
    try {
        const carritoItem = carrito.value[index];
        await router.delete(route('solicitud.destroy', { id: carritoItem.id }));
        carrito.value.splice(index, 1);
    } catch (error) {
        console.error('Error al eliminar del carrito:', error);
    }
};

// Redirigir para realizar el pago
const IrPedido = () => {   
    router.visit('pedidos');
};

onMounted(() => {
    if (!carrito.value.length) {
        error.value = 'El carrito está vacío';
    }
});
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Pedidos" />
        <template #header>
            <h2 class="font-extrabold text-6xl text-gray-800 dark:text-gray-200 leading-tight text-shadow-custom">Arme su pedido</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="AgregarAlCarrito">
                            <p class="text-4xl font-semibold mb-2">¡Solicitar elotes!</p>
                            <div class="mb-4">
                                <label for="eloteQuantity" class="block text-2xl text-gray-700 dark:text-gray-300">Cantidad de elotes:</label>
                                <input type="number" id="eloteQuantity" v-model.number="eloteQuantity" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                
                                <template v-for="elote in elotes" :key="elote.id">
                                    <label class="flex flex-col items-center border-2 rounded-md p-4 bg-white dark:bg-gray-700 text-black dark:text-white" :class="{ 'bg-blue-100 border-blue-500': selectedElotes.includes(elote.id) }">
                                        <img :src="elote.imagen" alt="Elote Image" class="mb-4 w-full h-40 object-cover rounded">
                                        <div class="flex items-center">
                                            <input type="checkbox" :value="elote.id" v-model="selectedElotes" class="form-checkbox h-6 w-6 text-blue-600 rounded-md">
                                            <span class="ml-2 text-lg font-semibold">{{ elote.nombre }} - ${{ elote.precio }}</span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                            <p class="text-2xl font-semibold mt-6 mb-2">Seleccione uno (o más) Toppings</p>
                            <div class="mb-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                <template v-for="topping in toppings" :key="topping.id">
                                    <label class="flex flex-col items-center border-2 rounded-md p-4 bg-white dark:bg-gray-700 text-black dark:text-white" :class="{ 'bg-blue-100 border-blue-500': selectedToppings.includes(topping.id) }">
                                        <img :src="topping.imagen" alt="Topping Image" class="mb-4 w-full h-40 object-cover rounded">
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
                            <div v-if="error">
                                <p>{{ error }}</p>
                            </div>
                            <div v-else-if="carrito.length === 0">
                                <p>El carrito está vacío</p>
                            </div>
                            <div v-else>
                                <div class="Carrito-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <div v-for="(item, index) in carrito" :key="index" class="Elote-card flex flex-col items-center justify-center border-2 rounded-md p-4 bg-white dark:bg-gray-700 text-black dark:text-white shadow-md">
                                        <h3 class="text-2xl font-bold mb-4 text-black">Orden</h3>
                                        <p class="mb-2 text-black"><strong>Tipo de Elote:</strong> {{ item.elote.nombre }}</p>
                                        <p class="mb-2 text-black"><strong>Cantidad de elotes:</strong> {{ item.cantidad }}</p>
                                        <p class="mb-2 text-black"><strong>Toppings:</strong></p>
                                        <ul class="mb-4 text-black">
                                            <li v-for="topping in item.toppings" :key="topping.id"><strong>{{ topping.nombre }}</strong></li>
                                        </ul>
                                        <p class="mb-4 text-black"><strong>Precio total:</strong> ${{ item.precioTotal }}</p>
                                        <button @click="EliminarDelCarrito(index)" class="bg-red-500 text-white px-4 py-2 rounded">Eliminar</button>
                                    </div>
                                </div>
                                <button @click="IrPedido" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Realizar Pedido</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

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

<style scoped>
.text-shadow-custom {
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
}
</style>
<script setup>
import { ref, reactive, onMounted } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const { props } = usePage();
const carrito = props.carritos || [];
const form = reactive({
    ciudad: '',
    colonia: '',
    calle: '',
    numero_exterior: '',
    numero_interior: '',
    email_paypal: '',
    paypal_id: '',
    estado: 'pendiente'
});

const submitForm = () => {
    useForm().post(route('confirmarPedido'), {
        data: form,
        onSuccess: () => {
            alert('Pedido confirmado con éxito');
        },
        onError: () => {
            alert('Error al confirmar el pedido');
        }
    });
};

// PayPal setup
const paypalRef = ref(null);

onMounted(() => {
    if (window.paypal) {
        window.paypal.Buttons({
            createOrder: (data, actions) => {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: carrito.reduce((total, item) => total + item.precioTotal, 0).toFixed(2)
                        }
                    }]
                });
            },
            onApprove: (data, actions) => {
                return actions.order.capture().then(details => {
                    form.paypal_id = details.id;
                    submitForm();
                });
            },
            onError: (err) => {
                console.error(err);
                alert('Error al procesar el pago con PayPal');
            }
        }).render(paypalRef.value);
    }
});

// Confirmar pedido con validación
const confirmarPedido = () => {
    if (confirm("¿Está seguro de que desea realizar el pedido?")) {
        submitForm();
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Confirmar Pedido" />
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Confirmar Pedido</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="banner-container mb-4">
                        <img src="/storage/images/banner.jpg" alt="Banner" class="banner-image">
                    </div>
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="confirmarPedido">
                            <div class="mb-4">
                                <label for="ciudad" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Ciudad</label>
                                <input type="text" id="ciudad" v-model="form.ciudad" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4">
                                <label for="colonia" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Colonia</label>
                                <input type="text" id="colonia" v-model="form.colonia" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4">
                                <label for="calle" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Calle</label>
                                <input type="text" id="calle" v-model="form.calle" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4">
                                <label for="numero_exterior" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número Exterior</label>
                                <input type="text" id="numero_exterior" v-model="form.numero_exterior" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4">
                                <label for="numero_interior" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Número Interior</label>
                                <input type="text" id="numero_interior" v-model="form.numero_interior" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4">
                                <label for="email_paypal" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email PayPal</label>
                                <input type="email" id="email_paypal" v-model="form.email_paypal" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div class="mb-4">
                                <label for="estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                                <input type="text" id="estado" v-model="form.estado" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </div>
                            <div id="paypal-button-container" ref="paypalRef"></div>
                            <button type="button" @click="confirmarPedido" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Confirmar Pedido</button>
                        </form>
                        <div class="mt-12">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Tu carrito de compras</h2>
                            <div v-if="!carrito.length">
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
                                    </div>
                                </div>
                                <button @click="confirmarPedido" class="bg-blue-500 text-white px-4 py-2 rounded mt-4">Realizar Pedido</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.banner-container {
    width: 100%;
    height: 200px; /* Ajusta la altura según sea necesario */
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
}

.banner-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

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

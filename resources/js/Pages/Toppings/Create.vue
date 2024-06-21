<template>
    <Head title="Crear Topping" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-3xl text-gray-800 dark:text-gray-200 leading-tight">Crear Topping</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form @submit.prevent="submit">
                            <div class="mb-4">
                                <label for="nombre" class="block text-3xl font-medium text-gray-700 dark:text-gray-300">Nombre</label>
                                <input 
                                    type="text" 
                                    v-model="form.nombre" 
                                    class="mt-1 block w-full" 
                                    id="nombre" 
                                    required 
                                    @blur="validateField('nombre')"
                                />
                                <span v-if="errors.nombre" class="text-red-500 text-sm">{{ errors.nombre }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="precio" class="block text-3xl font-medium text-gray-700 dark:text-gray-300">Precio</label>
                                <input 
                                    type="number" 
                                    v-model="form.precio" 
                                    class="mt-1 block w-full" 
                                    id="precio" 
                                    required 
                                    @blur="validateField('precio')"
                                />
                                <span v-if="errors.precio" class="text-red-500 text-sm">{{ errors.precio }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="cantidad" class="block text-3xl font-medium text-gray-700 dark:text-gray-300">Cantidad</label>
                                <input 
                                    type="number" 
                                    v-model="form.cantidad" 
                                    class="mt-1 block w-full" 
                                    id="cantidad" 
                                    required 
                                    @blur="validateField('cantidad')"
                                />
                                <span v-if="errors.cantidad" class="text-red-500 text-sm">{{ errors.cantidad }}</span>
                            </div>

                            <div class="mb-4">
                                <label for="imagen" class="block text-3xl font-medium text-gray-700 dark:text-gray-300">Imagen (URL)</label>
                                <input 
                                    type="text" 
                                    v-model="form.imagen" 
                                    class="mt-1 block w-full" 
                                    id="imagen" 
                                    required 
                                    @blur="validateField('imagen')"
                                />
                                <span v-if="errors.imagen" class="text-red-500 text-sm">{{ errors.imagen }}</span>
                            </div>

                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Crear Topping</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';

const form = useForm({
    nombre: '',
    precio: '',
    cantidad: '',
    imagen: ''
});

const errors = ref({
    nombre: '',
    precio: '',
    cantidad: '',
    imagen: ''
});

const validateField = (field) => {
    switch (field) {
        case 'nombre':
            if (form.nombre.length < 2 || form.nombre.length > 20) {
                errors.value.nombre = 'El nombre debe tener entre 2 y 20 caracteres.';
            } else {
                errors.value.nombre = '';
            }
            break;
        case 'precio':
            if (form.precio <= 0) {
                errors.value.precio = 'El precio debe ser mayor que 0.';
            } else {
                errors.value.precio = '';
            }
            break;
        case 'cantidad':
            if (form.cantidad <= 0) {
                errors.value.cantidad = 'La cantidad debe ser mayor que 0.';
            } else {
                errors.value.cantidad = '';
            }
            break;
        case 'imagen':
            if (!form.imagen) {
                errors.value.imagen = 'La URL de la imagen es requerida.';
            } else {
                errors.value.imagen = '';
            }
            break;
    }
};

const validate = () => {
    let valid = true;
    Object.keys(errors.value).forEach(field => {
        validateField(field);
        if (errors.value[field]) {
            valid = false;
        }
    });
    return valid;
};

const submit = () => {
    if (validate()) {
        form.post(route('toppings.store'));
    }
};
</script>

<style scoped>
/* Puedes agregar estilos personalizados aquí si es necesario */
</style>

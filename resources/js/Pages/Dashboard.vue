<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="p-6 text-gray-900 dark:text-gray-100 dark:bg-gray-800 flex items-center">
                <img src="/storage/images/logo1.jpg" alt="Logo" class="mb-6">
                <div class="ml-6">
                    <p class="text-6xl">¡Bienvenido!</p>
                    <p class="text-4xl mt-2">Los mejores elotes</p>
                    <div class="mt-4">
                        <button class="btn btn-primary me-2 text-3xl " @click="irAlPerfil">Ir al perfil</button>
                        <button class="btn btn-secondary text-3xl" @click="irASuministros">Agregar suministros</button>
                        <button class="btn text-3xl " @click="irAPedidos">Solicitar elotes</button>
                       
                    </div>
                </div>
            </div>
            </div>
    </AuthenticatedLayout>
</template>
class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
<script setup>
import { usePage, router } from '@inertiajs/vue3';

const irAlPerfil = () => {
    router.visit('/profile');
};

const irASuministros  = () => {
    router.visit('/supplies');
};


const irAPedidos = () => {
    router.visit('/pedido');

}



</script>

<style>
.btn {
    padding: 10px 20px;
    font-size: 16px;
}
</style>
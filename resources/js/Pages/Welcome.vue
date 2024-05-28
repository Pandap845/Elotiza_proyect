<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-cover bg-center min-h-screen flex flex-col items-center" :style="{ backgroundImage: 'url(/storage/images/MikuWallpaper.jpg)' }">
        <header class="w-full flex justify-between p-6 bg-white bg-opacity-75 shadow-md dark:bg-black dark:bg-opacity-75">
            <div class="flex items-center">
                <img src="/storage/images/logo1.jpg" alt="Miku Elotes Logo" class="h-12 w-auto lg:h-20" />
                <h1 class="text-4xl font-bold text-black dark:text-white ml-10">Miku Elotes: El mejor sabor, al mejor precio</h1>
            </div>
            <nav v-if="canLogin" class="flex items-center">
                <Link
                    v-if="$page.props.auth.user"
                    :href="route('dashboard')"
                    class="rounded-md px-10 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-black/80 dark:focus-visible:ring-white"
                >
                   <p class="text-3xl"> Menu</p>
                </Link>
                <template v-else>
                    <Link
                        :href="route('login')"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-black/80 dark:focus-visible:ring-white"
                    >
                        Iniciar sesión
                    </Link>
                    <Link
                        v-if="canRegister"
                        :href="route('register')"
                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-black dark:hover:text-black/80 dark:focus-visible:ring-white"
                    >
                        Crear cuenta
                    </Link>
                </template>
            </nav>
        </header>

        <main class="flex flex-col items-center justify-center flex-1 p-6 w-full">
            <div class="w-full flex flex-col items-center justify-center flex-1 bg-white bg-opacity-75 p-6 rounded-lg shadow-md dark:bg-zinc-900 dark:bg-opacity-75 dark:ring-zinc-800">
                <h2 class="text-9xl font-bold text-center text-black dark:text-white mb-6">Bienvenido a Miku Elotes</h2>
            </div>
        </main>
    </div>
</template>

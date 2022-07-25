<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import { onMounted } from 'vue';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>

    <Head title="Home" />

    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.user" :href="route('events')" class="text-sm text-gray-700 underline">
                Accéder
            </Link>
            <Link v-if="$page.props.user" @click="logout" class="px-2 text-sm text-gray-700 underline">
                Déconnexion
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                Connexion
                </Link>

                <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm text-gray-700 underline">
                Inscription
                </Link>
            </template>
        </div>

        <div class="pace-y-4" v-if="$page.props.user">
            <p class="text-lg font-semibold text-slate-900">Bonjour {{ $page.props.user.name }}</p>
            <p class="mb-2">Ajouter et/ou Modifier vos évenements sans tracas !</p>

            <div class="w-96 bg-white shadow rounded py-10">
                <Link href="/events"
                    class="hover:border-blue-500 hover:border-solid hover:bg-white hover:text-blue-500 group flex flex-col items-center justify-center rounded-md border-2 border-dashed border-slate-300 text-sm leading-6 text-slate-900 font-medium py-3 w-3/4 m-auto">
                <svg class="group-hover:text-blue-500 mb-1 text-slate-400" width="20" height="20" fill="currentColor"
                    aria-hidden="true">
                    <path
                        d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                </svg>
                Commencer
                </Link>
            </div>
        </div>

        <div class="pace-y-4" v-else>
            <p class="text-lg font-semibold text-slate-900">Bienvenu(e) sur Event-Management</p>
            <p class="mb-2 w-96">Veuillez vous connecter avant de pouvoir profiter de nos fonctionnalités.</p>

            <div class="w-96 bg-white shadow rounded py-10">
                <Link href="/events"
                    class="hover:border-blue-500 hover:border-solid hover:bg-white hover:text-blue-500 group flex flex-col items-center justify-center rounded-md border-2 border-dashed border-slate-300 text-sm leading-6 text-slate-900 font-medium py-3 w-3/4 m-auto">
                <svg class="group-hover:text-blue-500 mb-1 text-slate-400" width="20" height="20" fill="currentColor"
                    aria-hidden="true">
                    <path
                        d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                </svg>
                Commencer
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped>
.bg-gray-100 {
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
}

.border-gray-200 {
    border-color: #edf2f7;
    border-color: rgba(237, 242, 247, var(--tw-border-opacity));
}

.text-gray-400 {
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--tw-text-opacity));
}

.text-gray-500 {
    color: #a0aec0;
    color: rgba(160, 174, 192, var(--tw-text-opacity));
}

.text-gray-600 {
    color: #718096;
    color: rgba(113, 128, 150, var(--tw-text-opacity));
}

.text-gray-700 {
    color: #4a5568;
    color: rgba(74, 85, 104, var(--tw-text-opacity));
}

.text-gray-900 {
    color: #1a202c;
    color: rgba(26, 32, 44, var(--tw-text-opacity));
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-gray-800 {
        background-color: #2d3748;
        background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
    }

    .dark\:bg-gray-900 {
        background-color: #1a202c;
        background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
    }

    .dark\:border-gray-700 {
        border-color: #4a5568;
        border-color: rgba(74, 85, 104, var(--tw-border-opacity));
    }

    .dark\:text-white {
        color: #fff;
        color: rgba(255, 255, 255, var(--tw-text-opacity));
    }

    .dark\:text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }
}
</style>

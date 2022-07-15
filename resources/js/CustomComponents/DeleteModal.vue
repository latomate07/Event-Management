<template id="deleteModal-template">

<div class="w-full fixed inset-0 bg-slate-800 opacity-80 items-center flex z-50 transition-opacity" v-if="deleteMode">
    <div class="flex flex-col p-5 bg-white shadow w-96 mx-auto my-0 h-56" v-on:submit.prevent>
        <button @click="toggleDeleteModal()" type="button" class="bg-gray-100 rounded-md p-2 inline-flex items-center text-gray-400 float-right w-8 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
            <span class="sr-only">Fermeture du modal</span>
            <!-- Heroicon name: outline/x -->
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h1 class="text-lg text-center leading-6 font-medium text-gray-900">Supprimer l'évenement :</h1>
        <div class="mt-2">
            <p class="text-sm text-center text-gray-500">Êtes-vous sûr de vouloir désactiver cet évenement ? Celui-ci sera définitivement supprimé. Cette action ne peut être annulée.</p>
        </div>
        <div class="flex justify-center mt-3 mx-auto text-center sm:text-left">
            <button type="submit" class="mr-20 btn hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded">Oui</button>
            <button type="button" @click="toggleDeleteModal()" class="btn hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded">Non</button>
        </div>
    </div>
</div>

</template>

<script config>
    export default {
        name: "DeleteModal",
        props: ['deleteMode', 'toggleDeleteModal'],
        components: "deleteModal-template",
    }
</script>
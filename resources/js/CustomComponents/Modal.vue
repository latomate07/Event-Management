<template id="modal-template">

<div class="w-full fixed inset-0 bg-slate-800 opacity-80 items-center flex z-50 transition-opacity" v-if="revele">
    <form class="flex flex-col p-5 bg-white shadow w-96 mx-auto my-0 h-96" v-on:submit.prevent>
        <button @click="toggleModale()" type="button" class="bg-gray-100 rounded-md p-2 inline-flex items-center text-gray-400 float-right w-8 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
            <span class="sr-only">Fermeture du modal</span>
            <!-- Heroicon name: outline/x -->
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <input class="my-2" type="text" name="" id="" placeholder="Nom de l'évènement">
        <textarea class="my-2 resize-none" type="text" name="" id="" placeholder="Contenu de l'évènement"></textarea>
        <label for="start">Début</label>
        <input class="my-2" type="date" name="" id="start" placeholder="Début de l'évènement">
        <label for="end">Fin</label>
        <input class="my-2" type="date" name="" id="end" placeholder="Fin de l'évènement">

        <input class="hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded" type="submit" value="Créer">
    </form>
</div>

</template>

<script config>
    export default {
        name: "Modale",
        props: ['revele', 'toggleModale', 'form'],
        components: "modal-template",
    }
</script>
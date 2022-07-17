<template id="modal-template">

<div class="w-full fixed inset-0 bg-slate-800 opacity-80 items-center flex z-50 transition-opacity rounded" v-if="revele">
    <form class="flex flex-col p-5 bg-white shadow w-96 mx-auto my-0 h-96" v-on:submit.prevent="submit()">
        <button @click="toggleModale()" type="button" class="bg-gray-100 rounded-md p-2 inline-flex items-center text-gray-400 float-right w-8 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
            <span class="sr-only">Fermeture du modal</span>
            <!-- Heroicon name: outline/x -->
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div v-if="$page.props.flash.message" class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
            <div class="flex">
                <div>
                    <p class="font-bold">Succès !</p>
                    <p class="text-sm">{{ $page.props.flash.message }}</p>
                </div>
            </div>
        </div>
        <input v-model="form.event_name" class="my-2" type="text" name="" id="event_name" placeholder="Nom de l'évènement">
        <textarea v-model="form.event_content" class="my-2 resize-none" type="text" name="" id="event_content" placeholder="Contenu de l'évènement"></textarea>
        <label for="event_start">Début</label>
        <input v-model="form.event_start" class="my-2" type="date" name="" id="event_start" placeholder="Début de l'évènement">
        <label for="event_end">Fin</label>
        <input v-model="form.event_end" class="my-2" type="date" name="" id="event_end" placeholder="Fin de l'évènement">

        <input class="hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded" type="submit" value="Créer">
    </form>
</div>

</template>

<script>
    export default {
        name: "Modale",
        props: ['revele', 'toggleModale', 'form'],
        components: "modal-template",

    data() {
        return {
            form: {
                event_name: null,
                event_content: null,
                event_start: null,
                event_end: null
            },
        }
    },

    methods: {
        submit() {
            this.$inertia.post('/event/add', this.form);
        }
    },

    mounted() {
        console.log(this.form.event_name)
    }

    }
</script>
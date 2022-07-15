<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import NavLink from "@/Jetstream/NavLink.vue";
import Input from "@/Jetstream/Input.vue";
import List from "@/CustomComponents/List.vue";
import ListItem from "@/CustomComponents/ListItem.vue";
import AppLayout from "@/layouts/AppLayout.vue";
import Modal from "@/CustomComponents/Modal.vue";
import UpdateModal from "@/CustomComponents/UpdateModal.vue";
import DeleteModal from "@/CustomComponents/DeleteModal.vue";


</script>

<template>
    <Head title="Events"/>
    <div class="pace-y-4 mx-20" v-if="$page.props.user">
        <header class="bg-white shadow space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-900">Mes évenements</h2>
                <button @click="toggleModale()" class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm">
                    <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
                        <path d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                    </svg>
                    Ajouter
                </button>
            </div>
            <form class="group relative">
                <svg width="20" height="20" fill="currentColor" class="absolute left-3 top-1/2 -mt-2.5 text-slate-400 pointer-events-none group-focus-within:text-blue-500" aria-hidden="true" >
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"/>
                </svg>
                <Input class="focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 pl-10 ring-1 ring-slate-200 shadow-sm" type="text" aria-label="Filter projects" placeholder="Filtrer les évenements..."></Input>
            </form>
        </header>

        <div class="divide-y divide-slate-100 my-5 mx-2">
            <div class="flex">
                <div>
                    <p class="text-sm" v-if="$page.props.flash.message">{{ $page.flash.message }}</p> <!-- Recevoir et affiché les erreurs -->
                    <!-- Afficher la réponse d'un évenement ["Add", "Update", "Delete"]-->
                </div>
            </div>
            <nav>
                <NavLink href="/">Aujourd'hui</NavLink>
                <NavLink href="/">À venir</NavLink>
            </nav>
            <List>
                <!-- Liste des évenements -->
                <ListItem class="bg-white shadow my-5" v-for="event in this.events" v-bind:key="event.id">
                    <template v-slot:title> <!-- Titre -->
                        {{ event.event_name }}
                    </template>
                    <template v-slot:event_content> <!-- Contenu de l'évenement -->
                        {{ event.event_content }}
                    </template>
                    <template v-slot:updated_at> <!-- Date de modification -->
                        {{ event.updated_at }}
                    </template>
                    <template v-slot:start_events> <!-- Commencement de l'évenement -->
                        {{ event.event_start }}
                    </template>
                    <template v-slot:end_events> <!-- Fin de l'évenement -->
                        {{ event.event_end }}
                    </template>
                </ListItem>
            </List>
        </div>
    </div>

    <div v-else>
        <p>Vous devez vous connectez !</p>
    </div>

    <modal v-bind:revele="revele" v-bind:toggleModale="toggleModale"></modal>



</template>

<script>
export default {

    components: {
        AppLayout,
        List,
        NavLink,
        'modal': Modal,
        'updateModal': UpdateModal,
        'deleteModal': DeleteModal
    },

    props: ["allEvents", "errors"],
    data() {
        return {
            events: this.allEvents,
            revele: false, // Affichage de la modale => Création 
            editMode: false, // Affichage de la modale => Modification
            deleteMode: false, // Affichage de la modale => Suppression 
            form: {
                title: null,
                content: null,
                start: null,
                end: null,
            },
        };
    },

    mounted() {
        console.log(this.events)
    },

    methods: {
        toggleModale() {
            this.revele = !this.revele
        },
        toggleEdit() {
            this.editMode = !this.editMode
        },
        toggleDeleteModal() {
            this.deleteMode = !this.deleteMode
        }
    }
};
</script>

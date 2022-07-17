<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import NavLink from "@/Jetstream/NavLink.vue";
import Input from "@/Jetstream/Input.vue";
import List from "@/CustomComponents/List.vue";
import ListItem from "@/CustomComponents/ListItem.vue";
import AppLayout from "@/layouts/AppLayout.vue";
import moment from 'moment';
import Pagination from '@/CustomComponents/Pagination.vue';
import 'moment/dist/locale/fr'

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
                <Input name="dateRangeInput" @click="toggleDataRanger()" class="focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 pl-10 ring-1 ring-slate-200 shadow-sm" type="text" aria-label="Filter projects" placeholder="Filtrer les évenements..."></Input>
            </form>
        </header>

        <div class="divide-y divide-slate-100 my-5 mx-2">
            <nav>
                <ul class="flex">
                    <li class="flex-1 mr-2">
                        <a @click="toggleTodayEvents()" class="bg-blue-500 text-center border-blue-500 block border rounded py-2 px-4  hover:bg-blue-700 text-white" href="javascript:void(0)">Aujourd'hui</a>
                    </li>
                    <li class="flex-1 mr-2">
                        <a @click="toggleAvenirEvents()" class="text-slate-800 text-center block border border-white rounded border-gray-200 bg-gray-200 border-gray-200 text-blue-500 py-2 px-4" href="javascript:void(0)">À venir</a>
                    </li>
                </ul>
            </nav>

            <div v-if="showTodayEvents">
                <List v-if="showTodayEvents">
                    <!-- Liste des évenements -->
                    <ListItem v-for="event in actualEvents" v-bind:key="event.id" class="bg-white shadow my-5">
                        <template v-slot:title> <!-- Titre -->
                            {{ event.event_name }}
                        </template>
                        <template v-slot:event_content> <!-- Contenu de l'évenement -->
                            {{ event.event_content }}
                        </template>
                        <template v-slot:updated_at> <!-- Date de modification -->
                            {{ dateTime(event.updated_at) }}
                        </template>
                        <template v-slot:start_events> <!-- Commencement de l'évenement -->
                            {{ dateTime(event.event_start) }}
                        </template>
                        <template v-slot:end_events> <!-- Fin de l'évenement -->
                            {{ dateTime(event.event_end) }}
                        </template>
                        <template v-slot:toggleDeleteModal>
                            <button @click="toggleDeleteModal()" class="mt-5 float-right bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Terminer</button>
                        </template>
                        <template v-slot:toggleEdit>
                            <button @click="toggleEdit(event)" class="m-5 float-right bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Modifier</button>
                        </template>
                    </ListItem>
                </List>
            </div>

            <div v-if="showAvenirEvents">
                <List>
                    <!-- Liste des évenements -->
                    <ListItem v-for="event in eventsAvenir" v-bind:key="event.id" class="bg-white shadow my-5">
                        <template v-slot:title> <!-- Titre -->
                            {{ event.event_name }}
                        </template>
                        <template v-slot:event_content> <!-- Contenu de l'évenement -->
                            {{ event.event_content }}
                        </template>
                        <template v-slot:updated_at> <!-- Date de modification -->
                            {{ dateTime(event.updated_at) }}
                        </template>
                        <template v-slot:start_events> <!-- Commencement de l'évenement -->
                            {{ dateTime(event.event_start) }}
                        </template>
                        <template v-slot:end_events> <!-- Fin de l'évenement -->
                            {{ dateTime(event.event_end) }}
                        </template>
                        <template v-slot:toggleDeleteModal>
                            <button @click="toggleDeleteModal()" class="mt-5 float-right bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Terminer</button>
                        </template>
                        <template v-slot:toggleEdit>
                            <button @click="toggleEdit(event)" class="m-5 float-right bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Modifier</button>
                        </template>
                    </ListItem>
                </List>
            </div>
        </div>
    </div>

    <div v-else>
        <p>Vous devez vous connectez !</p>
    </div>

<!-- Modal = Ajout d'évenement  -->
    <div v-if="revele" class="w-full fixed inset-0 bg-slate-800 opacity-80 items-center flex z-50 transition-opacity rounded">
        <form class="flex flex-col p-5 bg-white shadow w-96 mx-auto my-0 h-96" v-on:submit.prevent="add()">
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

<!-- Modal = Modification d'évenement -->
    <div v-if="editMode" class="w-full fixed inset-0 bg-slate-800 opacity-80 items-center flex z-50 transition-opacity rounded">
        <form v-bind:key="this.events.id" class="flex flex-col p-5 bg-white shadow w-96 mx-auto my-0 h-96" v-on:submit.prevent="edit()">
            <button @click="toggleEdit()" type="button" class="bg-gray-100 rounded-md p-2 inline-flex items-center text-gray-400 float-right w-8 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <span class="sr-only">Fermeture du modal</span>
                <!-- Heroicon name: outline/x -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <input v-model="this.events.event_name"  class="my-2" type="text" name="" id="">
            <textarea  v-model="this.events.event_content" class="my-2 resize-none" type="text" name="" id="" placeholder="Contenu de l'évènement"><slot name="event_content"></slot></textarea>
            <label for="start">Début</label>
            <input  v-model="this.events.event_start" class="my-2" type="date" name="" id="start" placeholder="Début de l'évènement">
            <label for="end">Fin</label>
            <input  v-model="this.events.event_end" class="my-2" type="date" name="" id="end" placeholder="Fin de l'évènement">

            <input class="hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded" type="submit" value="Modifier">
        </form>
    </div>

<!-- Modal = Suppression d'évenement -->
    <div v-if="deleteMode" class="w-full fixed inset-0 bg-slate-800 opacity-80 items-center flex z-50 transition-opacity rounded">
        <div class="flex flex-col p-5 bg-white shadow w-96 mx-auto my-0 h-56">
            <button @click="toggleDeleteModal()" type="button" class="bg-gray-100 rounded-md p-2 inline-flex items-center text-gray-400 float-right w-8 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <span class="sr-only">Fermeture du modal</span>
                <!-- Heroicon name: outline/x -->
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <h1 class="text-lg text-center leading-6 font-medium text-gray-900">Fin de l'évenement :</h1>
            <div class="mt-2">
                <p class="text-sm text-center text-gray-500">Êtes-vous sûr de vouloir mettre fin à cet évenement ? Celui-ci sera définitivement supprimé. Cette action ne peut être annulée.</p>
            </div>
            <div class="flex justify-center mt-3 mx-auto text-center sm:text-left">
                <button type="submit" class="mr-20 btn hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded">Oui</button>
                <button type="button" @click="toggleDeleteModal()" class="btn hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded">Non</button>
            </div>
       </div>
   </div>
   
</template>

<script>
export default {
    components: {
        AppLayout,
        List,
        NavLink
    },

    props: ['allEvents', 'errors', 'todayEvents', 'futurEvents'],

    data() {
        return {
            events: this.allEvents,
            actualEvents: this.todayEvents,
            eventsAvenir: this.futurEvents,
            revele: false, // Affichage de la modale => Création 
            editMode: false, // Affichage de la modale => Modification
            deleteMode: false, // Affichage de la modale => Suppression 
            showDataRanger: false, // Affichage du dateRange de MomentJS
            showTodayEvents: true,
            showAvenirEvents: false,
            isAddClass: false,
            form: {
                event_name: null,
                event_content: null,
                event_start: null,
                event_end: null
            },
            test: false,
        };
    },
    mounted() {
        console.log(this.eventsAvenir)
    },
    methods: {
        toggleTodayEvents() {
            this.showTodayEvents = true
            this.showAvenirEvents = false
            this.isAddClass = true;
        },
        toggleAvenirEvents() {
            this.showAvenirEvents = true
            this.showTodayEvents = false
            this.isAddClass = true;
        },

        toggleModale() {
            this.revele = !this.revele
        },
        toggleEdit(data) {
            this.editMode = !this.editMode
            this.form = Object.assign({}, data);
        },
        toggleDeleteModal() {
            this.deleteMode = !this.deleteMode
        },
        toggleDataRanger() {
            this.showDataRanger = !this.showDataRanger
        },
        dateTime(value) {
            return moment(value).locale("fr").calendar()
        },
        add() {
            this.$inertia.post('/event/add', this.form);
        },
        edit() {
            this.$inertia.patch('/event/edit/' + this.events.id, this.events);
        },
        delete(){
            this.$inertia.delete('/event/delete/' + this.events.id, this.events)
        }
    }
};
</script>

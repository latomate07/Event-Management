<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import NavLink from "@/Jetstream/NavLink.vue";
import Input from "@/Jetstream/Input.vue";
import List from "@/CustomComponents/List.vue";
import ListItem from "@/CustomComponents/ListItem.vue";
import moment from 'moment';
import Pagination from '@/CustomComponents/Pagination.vue';
import 'moment/dist/locale/fr';

</script>

<template>

    <Head title="Events" />
    <div class="pace-y-4 mx-20" v-if="$page.props.user">
        <!-- Si utuilisateur connecté -->
        <header class="bg-white shadow space-y-4 p-4 sm:px-8 sm:py-6 lg:p-4 xl:px-8 xl:py-6">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-slate-900">Mes évenements</h2>
                <button @click="toggleModale()"
                    class="hover:bg-blue-400 group flex items-center rounded-md bg-blue-500 text-white text-sm font-medium pl-2 pr-3 py-2 shadow-sm">
                    <svg width="20" height="20" fill="currentColor" class="mr-2" aria-hidden="true">
                        <path
                            d="M10 5a1 1 0 0 1 1 1v3h3a1 1 0 1 1 0 2h-3v3a1 1 0 1 1-2 0v-3H6a1 1 0 1 1 0-2h3V6a1 1 0 0 1 1-1Z" />
                    </svg>
                    Ajouter
                </button>
            </div>

            <form class="group relative" v-on:submit.prevent>
                <svg width="20" height="20" fill="currentColor"
                    class="absolute left-3 top-1/2 -mt-2.5 text-slate-400 pointer-events-none group-focus-within:text-blue-500"
                    aria-hidden="true">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" />
                </svg>
                <div
                    class="flex items-center focus:ring-2 focus:ring-blue-500 focus:outline-none appearance-none w-full text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md py-2 pl-10 ring-1 ring-slate-200 shadow-sm">
                    <input v-model="filterElements.start"
                        class="appearance-none text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md ring-1 ring-slate-200 hover:shadow-sm"
                        type="date" name="event_start" id="">
                    <p class="px-2">-</p>
                    <input v-model="filterElements.end"
                        class="appearance-none text-sm leading-6 text-slate-900 placeholder-slate-400 rounded-md ring-1 ring-slate-200 hover:shadow-sm"
                        type="date" name="event_end" id="">
                    <button type="submit" @click="filterThis(filterElements)"
                        class="ml-2 bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow cursor-pointer">
                        Filtrer
                    </button>
                    <Link v-if="filterMode" :href="route('events')"
                        class="ml-2 bg-white hover:bg-gray-100 text-red-800 font-semibold py-2 px-4 border border-red-400 rounded shadow cursor-pointer">
                    Supprimer le filtre
                    </Link>
                </div>
            </form>
        </header>

        <div class="divide-y divide-slate-100 my-5 mx-2">
            <nav>
                <ul class="flex" v-if="filterMode != true">
                    <!-- Si aucun filtre -->
                    <li class="flex-1 mr-2">
                        <a @click="toggleTodayEvents()"
                            class="bg-blue-500 text-center border-blue-500 block border rounded py-2 px-4  hover:bg-blue-700 text-white"
                            href="javascript:void(0)" id="todayEvents">Aujourd'hui</a>
                    </li>
                    <li class="flex-1 mr-2">
                        <a @click="toggleAvenirEvents()"
                            class="text-slate-800 text-center block border border-white rounded bg-gray-200 border-gray-200 text-blue-500 py-2 px-4"
                            href="javascript:void(0)" id="avenirEvents">À venir</a>
                    </li>
                </ul>

                <ul v-else>
                    <!-- Si filtre existe -->
                    <li class="flex-1 mr-2">
                        <a class="bg-blue-500 text-center border-blue-500 block border rounded py-2 px-4  hover:bg-blue-700 text-white"
                            href="javascript:void(0)">Résultat du filtre</a>
                    </li>
                </ul>
            </nav>

            <div v-if="showTodayEvents" v-for="event in this.todayEvents" v-bind:key="event.id">
                <List>
                    <!-- Liste des évenements  -->
                    <ListItem class="bg-white shadow my-5">
                        <template v-slot:title>
                            {{ event.event_name }}
                        </template>
                        <template v-slot:event_content>
                            {{ event.event_content }}
                        </template>
                        <template v-slot:updated_at>
                            {{ dateTime(event.updated_at) }}
                        </template>
                        <template v-slot:start_events>
                            {{ dateTime(event.event_start) }}
                        </template>
                        <template v-slot:end_events>
                            {{ dateTime(event.event_end) }}
                        </template>
                        <template v-slot:toggleDeleteModal>
                            <button @click="deleteRow(event)"
                                class="mt-5 float-right bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded">Terminer</button>
                        </template>
                        <template v-slot:toggleEdit>
                            <button @click="toggleEdit(event)"
                                class="m-5 float-right bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Modifier</button>
                        </template>
                    </ListItem>
                </List>
            </div> <!-- End today events -->

            <div v-if="showAvenirEvents" v-for="event in this.futurEvents" v-bind:key="event.id">
                <List>
                    <!-- Liste des évenements  -->
                    <ListItem class="bg-white shadow my-5">
                        <template v-slot:title>
                            {{ event.event_name }}
                        </template>
                        <template v-slot:event_content>
                            {{ event.event_content }}
                        </template>
                        <template v-slot:updated_at>
                            {{ dateTime(event.updated_at) }}
                        </template>
                        <template v-slot:start_events>
                            {{ dateTime(event.event_start) }}
                        </template>
                        <template v-slot:end_events>
                            {{ dateTime(event.event_end) }}
                        </template>
                        <template v-slot:toggleDeleteModal>
                            <button @click="deleteRow(event)"
                                class="mt-5 float-right bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded">Terminer</button>
                        </template>
                        <template v-slot:toggleEdit>
                            <button @click="toggleEdit(event)"
                                class="m-5 float-right bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Modifier</button>
                        </template>
                    </ListItem>
                </List>
            </div> <!-- End ShowAVenirEvents -->

            <div v-if="filterMode" v-for="event in this.resultOfFilter" v-bind:key="event.id">
                <List>
                    <!-- Liste des évenements  -->
                    <ListItem class="bg-white shadow my-5">
                        <template v-slot:title>
                            {{ event.event_name }}
                        </template>
                        <template v-slot:event_content>
                            {{ event.event_content }}
                        </template>
                        <template v-slot:updated_at>
                            {{ dateTime(event.updated_at) }}
                        </template>
                        <template v-slot:start_events>
                            {{ dateTime(event.event_start) }}
                        </template>
                        <template v-slot:end_events>
                            {{ dateTime(event.event_end) }}
                        </template>
                        <template v-slot:toggleDeleteModal>
                            <button @click="deleteRow(event)"
                                class="mt-5 float-right bg-transparent hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 hover:border-transparent rounded">Terminer</button>
                        </template>
                        <template v-slot:toggleEdit>
                            <button @click="toggleEdit(event)"
                                class="m-5 float-right bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded">Modifier</button>
                        </template>
                    </ListItem>
                </List>
            </div> <!-- End showFilterEvents -->

            <!-- Si aucun évenement trouvé, afficher ce qui suit -->
            <div v-if="showAvenirEvents && eventsAvenir == '' || showTodayEvents && actualEvents == ''">
                <p class="text-center p-10">Aucun évenement disponible pour cette sélection.</p>
            </div>

            <div v-else-if="filterMode && resultOfFilter == ''">
                <p class="text-center p-10">Votre filtre ne correspond à aucun résultat.</p>
            </div>

        </div>
    </div>

    <div v-else>
        <!-- Et Si utilisateur non connecté -->
        <p class="text-center pace-y-4 mx-20">Vous devez vous connectez !</p>
    </div>

    <!-- Modal = Ajout d'évenement   -->
    <div v-if="revele" class="w-full fixed inset-0 items-center flex z-50 transition-opacity rounded">
        <div class="overlay"></div>
        <div class="modal flex flex-col p-5 bg-white shadow w-96 mx-auto my-0 h-auto">
            <button @click="toggleModale()" type="button"
                class="bg-gray-100 rounded-md p-2 inline-flex items-center text-gray-400 float-right w-8 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <span class="sr-only">Fermeture du modal</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div v-if="$page.props.flash.message"
                class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div>
                        <p class="font-bold">Succès !</p>
                        <p class="text-sm">{{ $page.props.flash.message }}</p>
                    </div>
                </div>
            </div>
            <input v-model="form.event_name" class="my-2" type="text" name="" id="event_name"
                placeholder="Nom de l'évènement">
            <textarea v-model="form.event_content" class="my-2 resize-none" type="text" name="" id="event_content"
                placeholder="Contenu de l'évènement"></textarea>
            <label for="event_start">Début</label>
            <input v-model="form.event_start" class="my-2" type="date" name="" id="event_start"
                placeholder="Début de l'évènement">
            <label for="event_end">Fin</label>
            <input v-model="form.event_end" class="my-2" type="date" name="" id="event_end"
                placeholder="Fin de l'évènement">

            <div class="w-full flex justify-around">
                <button v-on:click.prevent="add(form)"
                    class="hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded"
                    type="button">Créer</button>

                <button @click="closeModal()"
                    class="hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 cursor-pointer hover:border-transparent rounded"
                    type="button">Quitter</button>
            </div>

        </div>
    </div>

    <!-- Modal = Modification d'évenement  -->
    <div v-if="editMode" class="w-full fixed inset-0 items-center flex z-50 transition-opacity rounded">
        <div class="overlay"></div>
        <div class="flex flex-col p-5 bg-white shadow w-96 mx-auto my-0 h-auto modal">
            <button @click="toggleEdit()" type="button"
                class="bg-gray-100 rounded-md p-2 inline-flex items-center text-gray-400 float-right w-8 hover:text-gray-500 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                <span class="sr-only">Fermeture du modal</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            <div v-if="$page.props.flash.message"
                class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md" role="alert">
                <div class="flex">
                    <div>
                        <p class="font-bold">Succès !</p>
                        <p class="text-sm">{{ $page.props.flash.message }}</p>
                    </div>
                </div>
            </div>
            <input v-model="form.event_name" class="my-2" type="text" name="" id="">
            <textarea v-model="form.event_content" class="my-2 resize-none" type="text" name="" id=""
                placeholder="Contenu de l'évènement"><slot name="event_content"></slot></textarea>
            <label for="start">Début</label>
            <input v-model="form.event_start" class="my-2" type="date" name="" id="start"
                placeholder="Début de l'évènement">
            <label for="end">Fin</label>
            <input v-model="form.event_end" class="my-2" type="date" name="" id="end" placeholder="Fin de l'évènement">

            <div class="w-full flex justify-around">
                <button @click="update(form)"
                    class="hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded"
                    type="button">Modifier</button>

                <button @click="closeModal()"
                    class="hover:bg-red-500 text-red-700 font-semibold hover:text-white py-2 px-4 border border-red-500 cursor-pointer hover:border-transparent rounded"
                    type="button">Quitter</button>
            </div>
        </div>
    </div>

</template>

<script>

export default {
    components: {
        List,
        NavLink
    },

    props: ['allEvents', 'errors', 'todayEvents', 'futurEvents', 'resultOfFilter'],

    data() {
        return {
            /***
             * Stocker les données reçus dans une variable
            */
            events: this.allEvents,
            actualEvents: this.todayEvents,
            eventsAvenir: this.futurEvents,

            /**
             * Affichage/Cacher des élements
             */
            revele: false, // Affichage de la modale => Création 
            editMode: false, // Affichage de la modale => Modification
            showDataRanger: false, // Affichage du dateRange de MomentJS

            filterMode: false,
            showTodayEvents: true,
            showAvenirEvents: false,

            /**
             * Valeur par défaut
             */
            form: {
                event_name: null,
                event_content: null,
                event_start: null,
                event_end: null
            },

            filterElements: { // Les élements nécessaires pour le filtre
                start: null,
                end: null
            }
        };
    },
    mounted() {
        /**
         * Toggle Navigation links -- Fonctionnalité visuelle de la navigation
         */
        const todayEvents = document.getElementById('todayEvents'),
            avenirEvents = document.getElementById('avenirEvents'),
            classes = {
                active: [
                    'bg-blue-500', 'border-blue-500', 'hover:bg-blue-700', 'navActive'
                ],
                inactive: [
                    'text-slate-800', 'border-white', 'bg-gray-200', 'border-gray-200'
                ]
            };
        todayEvents.onclick = function () {
            classes.active.forEach((e) => {
                todayEvents.classList.add(e)
                avenirEvents.classList.remove(e)
            })
            classes.inactive.forEach((e) => {
                avenirEvents.classList.add(e)
                todayEvents.classList.remove(e)
            })
        }

        avenirEvents.onclick = function () {
            classes.active.forEach((e) => {
                avenirEvents.classList.add(e)
                todayEvents.classList.remove(e)
            })
            classes.inactive.forEach((e) => {
                todayEvents.classList.add(e)
                avenirEvents.classList.remove(e)
            })
        }

        /**
         * Test
         */

        // console.log(this.$attrs.flash)
    },
    methods: {
        test() {
            this.filterMode = true
        },
        toggleTodayEvents() {
            this.showTodayEvents = true
            this.showAvenirEvents = false
        },
        toggleAvenirEvents() {
            this.showAvenirEvents = true
            this.showTodayEvents = false
        },
        toggleModale() {
            this.revele = !this.revele
        },
        toggleEdit(data) {
            this.form = Object.assign({}, data); // Assigner les valeurs du :data dans this.form
            this.editMode = !this.editMode
        },
        toggleDataRanger() {
            this.showDataRanger = !this.showDataRanger
        },
        closeModal() {
            this.revele = false;
            this.editMode = false;
            this.$attrs.flash.message = "" // Supprimer le message du serveur
        },
        reset() {
            this.form = {
                event_name: null,
                event_content: null,
                event_start: null,
                event_end: null
            }
        },
        dateTime(value) {
            return moment(value).locale("fr").calendar({
                sameDay: "[Aujoud'hui]",
                nextDay: '[Demain]',
                nextWeek: 'dddd',
                lastDay: '[Hier]',
                lastWeek: 'dddd [dernier]',
                sameElse: 'DD/MM/YYYY'
            })
        },
        add(data) {
            this.$inertia.post('/events/add', data, { preserveScroll: true });
            this.reset();
        },
        update(data) {
            data._method = 'PATCH';
            this.$inertia.post('/events/edit/' + data.id, data, { preserveScroll: true })
            this.reset();
        },
        deleteRow(data) {
            if (!confirm('Êtes-vous sûr de vouloir mettre fin à cet évenement ?')) return;
            data._method = 'DELETE';
            this.$inertia.post('/events/delete/' + data.id, data, { preserveScroll: true })
            this.reset();
        },
        filterThis(data) {
            this.filterMode = true;
            this.$inertia.get('/events/filter', data, { preserveState: true });
            this.showTodayEvents = false
            this.showAvenirEvents = false
        }
    }
};
</script>

<style scoped>
.overlay {
    position: fixed;
    width: 100%;
    background: rgba(0, 0, 0, 0.5);
    ;
    height: 100%;
    transition: background .5s ease-in-out;
    z-index: 1;
}

.modal {
    z-index: 10;
}

.navActive {
    color: rgb(255 255 255 / 1) !important;
}
</style>
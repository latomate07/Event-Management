<template>

<div class="w-full fixed inset-0 bg-slate-800 opacity-80 items-center flex">
    <form class="flex flex-col p-5 bg-white shadow w-96 mx-auto my-0 h-96" v-on:submit.prevent>
        <input class="my-2" type="text" name="" id="" placeholder="Nom de l'évènement">
        <input class="my-2" type="text" name="" id="" placeholder="Contenu de l'évènement">
        <label for="start">Début</label>
        <input class="my-2" type="date" name="" id="start" placeholder="Début de l'évènement">
        <label for="end">Fin</label>
        <input class="my-2" type="date" name="" id="end" placeholder="Fin de l'évènement">

        <input class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 cursor-pointer hover:border-transparent rounded" type="submit" value="Créer">
    </form>
</div>

</template>

<!-- fixed top-32 shadow w-96 mx-auto my-0 h-96 -->
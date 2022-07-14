<template>
  <article class="flex items-start space-x-6 p-6">
    <div class="min-w-0 relative flex-auto">
      <div class="flex justify-between">
          <h2 class="font-semibold text-slate-900 truncate pr-20">Ceci est un titre</h2> <!-- Nom de l'évenement -->
          <dd>Modifié le : 12/12/2022 à 12h</dd>
      </div>  
      
      <dl class="mt-2 flex flex-wrap text-sm leading-6 font-medium">

        <div class="ml-2 flex">
          <dt class="sr-only">Updated_at</dt>
          <dd>Début : Aujourd'hui</dd>
          <dd class="px-5">Fin : Demain</dd>
        </div>

        <div class="flex-none w-full mt-2 font-normal">
          <dt class="sr-only"></dt>
          <dd class="text-slate-400">euh</dd>
        </div>
      </dl>
    </div>
  </article>
</template>
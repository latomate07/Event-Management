<template>
  <article class="flex items-start space-x-6 p-6">
    <div class="min-w-0 relative flex-auto">
      <div class="flex justify-between">
          <h2 class="font-semibold text-slate-900 truncate pr-20"><slot name="title"></slot></h2> <!-- Nom de l'évenement -->
          <dd>Dernière modification : <slot name="updated_at"></slot></dd>
      </div>  
      
      <dl class="mt-2 flex flex-wrap text-sm leading-6 font-medium">

        <div class="flex">
          <dt class="sr-only">Délai</dt>
          <dd>Début : <slot name="start_events"></slot></dd>
          <dd class="px-5">Fin : <slot name="end_events"></slot></dd>
        </div>

        <div class="flex-none w-full mt-2 font-normal">
          <dt class="sr-only"></dt>
          <dd class="text-slate-400"><slot name="event_content"></slot></dd>
        </div>
      </dl>
    </div>
  </article>
</template>
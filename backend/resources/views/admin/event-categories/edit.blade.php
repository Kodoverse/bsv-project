    <x-admin-layout title="Modifca Categoria Evento {{ $eventCategory->name }}" :breadcrumbs="[
      'Dashboard' => route('admin.dashboard'),
      'Categorie Eventi' => route('admin.event-categories.index'),
      '{{ $event->title }}' => route('admin.event-categories.show', $eventCategory->id),
  ]">
      <div class="flex flex-col items-center w-full py-10 overflow-hidden">
          <div class="w-full max-w-5xl md:px-8">
              <x-form-admin :action="route('admin.event-categories.update', $eventCategory->id)" method="POST" submit-label="Modifica Categoria"
                  enctype="multipart/form-data">
                  <x-form-section>
                      <x-input-admin id="title" label="Nome Categoria" type="text" name="title" />
                        <x-input-color
                        id="primary_color"
                        name="primary_color"
                        label="Colore"/>
                    </x-form-section>
              </x-form-admin>
          </div>
      </div>
<div class="flex flex-row justify-center gap-6">
                    <x-crud-button type="confirm" />
                    <x-crud-button type="delete" label="Annulla" href="{{ route('admin.event-categories.show', $eventCategory->id) }}" />
                </div>
</x-admin-layout>
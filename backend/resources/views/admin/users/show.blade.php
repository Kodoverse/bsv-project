@extends('layouts.admin')
@section('content')
    <x-app-layout>
        <div x-data="userRoleModal({{ $userData->id }}, '{{ $userData->user_role }}')">
        <button @click="open = true" class="px-2 py-1 text-white bg-blue-500 rounded">
            Modifica Ruolo
        </button>
        <div x-show="open" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
            <div class="p-6 bg-white rounded shadow-lg w-80">
                <h3 class="mb-4 text-lg">Modifica ruolo</h3>
                <select x-model="selectedRole" class="w-full p-2 mb-4 border rounded">
                    <option value="user">Utente</option>
                    <option value="admin">Admin</option>
                    <option value="librarian">Librarian</option>
                    <option value="partner">Partner</option>
                </select>
                <div class="flex justify-end gap-2">
                    <button @click="open = false" class="px-4 py-2 bg-gray-300 rounded">Annulla</button>
                    <button @click="updateRole()" class="px-4 py-2 text-white bg-blue-500 rounded">Salva</button>
                </div>
            </div>
        </div>
        </div>
    </x-app-layout>
@endsection


<script>
    function userRoleModal(userId, currentRole) {
        return {
            open: false,
            selectedRole: currentRole,
            async updateRole() {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const res = await fetch(`/admin/users/${userId}/role`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        role: this.selectedRole
                    })
                });

                if (res.ok) {
                    this.open = false;
                    alert('Ruolo aggiornato con successo!');
                } else {
                    alert('Errore nell\'aggiornamento del ruolo');
                }
            }
        }
    }
</script>

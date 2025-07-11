<template>
    <div id="dashboard" class="w-full h-100 overflow-hidden">
        <h1 class="text-3xl text-center mb-6">Dashboard</h1>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <div class=" flex flex-column bg-red-300 row-span-2 h-full" id="userInfo" >
                <!-- informazione dell'utente -->
                <div>
                    <h2 class="text-3xl text-center mb-2">Info utente</h2>
                </div>

                <div id="userImg">
                    <img class=" w-100 " :src="store.CurrentUser.info.profile_img" :alt=" store.CurrentUser.display_name ">
                </div>
                <!-- Data di registrazione -->
                <div class="flex justify-between">
                    <h4>Data di registrazione:</h4>
                    <p>{{ formatDate(store.CurrentUser.created_at) }}</p>
                </div>
                <!-- Nome e Cognome -->
                <div class="flex justify-between">
                    <h4>Nome:</h4>
                    <p>{{ store.CurrentUser.info.firstname }}</p>
                </div>
                <div class="flex justify-between">
                    <h4>Cognome:</h4>
                    <p>{{ store.CurrentUser.info.lastname }}</p>
                </div>
                <div class="flex justify-between">
                    <h4>Data di nascita:</h4>
                    <p>{{ formatDate(store.CurrentUser.info.birthday) }}</p>
                </div>
                <div class="flex justify-between">
                    <h4>E-mail:</h4>
                    <p>{{ store.CurrentUser.email }}</p>
                </div>

            </div>
            <!-- commenti aggiunti -->
            <div class="box" id="commentsAdded">
                <div>
                    <h2 class="text-2xl text-center mb-2">Comments added</h2>
                </div>
                <div class="p-4">
                    <div class="flex justify-center items-center">
                        <p class="text-6xl">{{ store.CurrentUser.comments_count }}</p>
                    </div>
                </div>
            </div>
            <!-- notifiche -->
            <div class="box">
                <div>
                    <h2 class="text-3xl text-center mb-2">Notifiche</h2>
                </div>
            </div>
            <!-- le tue prenotazioni -->
            <div class="box">
                <div>
                    <h2 class="text-3xl text-center mb-2">Prenotazioni</h2>
                </div>
            </div>

        </div>


    </div>

</template>

<script>
    import axios from "axios";
    import { getCurrentUser, store } from "../store.js";
    export default {
        name: "Dashboard",
        data() {
            return {
                store,
            };
        },
        methods: {
            formatDate(date) {
                return new Date(date).toLocaleDateString("it-IT", {
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                });
            },
        },

        mounted() {
            getCurrentUser();
        },
    };
</script>

<style scoped>
    #dashboard {
        height: 100%;
        width: 100%;
        background-color: white;
        color: black;
        margin-bottom: 100px;
        padding: 20px;
    }

    #userInfo {
        width: 500px;
        border-radius: 20px;
        padding: 15px;
        display: flex;
        justify-content: space-between;
        flex-direction: column;
        font-size: 1rem;
    }

    #userImg {
        margin: 0px auto;
    }

    .box {
        display: inline-block;
        border: 1px solid rgb(0, 0, 0);
        border-radius: 20px;
        padding: 15px;
        width: 500px;
        height: 300px;
        margin: auto;
    }

    #commentsAdded {
        width: 300px;
        aspect-ratio: 1 / 1;
        border-radius: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        font-size: 1rem;
    }
</style>

<template>
    <div class="text-center w-full">
        <h1 class="text-3xl">Indicazioni</h1>
        <div class="map">
            <iframe src="https://www.google.com/maps?q=37.296969,13.563128&z=15&output=embed" width="60%" height="600px"
                style="border: 0" allowfullscreen="" loading="lazy">
            </iframe>

            <div type="button" class="btn ">
                <a href="https://www.google.com/maps/dir/?api=1&destination=37.29690,13.56349" target="_blank"
                    rel="noopener noreferrer">
                    Ottieni Indicazioni
                </a>

            </div>

        </div>
    </div>
</template>

<script>
    export default {
        name: "Contatti",
    };
</script>

<style scoped>

    .map {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin: 50px auto;
    }

    .btn{
        margin-top: 20px;
        border: 2px solid #df9a04;
        border-radius: 20px;
        padding: 10px;
    }

    .btn:hover{
        background-color: #df9a04;
    }

</style>

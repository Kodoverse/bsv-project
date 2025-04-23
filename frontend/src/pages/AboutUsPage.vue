<template>
    <h1></h1>
    <h2></h2>
    <div>
        <p></p>
    </div>
</template>
<script>
import axios from "axios";
    export default {
        name: "AboutUsPage",
        data() {
            return {
                aboutSection: [],
                test: [],
            }
        },
        methods: {
            getData() {
                axios.get('http://localhost:8000/api/sections').then((res)=>{ 
                    this.aboutSection=res.data.results;
                });   
                this.filterData();
            },

            filterData() {
                this.test = this.aboutSection.filter(element => element.title.trim().toLowerCase() == "aboutus");
                console.log(this.test);
           
            }
        },
        mounted() {
            this.getData();
            
        }
    }


</script>
<style scoped>

</style>
<template>
    <div class="flex flex-col">
        <div id="single-article">
            <div>
                <h1 class="text-3xl text-center ">Titolo</h1>
            </div>

            <div class="my-3">
                <h2 class="text-2xl text-center ">
                    Sottotitolo
                </h2>
            </div>

            <div>
                <p>
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Ab, laborum. Iure dolorum incidunt ad dolorem quis eligendi, deserunt laborum commodi alias veritatis magni saepe error cum reprehenderit pariatur eaque vitae corrupti beatae doloribus quidem nostrum animi et! Tempora dolores architecto praesentium obcaecati molestiae nisi adipisci? Dolor voluptate delectus pariatur porro quasi, at dolores assumenda facilis iure provident natus mollitia minima, soluta fugit culpa aliquam nam esse facere quod alias doloremque amet non nisi! Ipsum eaque, earum provident est placeat tempore consequuntur minima? Rem recusandae iusto qui cum hic debitis necessitatibus consectetur, tenetur error obcaecati molestias nesciunt unde. Ea quisquam impedit exercitationem quidem architecto sed id nam doloremque perspiciatis beatae obcaecati odit possimus maxime, quos excepturi non nobis hic tenetur voluptate. Quo at labore quod quas alias reiciendis veniam repellat? Odio, adipisci mollitia provident nam nulla, culpa velit, alias libero eligendi necessitatibus a. Perspiciatis dolorem dicta nemo quod doloremque illo, maxime soluta vel pariatur sequi ab aspernatur natus alias mollitia tenetur nulla quaerat, sit harum. Quos tempore temporibus est, ex doloribus cumque voluptatibus exercitationem laboriosam maxime nihil nulla quidem id, fugiat nam neque cupiditate eaque dolor debitis pariatur, odio sed maiores hic quas. Consequuntur quis asperiores quidem veniam non, repellendus ea, necessitatibus est deleniti dolores in pariatur? Possimus magni id veritatis similique temporibus cum, fugiat earum delectus atque alias praesentium corrupti quas saepe aspernatur sit tenetur doloribus quod iure nobis necessitatibus ex, facere, repellat asperiores quos? Amet architecto eaque tenetur expedita non accusamus, corrupti qui sint! Enim molestias iure quia deleniti vero aspernatur nam sequi, assumenda perferendis ipsum. Alias, sapiente. Eum, excepturi. Similique quis doloribus placeat ullam tempore repellendus eum minima esse? Illum, aperiam. Maxime itaque illo ratione sed quos nobis aliquid, et animi eaque cupiditate unde in iure vel adipisci voluptatem iste. Nam, voluptatum optio! Assumenda numquam fugiat asperiores praesentium?
                </p>
            </div>
        </div>

    <
    <div id="comments">
        <CommentComponent />
    </div>
    </div>
  
</template>

<script>
    import CommentComponent from "../components/CommentComponent.vue";
    import axios from "axios";
    export default {
        name: "SingleArticle",
        components: {
            CommentComponent,
        },
        data() {
            return {

            }

        },
        methods: {
            

        }
    }
</script>

<style scoped>
    #single-article {
        height: 100%;
        width: 100%;
        border: 3px solid red;
    }

    #comments {
        height: 100%;
        width: 100%;
        border: 3px solid green;
    }
</style>
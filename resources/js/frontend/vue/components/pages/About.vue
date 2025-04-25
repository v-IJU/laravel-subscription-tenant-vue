<template>
    <div>
        <h1>About us page</h1>
    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            content: {},
        };
    },
    mounted() {
        // axios
        //     .get("/ger/aboutus/content")
        //     .then((response) => {
        //         this.content = response.data;
        //     })
        //     .catch((error) => console.error(error));
    },
};
</script>

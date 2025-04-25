<template>
    <h3>Example Component</h3>
</template>

<script setup>
import { ref } from "vue";
const message = ref("Hello from Vue.js");
</script>

<style scoped>
.message-model {
    border: 1px solid yellow;
    text-align: center;
    border-radius: 10px;
    width: 80%;
    margin: auto;
    background-color: yellow;
}
.message-model p {
    font-weight: bold;
    font-size: 40px;
}
</style>

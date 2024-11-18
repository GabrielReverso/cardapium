<template>
    <div class="flex flex-row h-80 pt-10">
        <img src="../assets/bannoffee.jpg" alt="" class="h-full rounded-lg" style="aspect-ratio: 1/1;">
        <div class="flex flex-col h-full items-start ml-10 py-5 justify-around">
            <h2 class="text-3xl font-bold">Item</h2>
            <p class="text-2xl w-3/4 text-left">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent
                hendrerit nulla
                sit
                amet pharetra
                fringilla. Duis hendrer</p>
            <h2 class="text-3xl font-bold text-green-700">R$ 100,00</h2>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'Item',
});
</script>
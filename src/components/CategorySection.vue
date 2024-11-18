<template>
    <div class="flex flex-col h-auto w-full bg-gray-100 py-5 pl-16">
        <div class="flex flex-row w-full items-center self-start">
            <h1 class="text-3xl font-bold">{{ title }}</h1>
            <hr class="mx-8 flex-grow">
        </div>
        <Item />
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import Item from './Item.vue';

export default defineComponent({
    name: 'CategorySection',
    props: {
        title: {
            type: String,
            default: "Categoria"
        }
    },
    components: {
        Item
    }
});
</script>

<style scoped>
h1 {
    color: #2c3e50;
}

hr {
    border-color: #2c3e50;
    border-width: 1.5px;
}
</style>
<template>
    <div class="flex flex-col h-auto w-full py-5 pl-16 pr-16">
        <div class="flex flex-row w-full items-center self-start">
            <h1 class="text-3xl font-bold text-[#2c3e50]">{{ title }}</h1>
            <hr class="mx-8 flex-grow border-[#2c3e50] border-[1.5px]">
        </div>
        <template v-for="(item, index) in items" :key="index">
            <Item :title="item.title" />
            <hr v-if="index < items.length - 1" class="mr-8 flex-grow border-[#a3aab1] border-1">
        </template>
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
    },
    data() {
        return {
            items: [
                { title: "Item 1 da " + this.title },
                { title: "Item 2 da " + this.title },
                { title: "Item 3 da " + this.title }
            ]
        };
    },
    mounted() {
        console.log(this.title)
    }
});
</script>
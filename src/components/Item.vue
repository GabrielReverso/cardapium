<template>
    <div class="flex flex-row h-80 pt-10 mb-10">
        <img :src="getImagePath(imageName)" alt="Imagem do produto" class="h-full rounded-lg" style="aspect-ratio: 1/1;"
            loading="lazy">
        <div class="flex flex-col h-full w-full items-start ml-10 py-5 justify-around">
            <h2 class="text-3xl font-bold">{{ title }}</h2>
            <p class="text-2xl w-3/4 text-left">{{ description }}</p>
            <h2 class="text-3xl font-bold text-green-700">{{ formatPrice(price) }}</h2>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'Item',
    props: {
        imageName: {
            type: String,
            default: "bannoffee.jpg"
        },
        title: {
            type: String,
            default: "Item"
        },
        description: {
            type: String,
            default: "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent hendrerit nulla sit amet pharetra fringilla. Duis hendrer"
        },
        price: {
            type: Number,
            default: 100
        }
    },
    methods: {
        getImagePath(imageName: string): string {
            try {
                return require(`../assets/${imageName}`);
            } catch (error) {
                console.warn(`Imagem não encontrada: ${imageName}. Usando imagem padrão.`);
                return require('../assets/bannoffee.jpg');
            }
        },

        formatPrice(price: number): string {
            return `R$ ${(price).toFixed(2).replace('.', ',')}`;
        }
    }
});
</script>
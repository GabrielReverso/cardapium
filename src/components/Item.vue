<template>
    <div class="flex flex-row h-80 pt-10 mb-10">
        <img :src="getImagePath(imageName)" alt="Imagem do produto" class="h-full rounded-xl drop-shadow-sm"
            style="aspect-ratio: 1/1;" loading="lazy">
        <div class="flex flex-col h-full w-full items-start ml-10 py-5 justify-around">
            <h2 class="text-3xl font-bold">{{ title }}</h2>
            <p class="text-2xl w-11/12 text-left">{{ description }}</p>
            <h2 class="text-3xl font-bold text-green-700">{{ formatPrice(price) }}</h2>
            <button @click="addItemToBag"
                class="py-3 px-4 text-cardapiumText text-2xl font-bold drop-shadow-md bg-cardapiumComponent hover:bg-cardapiumComponentHover rounded-2xl">
                Adicionar
            </button>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

interface BagItem {
    id: number,
    title: string,
    price: number,
    imageName: string,
    qtd: number
}

export default defineComponent({
    name: 'Item',
    props: {
        imageName: {
            type: String,
            default: "CheeseOverload.png"
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
        },
        id: {
            type: Number,
            default: 0
        }
    },
    emits: ['add-item'],
    methods: {
        getImagePath(imageName: string): string {
            try {
                return require(`../assets/${imageName}`);
            } catch (error) {
                console.warn(`Imagem não encontrada: ${imageName}. Usando imagem padrão.`);
                return require('../assets/CheeseOverload.png');
            }
        },

        formatPrice(price: number): string {
            return `R$ ${(price).toFixed(2).replace('.', ',')}`;
        },

        addItemToBag() {
            const item: BagItem = {
                id: this.id,
                title: this.title,
                price: this.price,
                imageName: this.imageName,
                qtd: 1
            }

            if (document.getElementById("bag")?.classList.contains("collapsed")) {
                document.getElementById("item-changed")?.classList.remove("hidden")
            }

            //Enviar para Bag.vue
            //console.log("Item.vue => ", item)
            this.$emit('add-item', item)
        }
    }
});
</script>
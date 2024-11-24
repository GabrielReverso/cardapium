<template>
    <div class="flex flex-col h-auto w-full py-5 pl-16 pr-16">
        <div class="flex flex-row w-full items-center self-start">
            <h1 class="text-3xl font-bold text-cardapiumText">{{ title }}</h1>
            <hr class="mx-8 flex-grow border-cardapiumText border-[1.5px]">
        </div>
        <template v-for="(item, index) in items[title]" :key="index">
            <Item :title="item.nome" :description="item.descricao" :price="Number(item.preco)" :image-name="item.foto"
                :id="Number(item.id)" @add-item="$emit('add-item', $event)" />
            <hr v-if="index < items[title]?.length - 1" class="mr-8 flex-grow border-[#a3aab1] border-1">
        </template>
    </div>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';
import Item from './Item.vue';

interface FoodItem {
    id: string,
    categoria: string,
    nome: string,
    descricao: string,
    foto?: string | "bannoffee.jpg",
    preco: string
}

interface FoodItemsList {
    [key: string]: FoodItem[]
}

/* interface BagItem {
    id: number,
    title: string,
    price: number,
    imageName: string,
    qtd: number
} */

export default defineComponent({
    name: 'CategorySection',
    props: {
        title: {
            type: String,
            default: "Categoria"
        },
        items: {
            type: Object as PropType<FoodItemsList>,
            default: () => ({})
        }
    },
    components: {
        Item
    },
    /*     emits: ['add-item'],
        data() {
            return {
                bagItems: [] as BagItem[]
            };
        },
        methods: {
            addItemToBag(itemData: BagItem) {
                this.bagItems.push(itemData);
                console.log("Category.vue => ", this.bagItems);
                // Emitir o evento para App.vue
                this.$emit('add-item', itemData);
            }
        } */
}
);
</script>
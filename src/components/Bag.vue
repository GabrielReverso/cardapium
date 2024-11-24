<template>
    <aside id="bag" class="flex sticky top-0">
        <div id="bag-wrapper" class="flex w-full h-full">
            <div class="flex flex-col h-full w-full">
                <div id="bag-itens" class="flex flex-col w-10/12 h-[75%] mx-auto mt-5 rounded-xl p-5 relative">
                    <h1 class="text-left text-3xl font-bold self-center">Resumo do pedido</h1>
                    <div class="overflow-y-auto overflow-x-hidden mx-1 mt-4 mb-2 h-full">
                        <template v-for="(item, index) in items" :key="item.id">
                            <div class="flex flex-row w-full my-6">
                                <img :src="getImagePath(item.imageName)" alt="Imagem do produto"
                                    class="h-28 rounded-xl drop-shadow-sm aspect-square self-center" loading="lazy">
                                <div class="flex flex-col h-full w-full items-start ml-10 py-5 justify-around">
                                    <h2 class="text-xl font-bold">{{ item.title }}</h2>
                                    <h2 class="text-xl font-bold text-green-700">{{ formatPrice(item.price * item.qtd)
                                        }}</h2>
                                    <h2 class="text-xl font-bold">Quantidade: {{ item.qtd }}</h2>
                                    <div class="flex flex-row">
                                        <button class="" @click="removeSingle(index)">Tirar</button>
                                        <button class="ml-2" @click="removeAll(index)">Remover</button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <h3 class="w-10/12 text-left text-3xl mx-auto mt-auto text-[#f0f0f0] font-bold">Total: R$ 100,00</h3>
                <div class="flex flex-row w-10/12 h-fit m-auto justify-between">
                    <button @click="cancelHandler"
                        class="w-5/12 h-fit rounded-2xl py-3 bg-cardapiumComponent drop-shadow-2xl transition-colors hover:bg-cardapiumComponentHover">
                        <p class="text-2xl font-bold">Cancelar</p>
                    </button>
                    <button
                        class="w-5/12 h-fit rounded-2xl py-3 bg-cardapiumComponent drop-shadow-2xl transition-colors hover:bg-cardapiumComponentHover">
                        <p class="text-2xl font-bold">Pagar</p>
                    </button>
                </div>
            </div>
        </div>
        <div id="collapse-button" class="w-[70px] h-[60px] absolute bg-cardapiumSecondary hover:cursor-pointer"></div>
    </aside>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue';

interface BagItem {
    id: number,
    title: string,
    price: number,
    imageName: string,
    qtd: number
}

export default defineComponent({
    name: 'Bag',
    props: {
        items: {
            type: Array as PropType<BagItem[]>,
            default: () => []
        }
    },
    methods: {
        handleCollapseButton() {
            //console.log("clicado");
            document.querySelector("#bag")?.classList.toggle("collapsed")
            document.querySelector("#bag-wrapper")?.classList.toggle("collapsed")
        },
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
        },
        cancelHandler(): void {
            this.items.splice(0, this.items.length)
        },
        removeSingle(index: number): void {
            this.items[index].qtd > 1 ? this.items[index].qtd-- : null
        },
        removeAll(index: number): void {
            this.items.splice(index, 1)
        }
    },
    mounted() {
        document.querySelector('#collapse-button')?.addEventListener('click', () => this.handleCollapseButton());
    },
    beforeUnmount() {
        document.querySelector('#collapse-button')?.removeEventListener('click', () => this.handleCollapseButton());
    }
});
</script>

<style scoped>
#bag {
    width: 700px;
    max-width: 50vw;
    min-height: calc(100vh - 6rem - 11rem);
    max-height: 100vh;
    background-color: #0A7273;
    filter: drop-shadow(-1px 0px 5px rgba(0, 0, 0, 0.345));
    transition: all .2s ease-in-out;
}

#bag-wrapper {
    content-visibility: auto;
    transition: all .2s ease-in;
}

#bag.collapsed {
    width: 0px;
}

#bag-wrapper.collapsed {
    content-visibility: hidden;
}

#collapse-button {
    transform: translateX(-70px);
    /* border-top-left-radius: -10px; */
    border-bottom-left-radius: 50%;
}

#bag::after {
    content: "";
    width: 50px;
    height: 50px;
    position: absolute;
    /* background-color: #0A7273; */
    transform: translateX(-40px) translateY(49px);
    border-right-width: 10px;
    border-top-width: 10px;
    border-top-right-radius: 50%;
    /* border-top-width: 1px; */
    border-color: #0A7273;
    pointer-events: none;
}

#bag-itens {
    background-color: #E8E8E8;
}
</style>
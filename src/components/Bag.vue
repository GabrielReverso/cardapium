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
                                    <div class="flex flex-row">
                                        <h2 class="text-xl font-bold mr-3">Quantidade:</h2>
                                        <button @click="removeSingle(index)"
                                            class="mr-3 py-[1px] px-[2px] aspect-square rounded-lg drop-shadow-sm bg-gray-50"><i
                                                class="icon-minus"></i></button>
                                        <h2 class="mr-3 text-xl font-bold">{{ item.qtd }}</h2>
                                        <button @click="addSingle(index)"
                                            class="mr-3 py-[1px] px-[2px] aspect-square rounded-lg drop-shadow-sm bg-gray-50"><i
                                                class="icon-plus"></i></button>
                                    </div>
                                    <div class="flex flex-row">
                                        <button class="text-red-900 mr-1 text-lg"
                                            @click="removeAll(index)">Remover</button>
                                        <i class="icon-trash text-red-900 text-lg"></i>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
                <h3 class="w-10/12 text-left text-3xl mx-auto mt-auto text-[#f0f0f0] font-bold">Total: {{
                    formatPrice(getTotal()) }}
                </h3>
                <div class="flex flex-row w-10/12 h-fit m-auto justify-between">
                    <button @click="cancelHandler"
                        class="w-5/12 h-fit rounded-2xl py-3 bg-cardapiumComponent drop-shadow-2xl transition-colors hover:bg-cardapiumComponentHover">
                        <p class="text-2xl font-bold">Cancelar</p>
                    </button>
                    <button v-if="items.length === 0" disabled
                        class="w-5/12 h-fit rounded-2xl py-3 bg-cardapiumComponentDisabled drop-shadow-2xl transition-colors">
                        <p class="text-2xl font-bold">Pagar</p>
                    </button>
                    <button v-else @click="paymentHandler"
                        class="w-5/12 h-fit rounded-2xl py-3 bg-cardapiumComponent drop-shadow-2xl transition-colors hover:bg-cardapiumComponentHover">
                        <p class="text-2xl font-bold">Pagar</p>
                    </button>
                </div>
            </div>
        </div>
        <div id="collapse-button"
            class="w-[70px] h-[60px] absolute flex justify-center items-center bg-cardapiumSecondary hover:cursor-pointer">
            <svg class="h-3/4 aspect-square" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M12 3C10.3432 3 9.00005 4.34315 9.00005 6H15C15 4.34315 13.6569 3 12 3ZM7.00005 6C7.00005 3.23858 9.23863 1 12 1C14.7615 1 17 3.23858 17 6H16.3441C16.7794 6.00005 17.1599 6.0013 17.4791 6.026C17.8369 6.05369 18.1919 6.11475 18.5417 6.27628C19.0471 6.50961 19.4776 6.87893 19.785 7.34294C19.9979 7.66418 20.1122 8.00569 20.194 8.35514C20.2709 8.68375 20.3324 9.08359 20.4031 9.54318L20.8541 12.4751C21.0468 13.7273 21.2014 14.7319 21.2546 15.5469C21.3091 16.3818 21.2669 17.1241 20.9938 17.8221C20.5817 18.8752 19.8247 19.7575 18.8465 20.325C18.1981 20.7011 17.4709 20.8556 16.6375 20.9287C15.8239 21 14.8074 21 13.5406 21H10.4595C9.19267 21 8.17621 21 7.36265 20.9287C6.52917 20.8556 5.80196 20.7011 5.15361 20.325C4.17539 19.7575 3.41842 18.8752 3.00631 17.8221C2.73317 17.1241 2.69104 16.3818 2.74554 15.5469C2.79873 14.732 2.9533 13.7273 3.14594 12.4752L3.59703 9.54315C3.66772 9.08358 3.72921 8.68375 3.80611 8.35514C3.88789 8.00569 4.0022 7.66418 4.21506 7.34294C4.52251 6.87893 4.953 6.50961 5.45837 6.27628C5.80824 6.11475 6.16316 6.05369 6.52098 6.026C6.84022 6.0013 7.22073 6.00005 7.656 6H7.00005ZM6.67528 8.02004C6.43801 8.0384 6.34578 8.06944 6.29671 8.09209C6.12826 8.16987 5.98476 8.29298 5.88228 8.44765C5.85243 8.4927 5.80772 8.57914 5.7535 8.81085C5.69635 9.05506 5.64603 9.3776 5.56836 9.88243L5.12984 12.7328C4.9284 14.0422 4.7881 14.9601 4.74129 15.6772C4.69513 16.3844 4.74974 16.789 4.86878 17.0932C5.11605 17.7251 5.57023 18.2545 6.15717 18.595C6.43973 18.7589 6.83136 18.8744 7.53736 18.9363C8.25323 18.9991 9.18181 19 10.5066 19H13.4935C14.8183 19 15.7469 18.9991 16.4627 18.9363C17.1687 18.8744 17.5604 18.7589 17.8429 18.595C18.4299 18.2545 18.884 17.7251 19.1313 17.0932C19.2504 16.789 19.305 16.3844 19.2588 15.6772C19.212 14.9601 19.0717 14.0422 18.8703 12.7328L18.4317 9.88243C18.3541 9.37761 18.3037 9.05507 18.2466 8.81085C18.1924 8.57914 18.1477 8.4927 18.1178 8.44765C18.0153 8.29298 17.8718 8.16987 17.7034 8.09209C17.6543 8.06944 17.5621 8.0384 17.3248 8.02004C17.0748 8.00069 16.7483 8 16.2376 8H7.76255C7.25178 8 6.92534 8.00069 6.67528 8.02004Z"
                    fill="#f5f5f5" />
            </svg>
            <span id="item-changed"
                class="right-0 drop-shadow-md absolute rounded-full bg-red-500 h-3 aspect-square hidden"></span>
        </div>
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

interface Order {
    userID: number | undefined,
    userName: string | undefined,
    itemIds: number[],
    itemQtds: number[],
    itemPrices: number[]
}

declare global {
    var userID: number | undefined;
    var userName: string | undefined;
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
            document.getElementById("item-changed")?.classList.add("hidden")
        },
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
        cancelHandler(): void {
            this.items.splice(0, this.items.length)
        },
        removeSingle(index: number): void {
            this.items[index].qtd > 1 ? this.items[index].qtd-- : null
        },
        addSingle(index: number): void {
            this.items[index].qtd++
        },
        removeAll(index: number): void {
            this.items.splice(index, 1)
        },
        getTotal(): number {
            let total = 0

            this.items.map(item => {
                total += item.price * item.qtd
            })

            return total
        },
        paymentHandler(): void {

            if (globalThis.userID && globalThis.userName) {
                let order: Order = {
                    userID: globalThis.userID,
                    userName: globalThis.userName,
                    itemIds: [],
                    itemQtds: [],
                    itemPrices: []
                }

                this.items.map(item => {
                    order.itemIds.push(item.id)
                    order.itemQtds.push(item.qtd)
                    order.itemPrices.push(item.price * item.qtd)
                })

                console.log(order)

                fetch("http://localhost:8000/orders.php", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `carrinho=${JSON.stringify({
                        userID: order.userID,
                        userName: order.userName,
                        itens: order.itemIds,
                        quantidade: order.itemQtds,
                        precoRelativo: order.itemPrices
                    })}`
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data)
                    })
                    .catch(error => console.error('Error:', error));
            } else {
                const element = document.getElementById(`login-modal`)
                element?.classList.remove('hidden')
                element?.classList.add('flex')
                document.body.classList.add('overflow-y-hidden')
                console.log("Usuário inválido")
            }
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
    min-width: 550px;
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
    min-width: 12px;
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

#item-changed {
    transform: translate(-40%, -90%);
}
</style>
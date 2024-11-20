<template>
    <aside id="bag" class="flex sticky top-0">
        <div class="flex flex-col h-full w-full">
            <div id="bag-itens" class="w-10/12 h-[75%] mx-auto mt-5 rounded-xl overflow-y-auto p-5">
                <h1 class="text-left text-2xl font-bold">Resumo do pedido</h1>
            </div>
            <h3 class="w-10/12 text-left text-xl mx-auto mt-auto text-[#f0f0f0] font-bold">Total: R$ 100,00</h3>
            <div class="flex flex-row w-10/12 h-fit m-auto justify-between">
                <button
                    class="w-5/12 h-fit rounded-2xl py-3 bg-[#FDA521] drop-shadow-xl transition-colors hover:bg-[#db901e]">
                    <p class="text-xl font-bold">Cancelar</p>
                </button>
                <button
                    class="w-5/12 h-fit rounded-2xl py-3 bg-[#FDA521] drop-shadow-xl transition-colors hover:bg-[#db901e]">
                    <p class="text-xl font-bold">Pagar</p>
                </button>
            </div>
        </div>
    </aside>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent({
    name: 'Bag',
});
</script>

<style scoped>
#bag {
    width: 700px;
    min-height: calc(100vh - 7rem - 11rem);
    max-height: 100vh;
    background-color: #0A7273;
    filter: drop-shadow(-1px 0px 5px rgba(0, 0, 0, 0.345));
}

#bag::before {
    content: "";
    width: 70px;
    height: 60px;
    position: absolute;
    background-color: #0A7273;
    transform: translateX(-70px);
    border-top-left-radius: -10px;
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
}

#bag-itens {
    background-color: #E8E8E8;
}
</style>
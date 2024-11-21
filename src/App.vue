<template>
  <!-- <div class="flex flex-row relative"> -->
  <div class="flex flex-col flex-grow">
    <template v-for="(category, index) in receivedCategories" :key="index">
      <CategorySection :title="category.title" :items="items" />
    </template>
  </div>
  <Bag />
  <!-- </div> -->
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import CategorySection from './components/CategorySection.vue';
import Bag from './components/Bag.vue';

interface ReceivedCategory {
  title: string;
}

interface FoodItem {
  id: string,
  categoria: string,
  nome: string,
  descricao: string,
  foto?: string,
  preco: string
}

interface FoodItems {
  [key: string]: FoodItem[]
}

export default defineComponent({
  name: 'App',
  components: {
    CategorySection,
    Bag
  },
  data() {
    return {
      /*  categories: [
         { title: "Categoria 1" },
         { title: "Categoria 2" },
         { title: "Categoria 3" },
         { title: "Categoria 4" },
         { title: "Categoria 5" }
       ], */
      receivedCategories: [] as ReceivedCategory[],
      //receivedItems: [] as ReceivedItems[]
      items: {} as FoodItems
    };
  },
  mounted() {
    const self = this;

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        var dados: FoodItems = JSON.parse(this.responseText);

        self.items = { ...dados }

        console.log(self.items)

        // Extrair as chaves do objeto JSON e adicionar ao array receivedCategories
        Object.keys(dados).forEach(category => {
          self.receivedCategories.push({ title: category });
          /* Object.values(dados[category]).forEach(item => {
            self.receivedItems.push({ title: item.Nome, category: item.categoria })
          }) */
        });

        //console.log(self.receivedCategories);
        //console.log(self.receivedItems);
      }
    } // Use bind para acessar o contexto 'this' corretamente

    xhr.open("POST", "http://localhost:8000/home.php", true);
    xhr.send();
  }
});
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>

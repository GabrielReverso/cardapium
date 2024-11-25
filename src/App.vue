<template>
  <div class="flex flex-col flex-grow">
    <h1 class="font-bold text-4xl mt-5">CARDÁPIO</h1>
    <template v-for="(category, index) in receivedCategories" :key="index">
      <CategorySection @add-item="addItemToBag" :title="category.title" :items="items" />
    </template>
  </div>
  <Bag :items="bagItems" />
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
  foto?: string | "CheeseOverload.png",
  preco: string
}

interface FoodItemsList {
  [key: string]: FoodItem[]
}

interface BagItem {
  id: number,
  title: string,
  price: number,
  imageName: string,
  qtd: number
}

export default defineComponent({
  name: 'App',
  components: {
    CategorySection,
    Bag
  },
  data() {
    return {
      receivedCategories: [] as ReceivedCategory[],
      items: {} as FoodItemsList,
      bagItems: [] as BagItem[]
    };
  },
  methods: {
    addItemToBag(itemData: BagItem) {
      const existingItem = this.bagItems.find(i => i.id === itemData.id);
      existingItem ? existingItem.qtd++ : this.bagItems.push(itemData);
    }
  },
  mounted() {
    const self = this;

    var xhr = new XMLHttpRequest();

    xhr.onerror = function (error) {
      console.error('Erro na requisição:', error);
      handleDefaultData();
    };

    xhr.onreadystatechange = function () {
      if (this.readyState == 4) {
        if (this.status == 200) {
          try {
            var dados: FoodItemsList = JSON.parse(this.responseText);
            self.items = { ...dados };
            console.log(self.items);
            Object.keys(dados).forEach(category => {
              self.receivedCategories.push({ title: category });
            });
          } catch (error) {
            console.error('Erro ao parsear JSON:', error);
            handleDefaultData();
          }
        } else {
          console.warn(`Status não 200: ${this.status}`);
          handleDefaultData();
        }
      }
    };

    xhr.open("POST", "http://localhost:8000/getData.php", true);
    xhr.send();

    function handleDefaultData() {
      // Definir dados padrão em caso de erro
      self.items = {
        "Exemplo": [{
          nome: 'Item de exemplo',
          id: '1',
          categoria: 'Exemplo',
          descricao: 'Item de exemplo, se está vendo isso ocorreu algum erro no banco de dados ou o site está em modo de demonstração',
          preco: '100.00'
        }]
      };
      self.receivedCategories = [
        { title: "Exemplo" },
      ];
    }
  }
});
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
}
</style>

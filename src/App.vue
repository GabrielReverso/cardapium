<template>
  <!-- <div class="flex flex-row relative"> -->
  <div class="flex flex-col flex-grow">
    <template v-for="(category, index) in categories" :key="index">
      <CategorySection :title="category.title" />
    </template>
  </div>
  <Bag />
  <!-- </div> -->
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import CategorySection from './components/CategorySection.vue';
import Bag from './components/Bag.vue';

export default defineComponent({
  name: 'App',
  components: {
    CategorySection,
    Bag
  },
  data() {
    return {
      categories: [
        { title: "Categoria 1" },
        { title: "Categoria 2" },
        { title: "Categoria 3" },
        { title: "Categoria 4" },
        { title: "Categoria 5" }
      ]
    };
  },
  mounted() {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        var dados = JSON.parse(this.responseText)
        console.log(dados)
      }
    };

    xhr.open("POST", "http://localhost:8000/home.php", true)
    xhr.send()
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

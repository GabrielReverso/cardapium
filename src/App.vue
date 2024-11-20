<template>
  <!-- <div class="flex flex-row relative"> -->
  <div class="flex flex-col flex-grow">
    <CategorySection title="Categoria 1" />
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

<template>
<div>
  <form v-if="addNew">
  <input v-model="plant.name" placeholder="Name" type="text" name="AddNewPlant" id="">
  <input v-model="plant.water" placeholder="How much water?" type="text" name="AddNewPlant" id="">
  </form>
  <button v-on:click="AddNewPlant">Add New Plant</button>
    <ul>
     <li is="plant-item" v-for="(plant, index) in plants" :key="plant.id" :index="index" v-bind:plant="plant" @del="deletePlant"></li>
    </ul>
  </div>
</template>

<script>
import PlantItem from "./PlantItem.vue";
export default {
  name: "PlantList",
  data() {
    return {
      addNew: false,
      plant : {name : '', water : ''},
    };
  },
  props: {
    msg: String,
    plants: Array
  },
    components: {
    PlantItem
  },
  methods: {
    AddNewPlant() {
      if(this.addNew) {
        this.$emit('createPlant', this.plant.name, this.plant.water, '2018-05-19 17:46:28')
        this.plant.name = '';
        this.plant.water= '';
      }
      this.addNew = !this.addNew;
    },
    deletePlant(id) {
      this.$emit('deletePlant', id);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  ul {
    list-style: none;
    text-align: left;
    display: inline-block;
  }

</style>

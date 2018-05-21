<template>
  <div id="app">
    <plant-list v-bind:plants="plants" @createPlant="createNewPlant" @deletePlant="deletePlant"></plant-list>
  </div>
</template>

<script>
  function Plant({ id, water, name}) {
    this.id = id;
    this.water = water;
    this.name = name;
  }
import PlantList from "./PlantList.vue";
import PlantItem from "./PlantItem.vue";

export default {
  name: "app",
  data() {
    return {
      plants: this.initialPlants,
    };
  },
  components: {
    PlantList,
    PlantItem
  },
    props: {
    initialPlants: Array
  },
  methods: {
    createNewPlant: function(name, water, water_interval) {
      window.axios.post('/api/plants', {name, water, water_interval}).then(({ data }) => {
        this.plants.push(new Plant(data));
        console.log(this);
        this.$forceUpdate()
      });
    },
    deletePlant: function(id) {
      window.axios.delete(`/api/plants/${id}`).then(() => {
        let index = this.plants.findIndex(plant => plant.id === id);
        this.plants.splice(index, 1);
      });
    }
  }
};
</script>

<style>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>

<template>
  <div id="app">

      <button class="c-button c-button--plant" v-on:click="createNewPlant"><i class="fas fa-leaf"></i>Add New Plant</button>
      <form v-on:submit.prevent v-if="addNew">
          <input v-model="plant.name" placeholder="Name" type="text" id="">
          <input v-model="plant.water" placeholder="How much water?" type="text" id="">
          <input v-model="plant.water_interval" placeholder="How often?" type="text" id="">
      </form>


      <div v-else>
          
        <div v-if="thirstyPlants.length > 0">

            <h3>Theses plants are thirsty!</h3>
            <plant-list 
            v-bind:plants="thirstyPlants"
            @deletePlant="deletePlant"
            @waterPlant="waterPlant">
            </plant-list>
            <button class="c-button c-button--water" @click="waterAll"><i class="fas fa-tint"></i>water all</button>
        </div>

          <hr>

          <plant-list v-bind:plants="wateredPlants"
          @deletePlant="deletePlant"
          @waterPlant="waterPlant">
          </plant-list>

      </div>


  </div>
</template>

<script>
function Plant({ id, water, name, water_interval, water_next }) {
  this.id = id;
  this.water = water;
  this.name = name;
  this.water_interval = water_interval;
  this.water_next = water_next;
}
import PlantList from "./PlantList.vue";
import PlantItem from "./PlantItem.vue";

export default {
  name: "app",
  data() {
    return {
      addNew: false,
      plant: { name: "", water: "", water_interval: ""},
      plants: this.initialPlants
    };
  },
  components: {
    PlantList,
    PlantItem
  },
  computed: {
    wateredPlants: function() {
      let filterdPlants = new Array;
      this.plants.forEach(plant => {
        let now = new Date();
        let waterNext = new Date(plant.water_next);
        let timeTilWatering = waterNext - now;
        if(Math.round(timeTilWatering/(1000*60*60*24)) > 0) {
          filterdPlants.push(plant);
        }
      });
      return filterdPlants;
    },
      thirstyPlants: function() {
      let filterdPlants = new Array;
      this.plants.forEach(plant => {
        let now = new Date();
        let waterNext = new Date(plant.water_next);
        let timeTilWatering = waterNext - now;
        if(Math.round(timeTilWatering/(1000*60*60*24)) <= 0) {
          filterdPlants.push(plant);
        }
      });
      return filterdPlants;
    }
  },
  props: {
    initialPlants: Array
  },
  methods: {
    createNewPlant: function() {
      if (this.addNew) {
        window.axios
          .post("/api/plants", {
            name: this.plant.name,
            water: this.plant.water,
            water_interval: this.plant.water_interval
          })
          .then(({ data }) => {
            this.plants.push(new Plant(data));
          });
        this.plant.name = "";
        this.plant.water = "";
        this.plant.water_interval = "";
      }
      this.addNew = !this.addNew;
    },
    deletePlant: function(id) {
      window.axios.delete(`/api/plants/${id}`).then(() => {
        let index = this.plants.findIndex(plant => plant.id === id);
        this.plants.splice(index, 1);
      });
    },
    waterPlant: function(plant) {
      let water_next = new Date();
      water_next.setTime(
        water_next.getTime() + plant.water_interval * 86400000
      );
      window.axios
        .patch(`/api/plants/${plant.id}`, {
          name: plant.name,
          water: plant.water,
          water_interval: plant.water_interval,
          water_next
        })
        .then(({ data }) => {
          let index = this.plants.findIndex(plant => plant.id === data.id);
          Vue.set(this.plants, index, new Plant(data));
        });
    },
    waterAll: function() {
      this.thirstyPlants.forEach(plant => {
        this.waterPlant(plant);
      });
    },
  }
};
</script>

<style scoped>
#app {
  font-family: "Avenir", Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #c8c8c8;
  margin-top: 60px;
}
.c-button {
  padding: 16px 26px;
  border: none;
  border-radius: 6px;
  font-weight: bold;
  text-transform: uppercase;
  letter-spacing: 1px;
  min-width: 200px;
}
.c-button--plant {
    color: #1d1d1d;
    background-color: #259e4d;
}
.c-button--water {
  background-color: #2989b6;
  color: #000;
}
i{
  padding-right: 10px;
}
</style>

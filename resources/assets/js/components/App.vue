<template>
  <div id="app">

      <button class="c-button c-button--plant" v-on:click="createNewPlant"><i class="fas fa-leaf"></i>Add New Plant</button>
      <form v-on:submit.prevent v-if="addNew">
          <input v-model="plant.name" placeholder="Name" type="text" id="">
          <input v-model="plant.water" placeholder="How much water?" type="text" id="">
          <input v-model="plant.water_interval" placeholder="How often?" type="text" id="">
      </form>


      <div v-else>
          
<!--         <div v-if="thirstyPlants.length > 0">

            <h3>Theses plants are thirsty!</h3>
            <plant-list 
            v-bind:plants="thirstyPlants"
            @deletePlant="deletePlant"
            @waterPlant="waterPlant">
            </plant-list>
            <button class="c-button c-button--water" @click="waterAll"><i class="fas fa-tint"></i>water all</button>
        </div> -->

          <plant-list v-bind:plants="sortedPlants"
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
  this.timeTilWatering = '';
  this.isLastThirsty = false;
}
import PlantList from "./PlantList.vue";
import PlantItem from "./PlantItem.vue";

export default {
  name: "app",
  data() {
    return {
      addNew: false,
      plant: { name: "", water: "", water_interval: "", timeTilWatering: ""},
      plants: this.initiatePlants(this.initialPlants),
    };
  },
  components: {
    PlantList,
    PlantItem
  },
  computed: {
    sortedPlants: function() {
      let wateredPlants = new Array;
      let thirstyPlants = new Array;
      this.plants.forEach(plant => {
        plant.isLastThirsty = false;
        let now = new Date();
        let waterNext = new Date(plant.water_next);
        plant.timeTilWatering = waterNext - now;
        if(Math.round(plant.timeTilWatering/(1000*60*60*24)) > 0) {
          wateredPlants.push(plant);
        }
        else if(Math.round(plant.timeTilWatering/(1000*60*60*24)) <= 0) {
          thirstyPlants.push(plant);
        }
      });
        wateredPlants.sort(function(a, b){return a.timeTilWatering-b.timeTilWatering});
        thirstyPlants.sort(function(a, b){return a.timeTilWatering-b.timeTilWatering});
        if(thirstyPlants.length > 0 && wateredPlants.length > 0) {
          thirstyPlants[thirstyPlants.length - 1].isLastThirsty = true;
        }
        Array.prototype.push.apply(thirstyPlants, wateredPlants);
      return thirstyPlants;
    },
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
    initiatePlants: function(rawPlants) {
      let preparedPlants = new Array;
      rawPlants.forEach(plant => {
        preparedPlants.push(new Plant(plant));
      });
      return preparedPlants;
    }
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

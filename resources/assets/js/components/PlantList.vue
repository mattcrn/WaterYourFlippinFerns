<template>
    <div>
        <div>
          <h3>{{ title }}</h3>
            <ul>
                <li is="plant-item" v-for="(plant, index) in plants" :key="plant.id" :index="index" v-bind:plant="plant" 
                @del="deletePlant" 
                @water="waterPlant"
                ></li>
            </ul>
        </div>
    </div>
</template>

<script>
import PlantItem from "./PlantItem.vue";
export default {
  name: "PlantList",
  data() {
    return {
    };
  },
  props: {
    plants: Array,
    title: String,
  },
    components: {
    PlantItem
  },
  methods: {
    deletePlant(id) {
      this.$emit('deletePlant', id);
    },
    waterPlant(plant) {
      this.$emit('waterPlant', plant);
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
    padding-left: 0px;
    width: 100%;
  }

</style>

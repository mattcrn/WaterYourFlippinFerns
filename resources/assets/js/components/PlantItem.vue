<template>
     <li class="c-plant-item">
       <div class="basic-info">
       <p class="c-plant-item__title">{{ plant.name }}</p>
       <sub v-if="TimetilWatering == 0" class="c-text--warning c-plant-item__subtext">- needs water today</sub>
       <sub v-else-if="TimetilWatering < 0" class="c-text--alert c-plant-item__subtext">- is thirsty since {{ TimetilWatering * (-1) }} day{{ (TimetilWatering != -1) ? 's' : ''}}</sub>
       <sub v-else-if="TimetilWatering > 0"  class="c-text--notice c-plant-item__subtext">needs water in {{ TimetilWatering }} day{{ (TimetilWatering != 1) ? 's' : ''}} </sub>
       </div>
<!--        <div class="water">
         <i class="fas fa-tint" style="color: blue" v-for="n in parseInt(plant.water)" :key="n"></i>
         <i class="fas fa-tint" style="color: grey" v-for="n in parseInt(4 - plant.water)" :key="n"></i>
       </div> -->
       <div class="c-plant-item__actions">
        <button class="c-button c-button--water" @click="water"><i class="fas fa-tint"></i></button>
        <button class="c-button c-button--menu" @click="showPopUp = !showPopUp"><i class="fas fa-ellipsis-v"></i></button>
        <div class="c-pop-up" v-if="showPopUp">
        <div class="c-pop-up__overlay" @click="showPopUp = !showPopUp"></div>
         <ul class="c-pop-up__ul">
           <li class="c-pop-up__item"><a>Edit</a></li>
           <li class="c-pop-up__item"><a>Delete</a></li>
         </ul>
       </div>
    </div>
  </li>
</template>
<script>
export default {
  name: "PlantItem",
  props: {
    plant: Object
  },
  data() {
    return {
      showPopUp: false
    };
  },
  computed: {
    waterNext: function() {
      return new Date(this.plant.water_next);
    },
    TimetilWatering: function() {
      let now = new Date();
      let timeTilWatering = this.waterNext - now;
      return Math.round(timeTilWatering / (1000 * 60 * 60 * 24));
    }
  },
  methods: {
    del: function() {
      this.$emit("del", this.plant.id);
    },
    water: function() {
      this.$emit("water", this.plant);
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.c-plant-item__actions {
  position: relative;
  align-self: center;
  flex-shrink: 0;
}
.c-plant-item {
  padding: 16px 40px;
  background-color: #3f3f3f;
  margin: 15px;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
  display: flex;
  flex-direction: row;
  justify-content: center;
  padding-right: 20px;
  padding-left: 30px;
  justify-content: space-between;
  border-radius: 10px;
}
.c-pop-up__overlay {
  position: absolute;
  position: fixed;
  height: 100%;
  width: 100%;
  left: 0px;
  top: 0px;
  z-index: 1;
}
.c-pop-up {
  position: absolute;
  top: 0px;
  background-color: #262323;
  right: -1px;
}
.c-pop-up__ul {
  padding: 10px 15px;
  z-index: 2;
  position: relative;
}
.c-pop-up__item {
  list-style: none;
}
.c-button {
  background-color: transparent;
  border: none;
  font-size: 18px;
  cursor: pointer;
}
.c-button--water {
  color: #1d1d1d;
  height: 50px;
  width: 50px;
  background-color: #2989b6;
  border-radius: 100%;
  margin: 0px 20px;
}
.c-button--menu {
  color: #c8c8c8;
}
.c-plant-item__subtext {
  color: #bababa;
  font-size: 12px;
}
.c-plant-item__title {
  font-size: 18px;
  margin-bottom: 0em;
}
</style>

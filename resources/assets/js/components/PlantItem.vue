<template>
     <li>{{ plant.name }} - {{ plant.water }}<button @click="del">del</button></li>
</template>
<script>
export default {
  name: "PlantItem",
  props: {
    plant: Object
  },
  methods: {
    del: function() {
      this.$emit('del', this.plant.id)
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>

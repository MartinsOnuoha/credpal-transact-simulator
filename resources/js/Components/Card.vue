<template>
  <div :class="`card shadow-1 ${customClass}`" :style="`height: ${height}; width: ${width}`">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'card',
  props: {
    height: {
      type: String,
      default: '100px',
    },
    width: {
      type: String,
      default: '300px',
    },
    customClass: {
      type: String,
      required: false
    }
  }
}
</script>

<style lang="scss">
  .card {
    padding: 10px;
    background-color: #FFF;
  }
</style>

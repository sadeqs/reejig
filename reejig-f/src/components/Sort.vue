<template>
  <div>
    {{ title }}
    <br />
    <a 
      href="" 
      class="order"
      @click.prevent=""
    >{{orderBy===1 ? "ASC" : "DESC"}}</a>
  </div>
</template>

<script>
export default {
  props: [
    'title',
    'orderBy',
  ]
}
</script>

<style scoped>
  .order{
    text-decoration: none;
    font-weight: normal;
  }
</style>
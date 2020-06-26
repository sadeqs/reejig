<template>
  <div id="app">
    <search />
  </div>
</template>

<script>
import Search from './page/search';
export default {
  name: 'app',
  data () {
    return {
      msg: ''
    }
  },
  components: {
    Search,
  }
}
</script>

<style>

</style>

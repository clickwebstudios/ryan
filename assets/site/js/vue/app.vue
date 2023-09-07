<style lang="scss" scoped>
  
</style>
<template>
  <div class="main_layout">
    <router-view />
  </div>
</template>

<script>
export default {
  components:{
    
  },
  data() {
    return {
      
    };
  },
  computed:{

  },
  watch:{
    
  },
  mounted(){
    window.tempMainSiteApp = this;
  }
}
</script>
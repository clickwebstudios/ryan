<style lang='scss' scoped>
.empty_block{
  width: 100%;
  min-height: 500px;
}
</style>
<template>
  <div ref="loader">
    <template v-if="loader">
      <div class="empty_block"></div>
    </template>
    <template v-else>
      <router-view />
    </template>
  </div>
</template>

<script>
export default {
  components:{
    
  },
  data() {
    return {
      loader: null,
    }
  },
  computed:{
    appInited(){
      return this.$store.getters.appInited;
    },
  },
  watch:{
    appInited(){
      this.checkLoader();
    }
  },
  methods:{
    checkLoader(){
      if(this.appInited){
        this.closeLoader();
      }else{
        this.openLoader();
      }
    },
    closeLoader(){
      if(!this.loader){
        return;
      }
      this.loader.hide();
      this.loader = null;
    },
    openLoader(){
      this.loader = this.$loading.show({
        container: this.$refs.loader,
      });
    },
  },
  mounted () {
    this.checkLoader();
  },
}
</script>
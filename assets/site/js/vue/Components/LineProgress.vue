<style lang='scss' scoped>
.line_progress_component{
  &.mobile_version{
    .controll_panel {
      padding: 17px 0px 50px;
      justify-content: center;
    }
  }
}
</style>
<template>
  <div class="line_progress_component" :class="{mobile_version: isSmScreen}">
    <div class="line_progress">
      <div 
        class="cell_line" 
        v-for="elNumber in cels"
        :class="{active : step >= elNumber, last_child: step == elNumber}"
      ></div>
    </div>
    <div class="controll_panel">
      <div class="cell_back" v-if="!isSmScreen">
        <span class="icon_left" @click="needPrev" v-if="allowPrevBtn"></span>
      </div>
      <div class="summ_q">
        <span class="summ_q_text">
          Questions:
        </span>
        <span class="summ_q_val">
          {{ step }}/{{ count }}
        </span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components:{
    
  },
  props:{
    allowPrevBtn:{
      type: Boolean,
      default: true,
    },
    step:{
      type: Number,
      default: 1,
    },
    count:{
      type: Number,
      default: 1,
    }
  },
  data() {
    return {
      loader: null,
    }
  },
  computed: {
    isLgScreen() {
      return this.mobilee.lg;
    },
    isMdScreen() {
      return this.mobilee.md && !this.mobilee.lg;
    },
    isSmScreen() {
      return this.mobilee.sm && !this.mobilee.lg && !this.mobilee.md;
    },
    cels(){
      let el = [];
      for (let i = 0; i < this.count; i++) {
        el.push(i+1);
      }
      return el;
    },
  },
  methods:{
    closeLoader(){
      if(!this.loader){
        return;
      }
      this.loader.hide();
      this.loader = null;
    },
    openLoader(){
      this.loader = this.$loading.show();
    },
    needPrev(){
      this.openLoader();
      setTimeout(() => {
        this.closeLoader();
        this.$emit('needPrev');
      }, 300);
    },
  },
  mounted () {
    window.tempLineProgress = this;
  },
}
</script>
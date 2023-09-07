<style lang="scss" scoped>
.modalresult_score_component, .slot_outer{
  display: inline-flex;
}
</style>
<style lang="scss">
.fix_cells{
  .cell_results_component{
    padding: 0px !important;
  }
}
</style>
<template>
  <div class="modalresult_score_component">
    <div class="slot_outer" @click="openModal">
      <slot />
    </div>
    
    <a-modal
      width="900px"
      v-model:visible="showModal"
      :footer="null"
      title="Results"
      >
      <div class="fix_cells">
        <CellResults 
          :id="item.id"
        />
      </div>
    </a-modal>
    
  </div>
</template>

<script>
import CellResults from 'vuec/Components/CellResults.vue';
  
export default {
  components: {
    CellResults
  },
  props:{
    item:{
      type: Object,
      default(){
        return {};
      }
    }
  },
  data() {
    return {
      loading: false,
      showModal: false,
    };
  },
  methods: {
    openModal(){
      this.showModal = true;
    }
  },
  mounted() {
    if(!window.modalResultScore){
      window.modalResultScore = [];
    }
    window.modalResultScore.push(this);
  },
};
</script>

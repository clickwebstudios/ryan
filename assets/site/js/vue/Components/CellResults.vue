<style lang="scss" scoped>
.cell_results_component{
  margin: -16px;
  display: flex;
  width: 100%;
  flex-wrap: wrap;
  padding: 40px 80px;
  justify-content: center;
  .cell{
    width: calc(50% - 64px);
    border: 0px solid var(--main-color-blue);
    height: auto;
    margin: 19px;
    border-radius: 0px;
    display: flex;
    flex-direction: column;
    box-shadow: 0px 1px 10px rgba(0, 0, 0, 0.1);
  }
  
  &.is_mobile{
    padding: 30px 0px;
    flex-direction: column;
    .cell{
      width: 100%;
      margin: 20px 0px;
      margin-bottom: 24px;
    }
  }
}
</style>
<template>
  <div ref="loader" class="cell_results_component" :class="{is_mobile: isMdScreen || isSmScreen}">
    <template v-if="entity">
      
      <CellResult :tscore="1" :score="scoreFirst" />
      <CellResult :tscore="2" :score="scoreSeccond" />
      <CellResult :tscore="3" :score="scoreThird" />
      <CellResult :tscore="4" :score="scoreFour" />
    </template>
  </div>
</template>

<script>
import CellResult from 'vuec/Components/CellResult.vue';
  
export default {
  components:{
    CellResult
  },
  props:{
    id:{
      type: Number,
      default: null
    }
  },
  data() {
    return {
      loader: null,
      entity: null,
    }
  },
  watch:{
    id(){
      this.getEntity();
    }
  },
  computed:{
    scoreFirst(){
      if(!this.entity){
        return;
      }
      let ans1 = this.entity.answers[4];
      let ans2 = this.entity.answers[9];
      let ans3 = this.entity.answers[14];
      let ans4 = this.entity.answers[18];
      
      let summ = this.getScore(ans1.a_answer_id) + 
        this.getScore(ans2.a_answer_id) + 
        this.getScore(ans3.a_answer_id) + 
        this.getScore(ans4.a_answer_id);
      
      return summ/4;
    },
    scoreSeccond(){
      if(!this.entity){
        return;
      }
      let ans1 = this.entity.answers[2];
      let ans2 = this.entity.answers[7];
      let ans3 = this.entity.answers[10];
      let ans4 = this.entity.answers[13];
      let ans5 = this.entity.answers[17];
      
      let summ = this.getScore(ans1.a_answer_id) + 
        this.getScore(ans2.a_answer_id) + 
        this.getScore(ans3.a_answer_id) + 
        this.getScore(ans4.a_answer_id) + 
        this.getScore(ans5.a_answer_id);
      
      return summ/5;
    },
    scoreThird(){
      if(!this.entity){
        return;
      }
      let ans1 = this.entity.answers[1];
      let ans2 = this.entity.answers[5];
      let ans3 = this.entity.answers[8];
      let ans4 = this.entity.answers[12];
      let ans5 = this.entity.answers[16];
      let ans6 = this.entity.answers[19];
      
      let summ = this.getScore(ans1.a_answer_id) + 
        this.getScore(ans2.a_answer_id) + 
        this.getScore(ans3.a_answer_id) + 
        this.getScore(ans4.a_answer_id) + 
        this.getScore(ans5.a_answer_id) + 
        this.getScore(ans6.a_answer_id);
      
      return summ/6;
    },
    scoreFour(){
      if(!this.entity){
        return;
      }
      let ans1 = this.entity.answers[3];
      let ans2 = this.entity.answers[6];
      let ans3 = this.entity.answers[11];
      let ans4 = this.entity.answers[15];
      let ans5 = this.entity.answers[20];
      
      let summ = this.getScore(ans1.a_answer_id) + 
        this.getScore(ans2.a_answer_id) + 
        this.getScore(ans3.a_answer_id) + 
        this.getScore(ans4.a_answer_id) +
        this.getScore(ans5.a_answer_id);
      
      return summ/5;
    },
    isLgScreen() {
      return this.mobilee.lg;
    },
    isMdScreen() {
      return this.mobilee.md && !this.mobilee.lg;
    },
    isSmScreen() {
      return this.mobilee.sm && !this.mobilee.lg && !this.mobilee.md;
    },
  },
  methods:{
    getScore(answerId){
      let aModel = this.$store.getters.getAnswerById(answerId);
      return parseInt(aModel.score);
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
    getEntity(){
      if(!this.id){
        return;
      }
      this.openLoader();
      
      let formData = new FormData;
      formData.append('action', 'get_user_form');
      formData.append('id', this.id);
            
      this.$http.post('/wp-admin/admin-ajax.php', formData)
        .then(response => {
          this.closeLoader();
          this.loading = false;
          let entity = response.data.item;
          entity.answers = JSON.parse(entity.answers);
          this.entity = entity;
        });
    },
  },
  mounted () {
    window.tempCellResults = this;
    this.getEntity();
  },
}
</script>
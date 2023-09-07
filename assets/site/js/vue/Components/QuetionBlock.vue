<style lang="scss" scoped>
.component_question_block{
  &.mobile_version{
    width:100%;
    .answers_body{
      flex-direction: column;
      padding-top: 30px;
      padding-bottom: 30px;
    }
    .answer_btn{
      margin: 16px 0px;
      min-width: 190px;
    }
    .question_body{
      &:before, &:after{
        display:none;
      }
      .left, .right{
        width: 100%;
        padding: 0px;
        text-align: center;
        justify-content: center;
        font-size: 16px;
        line-height: 20px;
      }
      .right{
        margin-bottom: 50px;
      }
    }
    .center_line{
      width: 100%;
      justify-content: center;
    }
    .component_question_block{
      width: 100%;
      justify-content: center;
    }
    .answer_body_outer{
      width: 100%;
      display:flex;
      justify-content: center;
      position: relative;
      .answers_body{
        padding-left:32px;
        padding-right:32px;
        background: #fff;
        position: relative;
        z-index: 2;
      }
      &:before{
        content: '';
        display:table;
        width: 100%;
        height: 1px;
        background: #D3D6D9;
        position: absolute;
        top:50%;
        z-index: 1;
      }
    }
  }
}
</style>
<style lang="scss">
.component_question_block{
  .left, .right{
    p{
      margin:0px;
    }
  }
}
.component_question_block .question_body:before {
  content: "";
  display: table;
  position: absolute;
  width: 1px;
  height: 160px;
  left: calc(50% - 0.5px);
  background: #D0D5DD;
}
.component_question_block .question_body:after {
  content: "Or";
  display: flex;
  position: absolute;
  left: calc(50% - 26px);
  top: calc(50% - 35px);
  color: #1D2939;
  font-size: 36px;
  line-height: 36px;
  height: 70px;
  background-color: #fff;
  align-items: center;
}
</style>
<template>
  <div ref="loader" class="component_question_block" :class="{mobile_version: isSmScreen}">
    <template v-if="isSmScreen">
      <div class="question_body">
        <div class='left' v-html="question.q_left">
        </div>
      </div>
    </template>
    <template v-else>
      <div class="question_body">
        <div class='left' v-html="question.q_left">
        </div>
        <div class='right' v-html="question.q_right">
        </div>
      </div>
    </template>
    <div class='answer_body_outer'>
      <div class="answers_body">
        <div 
          class="answer_btn" 
          @click="setAnswer(answer)" 
          v-for="answer in answers" 
          :class="{active: this.formInner.a_answer_id === answer.id}"
          >
          {{ answer.name }}
        </div>
      </div>
    </div>
    
    <template v-if="isSmScreen">
      <div class="question_body">
        <div class='right' v-html="question.q_right">
        </div>
      </div>
    </template>
    
    <div class="bottom_panel">
      <div class="left_bp" v-if=isSmScreen>
        <span class="btn_prev_default" @click="needPrev" v-if="!isFirstBlock">
          Previous
        </span>
      </div>
      <div class="right_bp">
        <span class="btn_next_primary" @click="needNext" v-if="form.a_answer_id">Continue the assessment</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components:{
    
  },
  props:{
    isFirstBlock:{
      type: Boolean,
      default: false,
    },
    isLastBlock:{
      type: Boolean,
      default: false,
    },
    form:{
      type: Object,
      default(){
        return {
          a_question_id: null,
          a_answer_id: null,
        };
      }
    },
    question:{
      type: Object,
      required: true,
    },
  },
  data() {
    return {
      loader: null,
      formInner:{
        a_question_id: null,
        a_answer_id: null,
      },
    }
  },
  watch:{
    isSmScreen(){
      
    },
    form(){
      this.formInner = this.form;
    },
    formInner(){
      this.$emit('update:form');
    },
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
    answers(){
      return this.$store.getters.answers;
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
      this.loader = this.$loading.show({
        container: this.$refs.loader,
      });
    },
    needNext(){
      this.openLoader();
      setTimeout(() => {
        this.closeLoader();
        this.$emit('needNext');
      }, 300);
    },
    needPrev(){
      this.openLoader();
      setTimeout(() => {
        this.closeLoader();
        this.$emit('needPrev');
      }, 300);
    },
    setAnswer(answer){
      this.formInner.a_answer_id = answer.id;
      this.needNext();
    }
  },
  mounted () {
    this.formInner = this.form;
    window.tempQuestionBlock = this;
  },
}
</script>
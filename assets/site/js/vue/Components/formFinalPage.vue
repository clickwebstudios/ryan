<style lang='scss' scoped>
.component_form_final_block{
  display:flex;
  width: 100%;
  min-height: 100vh;
  .left_fb{
    width: 40%;
    display: flex;
    min-height: 100%;
    background: var(--main-color-blue);
    color:#fff;
    padding: 36px 80px;
    .left_fb_inner{
      width: 100%;
      min-height: 100%;
      display:flex;
      flex-direction: column;
    }
    .logo_panel{
      flex: 1;
      width: 100%;
    }
    .logo_header{
      width: 143px;
    }
    .body_panel{
      flex: 100%;
      width: 100%;
      padding: 40px 0px;
      align-items: center;
      display: flex;
      .title{
        font-size: 36px;
        line-height: 48px;
        letter-spacing: -0.02em;
        margin-bottom: 24px;
        position: relative;
        padding-bottom: 20px;
        margin-bottom: 40px;
        font-family: 'Kepler Std';
        &:before{
          content: "";
          display: table;
          height: 3px;
          width: 52px;
          background-color: var(--main-color-green);
          top: 100%;
          left: 0px;
          position: absolute;
        }
      }
      .description{
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 16px;
      }
      .btn_panel{
        margin-top: 60px;
        margin-left: -8px;
        margin-right: -8px;
        .btn_tp{
          margin: 0px 8px;
        }
      }
    }
  }
  .right_fb{
    width: 60%;
    min-height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
  }
  &.is_mobile{
    flex-direction: column;
    .left_fb, .right_fb{
      width:100%;
      padding: 24px;
    }
    .left_fb{
      .body_panel{
        padding: 20px 0px;
        margin-top: 40px;
        .btn_panel{
          display: flex;
          flex-direction: column;
          .btn_tp{
            margin: 10px 8px;
            text-align: center;
            justify-content: center;
          }
        }
      }
    }
    .left_fb .body_panel{
      padding: 0px 0px 24px;
      margin-top: 0px;
      .title{
        font-weight: 600;
        font-size: 24px;
        line-height: 32px;
        margin: 24px 0px;
        padding: 0px;
        &:before{
          display: none;
        }
      }
      .btn_panel{
        margin-top: 48px;
      }
      .btn_tp{
        padding: 20px 0px;
      }
    }
    .cell_results_component{
      padding: 50px 0px 0px !important;
      justify-content: center;
    }
  }
  .bottom_btn_outer{
    padding: 0px 24px;
    margin-bottom: 40px 0px 50px 0px;
  }
  .btn_bottom{
    padding: 20px 0px;
    background: #FCB150;
    border: 0px solid #1D2939;
    box-shadow: 0px 1px 2px rgba(16, 24, 40, 0.05);
    border-radius: 0px;
    font-weight: 600;
    font-size: 14px;
    line-height: 14px;
    color: #253141;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
  }
  .bottom_text{
    font-weight: 400;
    font-size: 14px;
    line-height: 24px;
    color: #515A67;
    margin-bottom: 40px;
    .click_br{
      text-decoration: underline;
      color: #515A67;
    }
  }
}
.text_coach{
  font-size: 21px;
  line-height: 145%;
  font-family: 'Kepler Std', sans-serif;
}
.books_row{
  display:flex;
  justify-content: center;
  align-items: center;
  margin: 40px 0px 20px;
  img{
    max-width: 280px;
  }
}
.flex_center{
  display:flex;
  justify-content: center;
  align-items: center;
}
.btn_books_more{
  display: inline-flex;
  background: var(--main-color-orange);
  border: 0px solid #1D2939;
  box-shadow: unset;
  border-radius: 0px;
  margin-top: 0px;
  display: block;
  padding: 16px 33px !important;
  color: #253141;
  text-align: center;
  cursor: pointer;
  font-weight: 600;
  font-size: 14px;
  line-height: 14px;
  padding: 20px 0px;
  color: #253141;
  &:hover{
    opacity: 0.8;
  }
}
</style>
<template>
  <div class="component_form_final_block" :class="{is_mobile: isMdScreen || isSmScreen}">
    <div class="left_fb">
      <div class="left_fb_inner">
        <div class="logo_panel">
          <img class="logo_header" :src="publicPath+'/svg/header-logo-white2.svg'"/>
        </div>
        <div class="body_panel">
          <div class="body_inner">
            <div class="title">
              Personal Mindset <br>
              Assessment Results:
            </div>
            <div class="description">
              Congratulations on completing the most comprehensive 
              and research-backed mindset assessment ever developed!
              Your results were produced by comparing your responses 
              to over 40,000 others that have taken the assessment.
            </div>
            <div class="description">
              You can download your full report below. This report is designed to help you awaken to the quality of your current mindsets.
            </div>
            <div class="btn_panel">
              <span class="btn_white btn_tp" @click="goToResultPage" v-if="!issetCoach">
                Download My Report
              </span>
              <span class="btn_transparen btn_tp" @click="goToMindesetPage">
                Improve My Mindsets
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="right_fb">
      <div v-if="issetCoach" class="text_coach">
        <p>Thank you {{ formMainInner.first_name }} {{ formMainInner.last_name }},</p>
        Your results will be emailed to you by your coach {{ coachName }}.
        <br>
        If these concepts intrigue you check out Ryans latest books.
        <div class="books_row">
          <div class="book_block">
            <img :src="publicPath+'/img/book1.png'">
          </div>
          <div class="book_block">
            <img :src="publicPath+'/img/book2.png'">
          </div>
        </div>
        <div class="flex_center">
          <a target="_blank" href="/resources/#books" class="btn_books_more">
            See Ryan's Books
          </a>
        </div>
      </div>
      <template v-else>
        <CellResults
          :id="id"
        />

        <div class="bottom_text" v-if="!isMdScreen && !isSmScreen && !issetCoach">
          * Learn more about your mindsets and their meanings in your
          <a href="#" class="click_br" @click.stop.prevent="goToResultPage">personalized report.</a>
        </div>
      </template>
    </div>
    <div class="bottom_btn_outer" v-if="!issetCoach">
      <span class="btn_white btn_bottom" v-if="isMdScreen || isSmScreen" @click="goToResultPage">
        Download My Report
      </span>
    </div>
  </div>
</template>

<script>
import CellResults from 'vuec/Components/CellResults.vue';
  
export default {
  components:{
    CellResults
  },
  props:{
    token:{
      type: String,
      default: null
    },
    id:{
      type: Number,
      default: null
    },
    form:{
      type: Object,
      default(){
        return {};
      }
    },
    formMain:{
      type: Object,
      default(){
        return {
          step: 1,
          first_name: null,
          last_name: null,
          email: null,
          organization: null,
          coach: null,
        };
      }
    },
  },
  data() {
    return {
      formInner:{},
      formMainInner:{
        step: 1,
        first_name: null,
        last_name: null,
        email: null,
        organization: null,
        coach: null,
      },
    }
  },
  computed:{
    coachName(){
      let coach = this.$store.getters.getCoachBySlug(this.issetCoach);
      return coach? coach.name : null;
    },
    issetCoach(){
      return this.formMainInner.coach;
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
    publicPath(){
      return this.$stylesConfig.publicAssetPath.replaceAll('"', '');
    },
  },
  watch:{
    form(){
      this.formInner = this.form;
    },
    formInner(){
      this.$emit('update:form');
    },
    formMain(){
      this.formMainInner = this.formMain;
    },
    formMainInner(){
      this.$emit('update:formMain');
    },
  },
  methods:{
    goToMindesetPage(){
      let route = location.protocol+'//'+location.host+location.pathname+'/resources/';
      window.open(route, '_blank').focus();
    },
    goToResultPage(){
      let route = location.protocol+'//'+location.host+location.pathname+'?resultPrint='+this.token;
      if(this.isSmScreen){
        location.href = route;
      }else{
        window.open(route, '_blank').focus();
      }
    }
  },
  mounted () {
    this.formInner = this.form;
    this.formMainInner = this.formMain;
    
    window.tempFormFinalPage = this;
  },
}
</script>
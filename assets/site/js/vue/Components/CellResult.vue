<style lang='scss' scoped>
.cell{
  width: calc(50% - 64px);
  border: 1px solid var(--main-color-blue);
  height: auto;
  margin: 32px;
  border-radius: 12px;
  display: flex;
  flex-direction: column;
  max-width: 310px;
  .cell_top{
    /*
    border-bottom: 1px solid #E7E8EA;
    */
    height: 100%;
    padding: 24px;
  }
  .cell_bottom{
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    background: #253141;
    .cb_left{
      font-weight: 600;
      font-size: 14px;
      line-height: 20px;
      color: #FFFFFF;
    }
    .cb_right{
      font-weight: 400;
      font-size: 14px;
      line-height: 20px;
      color: var(--main-color-blue);
    }
  }
  .cell_top{
    .block_rating{
      /*
      width: 64px;
      height: 64px;
      display:flex;
      align-items: center;
      justify-content: center;
      background: var(--main-color-green);
      border-radius: 1px;
      font-size: 28px;
      color:#fff;
      */
      position: relative;
      display: inline-flex;
      height: 68px;
      overflow: hidden;
      .number{
        position: absolute;
        left: calc(50% - 15px);
        right: auto;
        font-weight: 600;
        font-size: 25px;
        top: 50%;
      }
    }
    .block_name{
      font-family: 'Kepler Std', san-serif;
      color: var(--main-color-blue);
      font-weight: 400;
      font-size: 22px;
      line-height: 24px;
    }
  }

  &.is_mobile{
    .block_name{
      max-width: 100%;
    }
  }
  .colored_block_outer{
    position: relative;
    .colored_block{
      display: flex;
      min-height: 54px;
      margin: 28px 0px 10px;
      .cb_a{
        display:flex;
        color: var(--main-color-blue2);
        flex:10;
        aspect-ratio: 62/54;
        align-items: center;
        justify-content: center;
        text-align: center;
        flex-direction: column;
        .score_val{
          font-weight: 600;
          font-size: 24px;
          line-height: 24px;
          letter-spacing: -0.02em;
        }
        .score_val_leg{
          font-weight: 500;
          font-size: 8px;
          line-height: 8px;
        }
      }
      .cb_1{
        background: #FCB150;
      }
      .cb_2{
        background: #FDD096;
      }
      .cb_3{
        background: #99DEE1;
      }
      .cb_4{
        background: #00ADB5;
        color:#fff;
      }
    }
    .bottom_legend{
      margin-top:-7px;
      display:flex;
      justify-content: space-between;
      .bl_left, .bl_right{
        font-weight: 400;
        font-size: 14px;
        line-height: 24px;
        color: #515A67;
      }
    }
  }
}
</style>
<template>
  <div class="cell" :class="{is_mobile: isMovileVersion}">
    <div class="cell_top">
            
      <!--
      <div class="block_rating">
        <svg :key="scoreInner" v-if="scoreInner" width="115" height="127" viewBox="0 0 115 127" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M6 66.5C6 58.555 7.33209 50.6878 9.92021 43.3476C12.5083 36.0074 16.3018 29.338 21.084 23.72C25.8662 18.1021 31.5435 13.6457 37.7918 10.6053C44.0401 7.56488 50.7369 6 57.5 6C64.2631 6 70.9599 7.56488 77.2082 10.6053C83.4565 13.6457 89.1338 18.1021 93.916 23.72C98.6982 29.338 102.492 36.0075 105.08 43.3477C107.668 50.6879 109 58.555 109 66.5"
            :stroke="'url(#gradient_'+scoreInnerKey+')'" stroke-width="12" stroke-linejoin="round" stroke-dasharray="12 2" />
          <defs>
            <linearGradient :id="'gradient_'+scoreInnerKey" gradientUnits="userSpaceOnUse" x1="1.5" y1="65" x2="107.5" y2="75">
              <stop offset="0%" stop-color="#FCB150" />
              <template v-if="this.scoreInner < 6.5">
                <stop :offset="scorePercent" stop-color="#EAECF0" />
              </template>
              <template v-else>
                <stop offset="100%" stop-color="#FCB150" />
              </template>
              <template v-if="this.scoreInner < 6.5">
                <stop offset="100%" stop-color="#00ADB5" />
              </template>
            </linearGradient>
          </defs>
        </svg>
        <span class="number">
          {{ scoreFormated }}
        </span>
      </div>
      -->
      
      <div class="block_name">
        {{ mainTitle }} Mindset
      </div>
      
      <div class="colored_block_outer">
        <div class="colored_block">
          <span class="cb_1 cb_a">
            <template v-if="scoreCellOne">
              <div class="score_val">
                {{ scoreFormated }}
              </div>
              <div class="score_val_leg">
                Raw Score
              </div>
            </template>
          </span>
          <span class="cb_2 cb_a">
            <template v-if="scoreCellTwo">
              <div class="score_val">
                {{ scoreFormated }}
              </div>
              <div class="score_val_leg">
                Raw Score
              </div>
            </template>
          </span>
          <span class="cb_3 cb_a">
            <template v-if="scoreCellThree">
              <div class="score_val">
                {{ scoreFormated }}
              </div>
              <div class="score_val_leg">
                Raw Score
              </div>
            </template>
          </span>
          <span class="cb_4 cb_a">
            <template v-if="scoreCellFour">
              <div class="score_val">
                {{ scoreFormated }}
              </div>
              <div class="score_val_leg">
                Raw Score
              </div>
            </template>
          </span>
        </div>
        <div class="bottom_legend">
          <span class="bl_left">
            <template v-if="tscore == 1">
              Fixed
            </template>
            <template v-if="tscore == 2">
              Closed
            </template>
            <template v-if="tscore == 3">
              Prevention
            </template>
            <template v-if="tscore == 4">
              Inward
            </template>
          </span>
          <span class="bl_right">
            <template v-if="tscore == 1">
              Growth
            </template>
            <template v-if="tscore == 2">
              Open
            </template>
            <template v-if="tscore == 3">
              Promotion
            </template>
            <template v-if="tscore == 4">
              Outward
            </template>
          </span>
        </div>
      </div>
      
    </div>
    <div class="cell_bottom">
      <div class="cb_left">
        {{ advancedTitle }}
      </div>
      <!--
      <div class="cb_right">
        Raw Score: {{ scoreFormated }}
      </div>
      -->
    </div>
  </div>
</template>

<script>
export default {
  components:{
    
  },
  props:{
    tscore:{
      type: Number,
      default: 1
    },
    score:{
      type: Number,
      default: 4
    },
  },
  data() {
    return {
      scoreInner: 0,
    }
  },
  watch:{
    score(){
      this.scoreInner = this.score;
    }
  },
  computed:{
    scoreCellOne(){
      return (this.advancedTitle.toLowerCase() === 'bottom quartile');
    },
    scoreCellTwo(){
      return (this.advancedTitle.toLowerCase() === 'second quartile');
    },
    scoreCellThree(){
      return (this.advancedTitle.toLowerCase() === 'third quartile');
    },
    scoreCellFour(){
      return (this.advancedTitle.toLowerCase() === 'top quartile');
    },
    scoreInnerKey(){
      return this.scoreInner+'_'+this.$.uid;
    },
    scorePercent(){
      let score = this.scoreInner? this.score : 0;
      let maxScore = 7;
      let k = maxScore/100;
      return Math.ceil(score/k)+'%';
    },
    mainTitle(){
      let score = this.scoreInner;
      if(this.tscore === 1){
        if(score <= 3.75){
          return 'Strong Fixed'
        }
        if(score <= 4.75){
          return 'Low Fixed'
        }
        if(score <= 5.75){
          return 'Low Growth'
        }
        if(score <= 7){
          return 'Strong Growth'
        }
      }
      if(this.tscore === 2){
        if(score <= 3.8){
          return 'Strong Closed'
        }
        if(score <= 4.8){
          return 'Low Closed'
        }
        if(score <= 5.6){
          return 'Low Open'
        }
        if(score <= 7){
          return 'Strong Open'
        }
      }
      if(this.tscore === 3){
        if(score <= 3.3){
          return 'Strong Prevention'
        }
        if(score <= 4.16){
          return 'Low Prevention'
        }
        if(score <= 4.9){
          return 'Low Promotion'
        }
        if(score <= 7){
          return 'Strong Promotion'
        }
      }
      if(this.tscore === 4){
        if(score <= 4.1){
          return 'Strong Inward'
        }
        if(score <= 4.90){
          return 'Low Inward'
        }
        if(score <= 5.6){
          return 'Low Outward'
        }
        if(score <= 7){
          return 'Strong Outward'
        }
      }
    },
    advancedTitle(){
      let score = this.scoreInner;
      if(this.tscore === 1){
        if(score <= 3.75){
          return 'Bottom Quartile'
        }
        if(score <= 4.75){
          return 'Second Quartile'
        }
        if(score <= 5.75){
          return 'Third Quartile'
        }
        if(score <= 7){
          return 'Top Quartile'
        }
      }
      if(this.tscore === 2){
        if(score <= 3.8){
          return 'Bottom Quartile'
        }
        if(score <= 4.8){
          return 'Second Quartile'
        }
        if(score <= 5.6){
          return 'Third Quartile'
        }
        if(score <= 7){
          return 'Top Quartile'
        }
      }
      if(this.tscore === 3){
        if(score <= 3.3){
          return 'Bottom Quartile'
        }
        if(score <= 4.16){
          return 'Second Quartile'
        }
        if(score <= 4.9){
          return 'Third Quartile'
        }
        if(score <= 7){
          return 'Top Quartile'
        }
      }
      if(this.tscore === 4){
        if(score <= 4.1){
          return 'Bottom Quartile'
        }
        if(score <= 4.90){
          return 'Second Quartile'
        }
        if(score <= 5.6){
          return 'Third Quartile'
        }
        if(score <= 7){
          return 'Top Quartile'
        }
      }
    },
    
    scoreFormated(){
      return this.$numberFormat(this.scoreInner, 1, '.', '');
    },
    isMovileVersion(){
      return this.isMdScreen || this.isSmScreen;
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
  watch:{
    
  },
  methods:{
    
  },
  mounted () {
    this.scoreInner = this.score;
    
    if(!window.tempCellResult){
      window.tempCellResult = [];
    }
    window.tempCellResult.push(this);
  },
}
</script>
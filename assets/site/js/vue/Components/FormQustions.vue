<style lang='scss' scoped>
.form_question{
  min-height: calc(100vh - 32px);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  .top_line, .footer_line{
    flex: 1;
    width: 100%;
  }
  .center_line{
    flex:100;
    display: flex;
    align-items: center;
    width: 100%;
    justify-content: center;
  }
  .footer_line{
    display: flex;
    padding: 30px 0px;
    justify-content: center;
    .img_footer{
      width:165px;
    }
  }
}
</style>
<template>
  <div ref="loader">
    <div v-if="finalPage">
      <formFinalPage
        :formMain="formMain"
        :form="form"
        :id="insertId"
        :token="insertToken"
      />
    </div>
    <div v-else class="f_container_fluid">
      <div class="form_question">
        <div class="top_line">
          <LineProgress
            :step="formMain.step"
            :count="count"
            :allowPrevBtn="(formMain.step != 1)"
            @needPrev="prevStep"
          />
        </div>
        <div class="center_line">
          <template v-for="(question, index) in questions">
            <template v-if="index+1 === formMain.step">
              <QuetionBlock
                :isFirstBlock="(index == 0)"
                :isLastBlock="(index+1 === questions.length)"
                @needNext="nextStep"
                @needPrev="prevStep"
                :form.sync="form[question.id]"
                :question="question"
              />
            </template>
          </template>
        </div>
        <div class="footer_line">
          <img class="img_footer" :src="publicPath+'/svg/logo_colored.svg'"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LineProgress from 'vuec/Components/LineProgress.vue';
import QuetionBlock from 'vuec/Components/QuetionBlock.vue';
import formFinalPage from 'vuec/Components/formFinalPage.vue';
  
export default {
  components:{
    LineProgress,
    QuetionBlock,
    formFinalPage
  },
  data() {
    return {
      loader: null,
      insertId: null,
      insertToken: null,
      finalPage: false,
      form: {},
      formMain: {
        step: 1,
        first_name: null,
        last_name: null,
        email: null,
        organization: null,
        coach: null,
      },
      allowStoreForm: false,
    }
  },
  watch:{
    form: {
      handler(){
        if(this.allowStoreForm){
          localStorage.formSite = JSON.stringify(this.form);
        }
      },
      deep: true
    },
    formMain: {
      handler(){
        if(this.allowStoreForm){
          localStorage.formMain = JSON.stringify(this.formMain);
        }
      },
      deep: true
    },
  },
  computed: {
    issetCoach(){
      return this.formMain.coach;
    },
    needSubscribe(){
      return (localStorage.needSubscribe === 'true' || localStorage.needSubscribe === 1 || localStorage.needSubscribe === true)? true : false;
    },
    publicPath(){
      return this.$stylesConfig.publicAssetPath.replaceAll('"', '');
    },
    count(){
      return this.questions.length;
    },
    answers(){
      return this.$store.getters.answers;
    },
    questions(){
      return this.$store.getters.questions;
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
    async submitForm(){
      this.openLoader();
      let form_data = new FormData;
      form_data.append('action', 'store_form');
      form_data.append('data_form', JSON.stringify(this.form));
      form_data.append('data_form_main', JSON.stringify(this.formMain));
      
      await this.$http.post('/wp-admin/admin-ajax.php', form_data)
        .then(response => {
          this.closeLoader();
          this.insertId = response.data.id;
          this.insertToken = response.data.token;
        });
    },
    prevStep(){
      if(this.formMain.step <= 1){
        return;
      }
      this.formMain.step--;
    },
    async nextStep(){
      if(this.formMain.step >= this.questions.length){
        await this.submitForm();
        this.finalPage = true;
        return;
      }
      this.formMain.step++;
    },
    fillDataMainFromSessionStorage(){
      if(!localStorage.formMain){
        this.openLoader();
        location.href = '/form-start/';
        return;
      }
      this.formMain = JSON.parse(localStorage.formMain);
    },
    fillDataFromSessionStorage(){
      if(!localStorage.formSite){
        return;
      }
      let savedData = JSON.parse(localStorage.formSite);
      let cloneForm = _.cloneDeep(this.form);
      
      for(let id in savedData){
        if(cloneForm[id]){
          cloneForm[id].a_answer_id = savedData[id].a_answer_id;
        }
      }
      this.form = cloneForm;
    },
    setDataForm(){
      let newForm = {};
      this.questions.forEach(el => {
        newForm[el.id] = {
          a_question_id: el.id,
          a_answer_id: null,
        };
      });
      this.form = newForm;
    },
    async sendrequestTosubscribe(){
      
      let form_data = new FormData;
      form_data.append('action', 'subscribe_user');
      form_data.append('data_form', JSON.stringify(this.formMain));
      
      await this.$http.post('/wp-admin/admin-ajax.php', form_data)
        .then(response => {
          
        });
    }
  },
  async mounted () {
    window.tempFormQUestions = this;
    this.setDataForm();
    this.fillDataMainFromSessionStorage();
    this.fillDataFromSessionStorage();
    this.$nextTick(async () => {
      this.allowStoreForm = true;
      
      if(this.needSubscribe){
        localStorage.needSubscribe = false;
        await this.sendrequestTosubscribe();
      }
    });
  },
}
</script>
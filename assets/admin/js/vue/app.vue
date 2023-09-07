<style lang="scss" scoped>
  
</style>
<template>
  <div class="main_layout">
    <template v-if="isUserQuestionPage">
      <GridUserQuestions />
    </template>
    <template v-if="isUserFormsPage">
      <GridUserAnswerForm />
    </template>
    <template v-if="isUserOrganizationPage">
      <GridUserOrganizationPage />
    </template>
    <template v-if="isUserCoachesPage">
      <GridUserCoatchesPage />
    </template>
  </div>
</template>

<script>
import GridUserAnswerForm from 'vueadmin/Components/GridUserAnswerForm.vue';
import GridUserQuestions from 'vueadmin/Components/GridUserQuestions.vue';
import GridUserOrganizationPage from 'vueadmin/Components/GridUserOrganizationPage.vue';
import GridUserCoatchesPage from 'vueadmin/Components/GridUserCoatchesPage.vue';
  
export default {
  components:{
    GridUserAnswerForm,
    GridUserQuestions,
    GridUserOrganizationPage,
    GridUserCoatchesPage
  },
  data() {
    return {
      
    };
  },
  computed:{
    routePage(){
      return this.$route.query.page;
    },
    isUserOrganizationPage(){
      return (this.routePage === 'user-organizations')? true : false;
    },
    isUserFormsPage(){
      return (this.routePage === 'user-forms')? true : false;
    },
    isUserQuestionPage(){
      return (this.routePage === 'user-questions')? true : false;
    },
    isUserCoachesPage(){
      return (this.routePage === 'user-coaches')? true : false;
    },
  },
  watch:{
    
  },
  mounted(){
    window.tempAdminPageApp = this;
  }
}
</script>
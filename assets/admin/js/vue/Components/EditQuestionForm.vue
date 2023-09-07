<style lang="scss" scoped>
.edit_form_component, .slot_outer{
  display: inline-flex;
}
</style>
<template>
  <div class="edit_form_component">
    <div class="slot_outer" @click="openModalEdit">
      <slot />
    </div>
    
    <a-modal
      width="700px"
      v-model:visible="showModal"
      okText="Update"
      title="Edit question"
      @ok="editForm"
      >
      <a-spin :spinning="loading">
        <a-form
          :model="form"
          ref="mainForm"
          :label-col="{ span: 24 }"
          :wrapper-col="{ span: 24 }"
          >
          <a-form-item
            label="Text left"
            name="q_left"
            :rules="[{ required: true, message: 'Please input text left!' }]"
            >
            <QuillEditor style="height:200px;" contentType="html" theme="snow" v-model:content="form.q_left" />
            <!--
            <a-textarea
              :rows="5"
              v-model:value="form.q_left"
            />
            -->
          </a-form-item>
          <a-form-item
            label="Text right"
            name="q_right"
            :rules="[{ required: true, message: 'Please input text right!' }]"
            >
            <QuillEditor style="height:200px;" contentType="html" theme="snow" v-model:content="form.q_right" />
            <!--
            <a-textarea
              :rows="5"
              v-model:value="form.q_right"
            />
            -->
          </a-form-item>
        </a-form>
      </a-spin>
    </a-modal>
    
  </div>
</template>

<script>
export default {
  components: {
    
  },
  props:{
    id:{
      type: Number,
      default: null
    }
  },
  data() {
    return {
      loading: false,
      showModal: false,
      form:{
        q_left: null,
        q_right: null,
      },
    };
  },
  methods: {
    updateRequest(){
      this.loading = true;
      let formData = new FormData;
      formData.append('action', 'admin_update_question');
      formData.append('id', this.id);
      formData.append('entity', JSON.stringify(this.form));
            
      this.$http.post('/wp-admin/admin-ajax.php', formData)
        .then(() => {
          this.loading = false;
          this.$notification["success"]({
            message: "Success",
            description: "Updated Successfully"
          });
          this.showModal = false;
        });
    },
    getEntity(){
      this.loading = true;
      let formData = new FormData;
      formData.append('action', 'admin_get_question');
      formData.append('id', this.id);
            
      this.$http.post('/wp-admin/admin-ajax.php', formData)
        .then(response => {
          this.loading = false;
          this.form = response.data.item;
        });
    },
    async validateForm() {
      let val = false;
      await this.$refs.mainForm.validate().then(() => {
        val = true;
      }, () => {});
      return val;
    },
    async editForm(){
      if(!await this.validateForm()){
        return;
      }
      
      this.updateRequest();
    },
    openModalEdit(){
      this.showModal = true;
      this.getEntity();
    }
  },
  mounted() {
    if(!window.editQuestionForm){
      window.editQuestionForm = [];
    }
    window.editQuestionForm.push(this);
  },
};
</script>

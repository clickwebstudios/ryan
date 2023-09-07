<style lang="scss" scoped>
.edit_form_organization_component, .slot_outer{
  display: inline-flex;
}
</style>
<template>
  <div class="edit_form_organization_component">
    <template v-if="isDelete">
      <a-popconfirm
        placement="left"
        title="Are you sure delete this organization?"
        ok-text="Yes"
        cancel-text="No"
        @confirm="deleteForm"
        >
        <div class="slot_outer">
          <a-spin :spinning="loading" :indicator="indicator">
            <slot />
          </a-spin>
        </div>
      </a-popconfirm>
    </template>
    <template v-else>
      <div class="slot_outer" @click="openModalEdit">
        <slot />
      </div>

      <a-modal
        width="700px"
        v-model:visible="showModal"
        :okText="id? 'Update' : 'Create'"
        :title="id? 'Edit organization' : 'Create organization'"
        @ok="editForm"
        >
        <a-spin :spinning="loading">
          <a-form
            v-if='showModal'
            :model="form"
            ref="mainForm"
            :label-col="{ span: 24 }"
            :wrapper-col="{ span: 24 }"
            >
            <a-form-item
              label="Name"
              name="name"
              :rules="[{ required: true, message: 'Please input name' }]"
              >
              <a-input
                v-model:value="form.name"
              />
            </a-form-item>
            <a-form-item
              label="Email"
              name="email"
              :rules="[{ type: 'email' }, { required: false, message: 'Please input email' }]"
              >
              <a-input
                v-model:value="form.email"
              />
            </a-form-item>
          </a-form>
        </a-spin>
      </a-modal>
    </template>
    
  </div>
</template>

<script>
import { LoadingOutlined } from '@ant-design/icons-vue';
import { h } from 'vue';
  
export default {
  components: {
    LoadingOutlined
  },
  props:{
    isDelete:{
      type: Boolean,
      default: false
    },
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
        name: null,
        email: null,
      },
    };
  },
  computed:{
    indicator(){
      return h(LoadingOutlined, {
        style: {
          fontSize: '14px',
        },
        spin: true,
      });
    }
  },
  methods: {
    deleteForm(){
      this.loading = true;
      let formData = new FormData;
      formData.append('action', 'admin_user_organizations_destroy');
      formData.append('id', this.id);
            
      this.$http.post('/wp-admin/admin-ajax.php', formData)
        .then(() => {
          this.loading = false;
          this.$notification["success"]({
            message: "Success",
            description: "Organization deleted successfully"
          });
          this.$emit('updated');
        });
    },
    storeRequest(){
      this.loading = true;
      let formData = new FormData;
      formData.append('action', 'admin_user_organizations_store');
      formData.append('entity', JSON.stringify(this.form));
            
      this.$http.post('/wp-admin/admin-ajax.php', formData)
        .then(() => {
          this.loading = false;
          this.$notification["success"]({
            message: "Success",
            description: "Organization Created Successfully"
          });
          this.showModal = false;
          this.$emit('updated');
        });
    },
    updateRequest(){
      this.loading = true;
      let formData = new FormData;
      formData.append('action', 'admin_user_organizations_update');
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
          this.$emit('updated');
        });
    },
    getEntity(){
      if(!this.id){
        this.form = {
          name: null,
          email: null,
        };
        return;
      }
      this.loading = true;
      let formData = new FormData;
      formData.append('action', 'admin_user_organizations_show');
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
      
      if(this.id){
        this.updateRequest();
      }else{
        this.storeRequest();
      }
    },
    openModalEdit(){
      this.showModal = true;
      this.getEntity();
    }
  },
  mounted() {
    if(!window.editPrganizationForm){
      window.editPrganizationForm = [];
    }
    window.editPrganizationForm.push(this);
  },
};
</script>

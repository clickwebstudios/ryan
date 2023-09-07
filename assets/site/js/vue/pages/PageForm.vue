<template>
  <FormQustions />
</template>

<script>
import FormQustions from 'vuec/Components/FormQustions.vue';
  
export default {
  components:{
    FormQustions
  },
  data() {
    return {
      
    }
  },
  computed: {
    
  },
  methods:{
    
  },
  mounted () {
    window.tempPageForm = this;
  },
  created(){
    this.$nextTick(() => {
      document.querySelector('body').classList.add('body_fix_form');
    });
  },
  destroyed () {
    document.querySelector('body').classList.remove('body_fix_form');
  },
}
</script>
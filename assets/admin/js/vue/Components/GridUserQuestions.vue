<style lang="scss" scoped>
.action_row{
  display:flex;
  padding-right:10px;
  .icon_edit{
    cursor: pointer;
    color:#1890ff;
    margin-right:5px;
  }
  .icon_delete{
    cursor: pointer;
    color:#f5222d;
  }
}
.row_item_search{
  display:block;
  cursor:pointer;
}
.icon_more{
  display:inline-flex;
  margin-right:5px;
}
.icon_eye{
  display:flex;
  align-items: center;
  .icon_eye_ui{
    margin-right: 5px;
    display:flex;
  }
}
.icon_outer{
  display: flex;
  align-items: center;
  .action_icon{
    margin:0px 5px;
  }
  .edit_icon{
    color: blue;
  }
}
</style>
<style lang="scss" >
.OUTER_USER_ANSWERS_TABEL{
  padding-top: 30px;
  padding-right: 20px;
  .ant-table-row{
    cursor:pointer;
  }
}
</style>
<template>
  <div class="OUTER_USER_ANSWERS_TABEL">
    <h2>User Questions</h2>
    
    <a-table
      ref="tableGrid"
      :columns="columns"
      :data-source="itemsSource"
      :pagination="pagination"
      :loading="loading"
      @change="handleTableChange"
      >
      
      <template #bodyCell="{ column, record }">
        <template v-if="column.key === 'q_left'">
          {{ record.q_left }}
        </template>
        <template v-if="column.key === 'q_right'">
          {{ record.q_right }}
        </template>
        <template v-if="column.key === 'action'">
          <div class="icon_outer">
            <EditQuestionForm
              :id="record.id"
              >
              <EditOutlined class="action_icon edit_icon"/>
            </EditQuestionForm>
          </div>
        </template>
      </template>
      
    </a-table>

  </div>
</template>

<script>
import { EditOutlined, DeleteOutlined } from '@ant-design/icons-vue';
import EditQuestionForm from 'vueadmin/Components/EditQuestionForm.vue';
  
export default {
  components: { 
    EditOutlined,
    DeleteOutlined,
    EditQuestionForm
  },
  data() {
    return {
      filterTab: '',
      lastPagination:{},
      lastFilters:{},
      lastSorter:{},
      searchTerm: null,
      columns: [
        {
          title: "Left text",
          dataIndex: "q_left",
          sorter: true,
          align: 'left',
          key: 'q_left',
        },
        {
          title: "Right text",
          dataIndex: "q_right",
          sorter: true,
          align: 'left',
          key: 'q_right',
        },
        {
          title: "",
          width:55,
          dataIndex: "",
          align: 'center',
          key: 'action',
        }
      ],
      pagination: {
        pageSize: 20,
      },
      loading: false,
      itemsSource: [],
    };
  },
  watch:{

  },
  computed:{
   
  },
  methods: {
    handleTableChangeCurrentPage(){
      this.handleTableChange(this.lastPagination, this.lastFilters, this.lastSorter);
    },
    handleTableChange(pagination, filters, sorter) {
      this.lastPagination = pagination;
      this.lastFilters = filters;
      this.lastSorter = sorter;

      pagination = pagination? pagination: {current: 1, pageSize : 10};
      sorter = sorter? sorter: {};
      filters = filters? filters: {};

      const pager = { ...this.pagination };
      pager.current = pagination.current? pagination.current : 1;
      this.pagination = pager;

      this.loadApiData({
        results: pagination.pageSize,
        page: pagination.current? pagination.current : 1,
        sortField: sorter.field,
        sortOrder: sorter.order,
        searchWord: this.searchTerm,
        filters: filters? filters : {}
      });
    },
    filterVal(value){
      if(!value){
        return 'asc';
      }
      if(value === 'asc' || value === 'ascend'){
        return 'asc';
      }
      if(value === 'desc' || value === 'descend'){
        return 'desc';
      }
      return 'asc';
    },
    loadApiData(params = {}) {
      let page = params.page? params.page : 1;
      let searchWord = params.searchWord? params.searchWord : null;
      let queryParams = {};

      queryParams = { ...queryParams, pageSize: this.pagination.pageSize, page };
      queryParams = { ...queryParams, orderField: params.sortField, orderDir: this.filterVal(params.sortOrder) };
      queryParams = { ...queryParams, filter: params.filters };
      queryParams = { ...queryParams, searchWord: searchWord };
      queryParams.filter_tab = this.filterTab;

      this.loading = true;

      let form_data = new FormData;
      form_data.append('action', 'admin_get_user_questions');
      form_data.append('data', JSON.stringify(queryParams));
            
      this.$http.post('/wp-admin/admin-ajax.php', form_data)
        .then(response => {
          this.itemsSource = response.data.items;
          this.pagination.total = parseInt(response.data.total);
          this.loading = false;
        });
    },
  },
  mounted() {
    window.userQuestionsGrid = this;
    this.loadApiData();
  },
};
</script>

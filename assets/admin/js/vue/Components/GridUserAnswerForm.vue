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
.eye_icon{
  color: blue;
}
.icons_action{
  display:flex;
  align-items: center;
  .pdf_icon{
    margin:0px 10px;
    color:#ff0000;
  }
}
.organ_name_title{
  color:#999;
  font-size:12px;
  margin-left: 5px;
  position: relative;
  top:2px;
}
.main_title{
  display: flex;
  align-items: center;
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
    <h2 class='main_title'>
      User Forms
      <div class='organ_name_title' v-if='organizationName'>
        (Organization: {{ organizationName }})
      </div>
      <div class='organ_name_title' v-if='coachName'>
        (Coach: {{ coachName }})
      </div>
      
    </h2>
    
    <a-table
      ref="tableGrid"
      :columns="columns"
      :data-source="itemsSource"
      :pagination="pagination"
      :loading="loading"
      @change="handleTableChange"
      >
      
      <template #bodyCell="{ column, record }">
        <template v-if="column.key === 'organization'">
          {{ record.organization_name }}
        </template>
        <template v-if="column.key === 'coach'">
          {{ record.coach_name }}
        </template>
        <template v-if="column.key === 'first_name'">
          {{ record.first_name }}
        </template>
        <template v-if="column.key === 'last_name'">
          {{ record.last_name }}
        </template>
        <template v-if="column.key === 'email'">
          {{ record.email }}
        </template>
        <template v-if="column.key === 'date_created'">
          {{ $filters.filterDate(record.date_created) }}
        </template>
        <template v-if="column.key === 'action'">
          <div class="icons_action">
            <ModalResultScore
              :item="record"
              >
              <EyeOutlined 
                class="eye_icon"
              />
            </ModalResultScore>
            <FilePdfOutlined 
              class="pdf_icon" 
              @click="openPdf(record.token)"
            />
            <!--
            <FilePdfOutlined 
              class="pdf_icon" 
              @click="openPdf(record.id)"
            />
            -->
          </div>
        </template>
      </template>
      
    </a-table>

  </div>
</template>

<script>
import { EyeOutlined, FilePdfOutlined, DeleteOutlined } from '@ant-design/icons-vue';
import ModalResultScore from 'vueadmin/Components/ModalResultScore.vue';
  
export default {
  components: { 
    EyeOutlined,
    FilePdfOutlined,
    ModalResultScore,
    DeleteOutlined
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
          width: 200,
          title: "Date",
          dataIndex: "date_created",
          sorter: true,
          align: 'left',
          key: 'date_created',
        },
        {
          width: 100,
          title: "Organization",
          dataIndex: "organization",
          sorter: false,
          align: 'left',
          key: 'organization',
        },
        {
          width: 100,
          title: "Coach",
          dataIndex: "coach",
          sorter: false,
          align: 'left',
          key: 'coach',
        },
        {
          width: 200,
          title: "First Name",
          dataIndex: "first_name",
          sorter: true,
          align: 'left',
          key: 'first_name',
        },
        {
          width: 220,
          title: "Last Name",
          dataIndex: "last_name",
          sorter: true,
          align: 'left',
          key: 'last_name',
        },
        {
          title: "Email",
          dataIndex: "email",
          sorter: true,
          align: 'left',
          key: 'email',
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
    organizationQuery(){
      this.handleTableChangeCurrentPage();
    },
    coachQuery(){
      this.handleTableChangeCurrentPage();
    },
  },
  computed:{
    coachName(){
      return this.$store.getters.getCoachNameById(this.coachQuery);
    },
    organizationName(){
      return this.$store.getters.getOrganizationNameById(this.organizationQuery);
    },
    organizationQuery(){
      return this.$route.query.organization;
    },
    coachQuery(){
      return this.$route.query.coach;
    }
  },
  methods: {
    openPdf(id){
      let route = location.protocol+'//'+location.host+'?resultPrint='+id;
      window.open(route, '_blank').focus();
    },
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
        return 'desc';
      }
      if(value === 'asc' || value === 'ascend'){
        return 'asc';
      }
      if(value === 'desc' || value === 'descend'){
        return 'desc';
      }
      return 'desc';
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
      queryParams.organization_id = this.organizationQuery;
      queryParams.coach_id = this.coachQuery;

      this.loading = true;

      let form_data = new FormData;
      form_data.append('action', 'admin_get_user_forms');
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
    window.userAnswerGrid = this;
    this.loadApiData();
  },
};
</script>

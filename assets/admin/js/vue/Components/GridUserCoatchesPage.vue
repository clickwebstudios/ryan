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
.title_line{
  margin-bottom: 10px;
  display: flex;
  justify-content: space-between;
}
.icon_eye{
  color:#40a9ff;
  margin-left:10px;
  cursor: pointer;
}
.link_text{
  color:#40a9ff;
  margin-left:5px;
  display: inline-flex;
  align-items: center;
  cursor: pointer;
  .icon_link{
    color:#40a9ff;
    margin-left: 5px;
    display: inline-flex;
  }
}
.delete_icon{
  color:#ff0000;
  margin:0px 5px;
  cursor: pointer;
}
.answers_form{
  display:flex;
  align-items: center;
  color:#999;
}
.icon_xl{
  color:green;
  cursor: pointer;
  margin: 0px 5px;
}
</style>
<style lang="scss" >
.OUTER_USER_COACHES{
  padding-top: 30px;
  padding-right: 20px;
  .ant-table-row{
    cursor:pointer;
  }
}
</style>
<template>
  <div class="OUTER_USER_COACHES">
    <div class="title_line">
      <h2>Coaches</h2>
      
      <EditCoachesForm
        @updated="handleTableChangeCurrentPage"
        >
        <a-button type="primary">
          <template #icon><PlusOutlined /></template>
          Add coach
        </a-button>
      </EditCoachesForm>
    </div>
    
    <a-table
      ref="tableGrid"
      :columns="columns"
      :data-source="itemsSource"
      :pagination="pagination"
      :loading="loading"
      @change="handleTableChange"
      >
      
      <template #bodyCell="{ column, record }">
        <template v-if="column.key === 'date_created'">
          {{ $filters.filterDate(record.date_created) }}
        </template>
        <template v-if="column.key === 'name'">
          {{ record.name }}
        </template>
        <template v-if="column.key === 'slug'">
          {{ fullUrl(record.slug) }}
          <span class='link_text' @click='copyLink(record)'>(copy link <LinkOutlined class='icon_link'/>)</span>
        </template>
        <!--
        <template v-if="column.key === 'email'">
          {{ record.email }}
        </template>
        -->
        <template v-if="column.key === 'count_answers'">
          <span @click.stop='goToCoachAnswers(record.id)' class='answers_form'>
            {{ record.count_answers }}
            <EyeOutlined class='icon_eye' />
          </span>
        </template>
        <template v-if="column.key === 'action'">
          <div class="icon_outer">
            <EditCoachesForm
              :id="parseInt(record.id)"
              @updated="handleTableChangeCurrentPage"
              >
              <EditOutlined class="action_icon edit_icon"/>
            </EditCoachesForm>
            
            <FileExcelOutlined @click="downloadXl(record.token)" class="icon_xl" />
            
            <EditCoachesForm
              :isDelete="true"
              :id="parseInt(record.id)"
              @updated="handleTableChangeCurrentPage"
              >
              <DeleteOutlined class="action_icon delete_icon"/>
            </EditCoachesForm>
          </div>
        </template>
      </template>
      
    </a-table>

  </div>
</template>

<script>
import { EditOutlined, DeleteOutlined, PlusOutlined, LinkOutlined, EyeOutlined, FileExcelOutlined } from '@ant-design/icons-vue';
import EditCoachesForm from 'vueadmin/Components/EditCoachesForm.vue';
  
export default {
  components: { 
    EditOutlined,
    DeleteOutlined,
    EditCoachesForm,
    PlusOutlined,
    LinkOutlined,
    EyeOutlined,
    FileExcelOutlined,
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
          title: "Date",
          dataIndex: "date_created",
          sorter: true,
          align: 'left',
          key: 'date_created',
        },
        {
          title: "Name",
          dataIndex: "name",
          sorter: true,
          align: 'left',
          key: 'name',
        },
        {
          title: "URL",
          dataIndex: "slug",
          sorter: true,
          align: 'left',
          key: 'slug',
        },
        {
          title: "Email",
          dataIndex: "email",
          sorter: true,
          align: 'left',
          key: 'email',
        },
        {
          title: "Users",
          dataIndex: "count_answers",
          sorter: true,
          align: 'center',
          width: 40,
          key: 'count_answers',
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
    fullUrl(slug){
      return `${location.protocol}//${location.hostname}/form-start?coach=${slug}`;
    },
    downloadXl(token){
      window.open(location.protocol+'//'+location.hostname+'/?resultExportCoachCSV='+token);
    },
    goToCoachAnswers(coachId){
      this.$router.push({path: location.pathname, query: {page: 'user-forms', coach: coachId}});
    },
    _fallbackCopyTextToClipboard(text) {
      var textArea = document.createElement("textarea");
      textArea.value = text;

      // Avoid scrolling to bottom
      textArea.style.top = "0";
      textArea.style.left = "0";
      textArea.style.position = "fixed";

      document.body.appendChild(textArea);
      textArea.focus();
      textArea.select();

      try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Fallback: Copying text command was ' + msg);
      } catch (err) {
        console.error('Fallback: Oops, unable to copy', err);
      }
      document.body.removeChild(textArea);
    },
    copyTextToClipboard(text) {
      if (!navigator.clipboard) {
        this._fallbackCopyTextToClipboard(text);
        return;
      }
      navigator.clipboard.writeText(text).then(function() {
        console.log('Async: Copying to clipboard was successful!');
      }, function(err) {
        console.error('Async: Could not copy text: ', err);
      });
    },
    copyLink(record){
      let link = location.protocol+'//'+location.host+'/form-start/?coach='+record.slug;
      this.copyTextToClipboard(link);
      
      this.$notification["success"]({
        message: "Link copied to clipboard",
        description: link
      });
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
      form_data.append('action', 'admin_user_coach_index');
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
    window.userCoachGrid = this;
    this.loadApiData();
  },
};
</script>

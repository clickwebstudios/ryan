import * as types from './mutation-types';
import axios from "axios";

export const actions = {

  FETCH_STORE_SITE: async function (context, payload) {
    
      let form_data = new FormData;
      form_data.append('action', 'get_storage');
      
      await axios.post('/wp-admin/admin-ajax.php', form_data)
        .then(response => {
          context.commit(types.SET_ANSWERS, response.data.answers);
          context.commit(types.SET_QUESTIONS, response.data.questions);
          context.commit(types.SET_COACHES, response.data.coaches);
        });
  }

};

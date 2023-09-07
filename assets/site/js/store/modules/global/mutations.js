import * as types from './mutation-types';
export const mutations = {
  
  [types.SET_COACHES] (state, coaches) {
    state.coaches = coaches;
  },
  
  [types.SET_QUESTIONS] (state, questions) {
    state.questions = questions;
  },
  
  [types.SET_ANSWERS] (state, answers) {
    state.answers = answers;
  },
  
  [types.SET_APPINITED] (state, appInited) {
    //state.appInited = !appInited;
    setTimeout(() => {
      state.appInited = appInited;
    });
  },
  
  
};

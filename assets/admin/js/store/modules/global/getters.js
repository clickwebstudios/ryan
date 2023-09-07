const answers = state => state.answers;
const questions = state => state.questions;
const appInited = state => state.appInited;
const organizations = state => state.organizations;
const coaches = state => state.coaches;

export const getters = {
  appInited,
  answers,
  questions,
  organizations,
  coaches,
  getOrganizationNameById: state => id => {
    let item = state.organizations.find(s => parseInt(s.id) === parseInt(id));
    return item? item.name : null;
  },
  getAnswerById: state => id => {
    return state.answers.find(s => parseInt(s.id) === parseInt(id));
  },
  getCoachNameById: state => id => {
    let item = state.coaches.find(s => parseInt(s.id) === parseInt(id));
    return item? item.name : null;
  },
};

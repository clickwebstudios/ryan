const answers = state => state.answers;
const questions = state => state.questions;
const appInited = state => state.appInited;
const coaches = state => state.coaches;

export const getters = {
  appInited,
  answers,
  questions,
  coaches,
  getAnswerById: state => id => {
    return state.answers.find(s => parseInt(s.id) === parseInt(id));
  },
  getCoachBySlug: state => slug => {
    return state.coaches.find(s => s.slug === slug);
  },
};

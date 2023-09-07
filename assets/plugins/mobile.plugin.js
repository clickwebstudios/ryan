import { reactive } from 'vue'

const $mobilee = reactive({
  sm: true,
  md: true,
  lg: true,
  lgxl: true,
});

export default {
  isMobile: true,
  install(Vue, options) {

    Vue.mixin({
      data () {
        return {
          mobilee: $mobilee
        };
      }
    });
    
    window.dima = Vue;

    window.addEventListener('resize', () => {
      init();
    }, true);

    var init = function () {
      let width = document.documentElement.clientWidth || window.innerWidth || document.body.clientWidth;

      if (width < 768) {
        $mobilee.sm = true;
        $mobilee.md = false;
        $mobilee.lg = false;
      } else if (width < 1200) {
        $mobilee.sm = true;
        $mobilee.md = true;
        $mobilee.lg = false;
      } else {
        $mobilee.sm = true;
        $mobilee.md = true;
        $mobilee.lg = true;
      }
      
      if (width >= 1800) {
        $mobilee.lgxl = true;
      }else{
        $mobilee.lgxl = false;
      }
    };

    init();
  }
}
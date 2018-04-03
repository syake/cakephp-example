import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import moment from 'moment';
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/ja';
import 'element-ui/lib/theme-chalk/index.css'

Vue.use(ElementUI, {locale});
var $ = require("jquery");

import fontawesome from '@fortawesome/fontawesome';
import solid from '@fortawesome/fontawesome-free-solid';
import regular from '@fortawesome/fontawesome-free-regular';
import brands from '@fortawesome/fontawesome-free-brands';
fontawesome.library.add(solid.faEye);
fontawesome.library.add(regular.faSave);

fontawesome.library.add(regular.faMinusSquare);
fontawesome.library.add(solid.faCaretUp);
fontawesome.library.add(solid.faCaretDown);
fontawesome.library.add(solid.faPlusCircle);
fontawesome.library.add(solid.faTimesCircle);

fontawesome.library.add(solid.faInfoCircle);
fontawesome.library.add(regular.faNewspaper);
fontawesome.library.add(solid.faImages);
fontawesome.library.add(brands.faVimeo);
fontawesome.library.add(solid.faAlignLeft);
fontawesome.library.add(regular.faEnvelope);
fontawesome.library.add(solid.faIdCard);
fontawesome.library.add(regular.faImage);

/* ========================================================================
 * component
 * @see Vue.js
 * ======================================================================== */
/*
Vue.component('my-component', {
  template: '<div>A custom component!</div>'
})
*/

/* ========================================================================
 * controls
 * @see Vue.js
 * @see jQuery
 * ======================================================================== */
export function controls() {
  const $el = $('#controls');
  if (!$el[0]) return;
  const app = new Vue({
    el: '#controls',
    data: {
      form: $el.parents('form:first')[0]
    },
    methods: {
      preview: function() {
        if (event) event.preventDefault();

        let default_action = this.form.action;
        let default_target = this.form.target;

        // submit
        this.form.action = $('#previewPostlink').attr('href');
        this.form.target = 'preview';
        let w = window.innerWidth;
        let h = window.innerHeight;
        let win = window.open('', 'preview','width=' + w + ',height=' + h + ',scrollbars=yes');
        win.focus();
        this.form.submit();

        this.form.action = default_action;
        this.form.target = default_target;
      }
    }
  });
}

/* ========================================================================
 * editor
 * @see Vue.js
 * @see jQuery
 * ======================================================================== */
export default function editor() {
  moment().format();
  
  controls.call();
  
  const $el = $('#editor');
  if (!$el[0]) return;
  let post = null;
  if (window.data) post = window.data.post;
  const app = new Vue({
    el: '#editor',
    data: {
      post: post,
      sections: [],
      colStyles: {
        images: 'col-sm-3',
        items: 'col-sm-4',
        values: 'col-sm-12'
      },
      deafult_title: {
        images: 'イメージ',
        items: '概要',
        values: 'お知らせ'
      }
    },
    mounted: function() {
      if (this.post) {
        this.sections = this.post.sections || [];
      }
    },
    methods: {
      addSection: function(style) {
        if (event) event.preventDefault();
        this.sections.push({
          title: this.deafult_title[style] || '',
          description: '',
          style: style
        });
      },
      removeSection: function(index) {
        if (event) event.preventDefault();
        this.sections.splice(index, 1);
      },
      upSection: function(index) {
        if (event) event.preventDefault();
        this.sections.splice(index-1, 2, this.sections[index], this.sections[index-1]);
      },
      downSection: function(index) {
        if (event) event.preventDefault();
        this.sections.splice(index, 2, this.sections[index+1], this.sections[index]);
      },
      addCell: function(index) {
        if (event) event.preventDefault();
        if (!this.sections[index].cells) {
          this.sections[index].cells = [];
        }
        this.sections[index].cells.push({
          modified: new Date()
        });
        this.$forceUpdate();
      },
      removeCell: function(index, index2) {
        if (event) event.preventDefault();
        if (this.sections[index].cells) {
          this.sections[index].cells.splice(index2, 1);
        }
        this.$forceUpdate();
      },
      selectedFile: function(index, index2) {
        if (event) event.preventDefault();
        let file = event.target.files[0];
        let formData = new FormData();
        formData.append('data', file);
        formData.append('article_id', this.post.id);
        let config = {
          headers: {'content-type': 'multipart/form-data'}
        };
        axios.post('/images/upload', formData, config)
          .then(response => {
            if (index2 == -1) {
              this.addCell(index);
              index2 = this.sections[index].cells.length - 1;
            }
            this.sections[index].cells[index2].image_name = response.data;
            this.$forceUpdate();
          })
          .catch(error => {
            console.error(error);
          });
      },
      trigger: function(id) {
        if (event) event.preventDefault();
        document.getElementById(id).click();
      }
    },
    filters: {
      moment: function (date) {
        return moment(date).format('YYYY-MM-DD HH:mm:ss');
      }
    }
  });
}

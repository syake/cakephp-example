import Vue from 'vue';
import axios from 'axios';
import VueAxios from 'vue-axios';
import moment from 'moment';
import ElementUI from 'element-ui';
import locale from 'element-ui/lib/locale/lang/ja';
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI, {locale});

import $ from 'jquery';
import 'bootstrap';

import fontawesome from '@fortawesome/fontawesome';
import solid from '@fortawesome/fontawesome-free-solid';
import regular from '@fortawesome/fontawesome-free-regular';
import brands from '@fortawesome/fontawesome-free-brands';
fontawesome.library.add(solid.faCaretUp);
fontawesome.library.add(solid.faCaretDown);
fontawesome.library.add(solid.faPlusCircle);
fontawesome.library.add(solid.faTimesCircle);
fontawesome.library.add(solid.faWindowClose);
fontawesome.library.add(regular.faImage);

fontawesome.library.add(solid.faPlus);
fontawesome.library.add(regular.faNewspaper);
fontawesome.library.add(solid.faImages);
fontawesome.library.add(regular.faEnvelope);
fontawesome.library.add(solid.faIdCard);

/* ========================================================================
 * editor
 * @see Vue.js
 * @see jQuery
 * ======================================================================== */
export default function editor() {
  moment().format();
  
  const $el = $('#editor');
  if (!$el[0]) return;
  let post = null;
  if (window.data) post = window.data.post;
  const app = new Vue({
    el: '#editor',
    data: {
      post: post,
      project_id: -1,
      mainvisuals: [],
      sections: [],
      colStyles: {
        images: 'col-sm-3',
        items: 'col-sm-4',
        values: 'col-sm-12'
      },
      iconStyles: {
        images: 'fas fa-images',
        items: 'fas fa-id-card',
        values: 'fas fa-newspaper',
        contact: 'far fa-envelope'
      },
      deafult_title: {
        images: 'イメージ',
        items: '概要',
        values: 'お知らせ',
        contact: 'お問い合わせ'
      }
    },
    mounted: function() {
      if (this.post) {
        this.project_id = this.post.project.id;
        this.mainvisuals = this.post.mainvisuals || [];
        this.sections = this.post.sections || [];
      }
    },
    methods: {
      remove: function(items, index) {
        if (event) event.preventDefault();
        items.splice(index, 1);
        this.$forceUpdate();
      },
      up: function(items, index) {
        if (event) event.preventDefault();
        items.splice(index-1, 2, items[index], items[index-1]);
        this.$forceUpdate();
      },
      down: function(items, index) {
        if (event) event.preventDefault();
        items.splice(index, 2, items[index+1], items[index]);
        this.$forceUpdate();
      },
      addMainvisual: function() {
        if (event) event.preventDefault();
        this.mainvisuals.push({
        });
        let i = this.mainvisuals.length - 1;
        return this.mainvisuals[i];
      },
      addSection: function(style) {
        if (event) event.preventDefault();
        this.sections.push({
          title: this.deafult_title[style] || '',
          description: '',
          style: style
        });
      },
      addCell: function(index) {
        if (event) event.preventDefault();
        if (!this.sections[index].cells) {
          this.sections[index].cells = [];
        }
        this.sections[index].cells.push({
          modified: new Date()
        });
        let i = this.sections[index].cells.length - 1;
        return this.sections[index].cells[i];
      },
      selectedFile: function(item) {
        if (event) event.preventDefault();
        let file = event.target.files[0];
        let formData = new FormData();
        formData.append('data', file);
        formData.append('project_id', this.project_id);
        let config = {
          headers: {'content-type': 'multipart/form-data'}
        };
        axios.post('/images/upload', formData, config)
          .then(response => {
            item.image_name = response.data;
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

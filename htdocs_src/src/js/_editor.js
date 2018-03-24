import Vue from 'vue';
import axios from 'axios'
import VueAxios from 'vue-axios'
var $ = require("jquery");

import fontawesome from '@fortawesome/fontawesome';
import faMinusSquare from '@fortawesome/fontawesome-free-regular/faMinusSquare';
import faCaretUp from '@fortawesome/fontawesome-free-solid/faCaretUp';
import faCaretDown from '@fortawesome/fontawesome-free-solid/faCaretDown';
import fasMinusSquare from '@fortawesome/fontawesome-free-solid/faMinusSquare';

fontawesome.library.add(faMinusSquare, faCaretUp, faCaretDown, fasMinusSquare);

/* ========================================================================
 * editor
 * @see Vue.js
 * @see jQuery
 * ======================================================================== */
export default function editor() {
  const $el = $('#editor');
  if (!$el[0]) return;
  let post = null;
  if (window.data) post = window.data.post;
  const app = new Vue({
    el: '#editor',
    data: {
      post: post,
      sections: []
    },
    mounted: function() {
      if (this.post) {
        this.sections = this.post.sections || [];
      }
    },
    methods: {
      addSection: function(event) {
        if (event) event.preventDefault();
        this.sections.push({
          section_title: ''
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
      addClause: function(index) {
        if (event) event.preventDefault();
        if (!this.sections[index].items) {
          this.sections[index].items = [];
        }
        this.sections[index].items.push({
        });
        this.$forceUpdate();
      },
      removeClause: function(index, index2) {
        if (event) event.preventDefault();
        if (this.sections[index].items) {
          this.sections[index].items.splice(index2, 1);
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
            if (!index2) {
              this.addClause(index);
              index2 = this.sections[index].items.length - 1;
            }
            this.sections[index].items[index2].image_name = response.data;
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
    }
  });
}

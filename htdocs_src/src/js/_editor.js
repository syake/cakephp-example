import Vue from 'vue';
var $ = require("jquery");

import fontawesome from '@fortawesome/fontawesome';
import faMinusSquare from '@fortawesome/fontawesome-free-regular/faMinusSquare';
import faCaretUp from '@fortawesome/fontawesome-free-solid/faCaretUp';
import faCaretDown from '@fortawesome/fontawesome-free-solid/faCaretDown';

fontawesome.library.add(faMinusSquare, faCaretUp, faCaretDown);

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
        if (!this.sections[index].images) {
          this.sections[index].images = [];
        }
        this.sections[index].images.push({
          name: 'hoge'
        });
        this.$forceUpdate();
      },
      removeClause: function(index, index2) {
        if (event) event.preventDefault();
        if (this.sections[index].images) {
          this.sections[index].images.splice(index2, 1);
        }
        this.$forceUpdate();
      }
    }
  });
}

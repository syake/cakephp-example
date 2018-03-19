import Vue from 'vue';
var $ = require("jquery");

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
        this.sections = this.post.sections;
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
    }
  });
}

// export default function setupEditor() {
/*
  const el_name = '#editor';
  const $el = $(el_name);
  if (!$el[0]) return;
  var app = new Vue({
    el: $el,
    data: {
      sections: []
    },
    mounted() {
      if (window.data.post) {
        console.log(window.data.post);
      }
      this.sections = [
        {title: 'aaaa'}
      ];
    },
    methods: {
      add: function() {
        this.sections.push({
          title: '',
          items: []
        });
      },
      remove: function(index) {
        this.sections.splice(index, 1);
      },
      addItem: function(items) {
        items.push({
          title: '',
          description: ''
        });
      },
      removeItem: function(items, index) {
        items.splice(index, 1);
      }
    }
  });
*/
// }

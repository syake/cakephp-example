import Vue from 'vue';
import axios from 'axios'
import VueAxios from 'vue-axios'
var $ = require("jquery");

import fontawesome from '@fortawesome/fontawesome';
import solid from '@fortawesome/fontawesome-free-solid';
import regular from '@fortawesome/fontawesome-free-regular';
import brands from '@fortawesome/fontawesome-free-brands';
fontawesome.library.add(solid.faMinusSquare);
fontawesome.library.add(regular.faMinusSquare);
fontawesome.library.add(solid.faCaretUp);
fontawesome.library.add(solid.faCaretDown);
fontawesome.library.add(solid.faInfoCircle);
fontawesome.library.add(regular.faNewspaper);
fontawesome.library.add(solid.faImages);
fontawesome.library.add(brands.faVimeo);
fontawesome.library.add(solid.faAlignLeft);
fontawesome.library.add(regular.faEnvelope);
fontawesome.library.add(solid.faIdCard);
fontawesome.library.add(solid.faPlusCircle);
fontawesome.library.add(solid.faTimesCircle);
fontawesome.library.add(regular.faImage);

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
      sections: [],
      colStyles: {
        images: 'col-sm-4',
        items: 'col-sm-6',
        values: 'col-sm-12'
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
          title: '',
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
    }
  });
}

import Vue from 'vue';
import $ from 'jquery';

import fontawesome from '@fortawesome/fontawesome';
import solid from '@fortawesome/fontawesome-free-solid';
import regular from '@fortawesome/fontawesome-free-regular';
import brands from '@fortawesome/fontawesome-free-brands';
fontawesome.library.add(solid.faImage);
fontawesome.library.add(solid.faImages);
fontawesome.library.add(regular.faEnvelope);

/* ========================================================================
 * sidebar
 * @see Vue.js
 * @see jQuery
 * ======================================================================== */
export default function sidebar() {
  const $el = $('#sidebar');
  if (!$el[0]) return;
  const app = new Vue({
    el: '#sidebar',
    data: {
      draggingItem: null,
    },
    methods: {
      dragstart: function(type) {
        this.$emit('drag', type);
      },
      dragend: function() {
        this.$emit('drag', null);
      }
    }
  });
  return app;
}

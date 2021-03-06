import Vue from 'vue';
import $ from 'jquery';

import fontawesome from '@fortawesome/fontawesome';
import solid from '@fortawesome/fontawesome-free-solid';
import regular from '@fortawesome/fontawesome-free-regular';
import brands from '@fortawesome/fontawesome-free-brands';
fontawesome.library.add(solid.faEye);
fontawesome.library.add(regular.faSave);
fontawesome.library.add(solid.faCheckCircle);
fontawesome.library.add(solid.faMinusCircle);
fontawesome.library.add(regular.faTrashAlt);
fontawesome.library.add(solid.faPlus);

/* ========================================================================
 * controls
 * @see Vue.js
 * @see jQuery
 * ======================================================================== */
export default function controls() {
  const $el = $('#controls');
  if (!$el[0]) return;
  const app = new Vue({
    el: '#controls',
    data: {
      form: $el.parents('form:first')[0]
    },
    methods: {
      panel: function() {
        if (event) event.preventDefault();
        
        const $content = $('#content');
        const $sidebar = $('#sidebar');
        if ($content.hasClass('on')) {
          $content.removeClass('on');
          $sidebar.removeClass('on');
        } else {
          $content.addClass('on');
          $sidebar.addClass('on');
        }
      },
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

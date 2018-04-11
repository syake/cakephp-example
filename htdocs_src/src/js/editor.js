import 'bootstrap';
import $ from 'jquery';
if (!window.data) window.data = {};

/* ========================================================================
 * import
 * ======================================================================== */
import controls from './_controls';
import sidebar from './_sidebar';
import fieldset from './_fieldset';
$(function(){
  controls();
  sidebar();
  fieldset();
});


/* ========================================================================
 * draggable box
 * ======================================================================== */
/*
+(function($){
    $('.js-sortable').sortable({
        placeholder:'placeholder',
        delay: 150,
        forcePlaceholderSize: true,
        start:function(event, ui){
            ui.item.toggleClass('focus');
        },
        stop:function(event, ui){
            ui.item.toggleClass('focus');
        },
        update:function(event, ui){
            $(event.target).find('input[name*="item_order"]').each(function(index){
                $(this).val(index);
            });
        }
    });
    $('.js-sortable').disableSelection();
})(jQuery);
*/

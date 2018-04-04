/* ========================================================================
 * fontawesome
 * ======================================================================== */
import fontawesome from '@fortawesome/fontawesome';
import solid from '@fortawesome/fontawesome-free-solid';
fontawesome.library.add(solid.faPlus);
fontawesome.library.add(solid.faCheckCircle);
fontawesome.library.add(solid.faBan);

/* ========================================================================
 * init
 * ======================================================================== */
import $ from 'jquery';
if (!window.data) window.data = {};

/* ========================================================================
 * editor
 * ======================================================================== */
import editor from './_editor';
$(editor);

/* ========================================================================
 * confirm
 * ======================================================================== */
/*
+(function($){
    $('.js-confirm').on('click', function (e) {
        var value = $(this).data('confirm');
        if(!window.confirm(value)){
            return false;
        }
    });
})(jQuery);
*/

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

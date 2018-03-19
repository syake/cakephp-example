/* ========================================================================
 * fontawesome
 * ======================================================================== */
import fontawesome from '@fortawesome/fontawesome';
import faPlus from '@fortawesome/fontawesome-free-solid/faPlus';
import faCheckCircle from '@fortawesome/fontawesome-free-solid/faCheckCircle';
import faBan from '@fortawesome/fontawesome-free-solid/faBan';
// import faCircle from '@fortawesome/fontawesome-free-regular/faCircle'
// import faFacebook from '@fortawesome/fontawesome-free-brands/faFacebook'

fontawesome.library.add(faPlus, faCheckCircle, faBan);
/*
fontawesome.library.add(faCircle)
fontawesome.library.add(faFacebook)
*/

/* ========================================================================
 * init
 * ======================================================================== */
var $ = require('jquery');
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
 * upload
 * ======================================================================== */
/*
+(function($){
    var fileReader = new FileReader();
    
    $('.js-upload').each(function(){
        var $this = $(this);
        var $empty = $this.children();
        var $input = $this.find('input[type=file]');
        var $disable = $this.find('input[type=hidden].disable');
        var $image = $('<img>');
        var $holder = $('<div>');
        
        var imgload = function(img){
            $image.attr('src',img);
            $this.append($image);
            $empty.hide();
        }
        
        var change = function(e){
            $targetEmpty = $empty;
            var file = e.target.files[0];
            fileReader.onload = function(event) {
                var loadedImageUri = event.target.result;
                imgload(loadedImageUri);
            }
            fileReader.readAsDataURL(file);
            $disable.val(0);
        };
        
        $image.on('click',function(e){
            $input.trigger('click');
        });
        $input.on('change',change);
        $this.on('delete',function(e){
            $holder.append($image);
            $empty.show();
            $disable.val(0);
            $input.off('change');
            var $clone = $input.clone();
            $clone.val('');
            $input.replaceWith($clone);
            $input = $clone;
            $input.on('change',change);
        });
        $this.on('dragover',function(e){
            e.stopPropagation();
            e.preventDefault();
        });
        $this.on('drop',function(e){
            e.stopPropagation();
            e.preventDefault();
            var files = e.originalEvent.dataTransfer.files;
            if (files) {
                $input.prop('files',files);
            }
        });
        
        // init
        var default_image = $this.data('default');
        if ((default_image != null) && (default_image != '')) {
            imgload(default_image);
            $disable.val(1);
        }
    });
    
    $('a.js-upload-delete').on('click',function(e){
        var $target = $($(this).data('target'));
        $target.trigger('delete');
        return false;
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

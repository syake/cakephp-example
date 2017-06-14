/* ========================================================================
 * confirm
 * ======================================================================== */
+(function($){
    $('.js-confirm').on('click', function (e) {
        var value = $(this).data('confirm');
        if(!window.confirm(value)){
            return false;
        }
    });
})(jQuery);

/* ========================================================================
 * upload
 * ======================================================================== */
+(function($){
    var fileReader = new FileReader();
    
    $('.js-upload').each(function(){
        var $this = $(this);
        var $empty = $this.children();
        var $input = $this.find('input[type=file]');
        var $temp = $this.find('input[type=hidden].temp');
        var $image = $('<img>');
        var $holder = $('<div>');
        
        var imgload = function(img){
            $image.attr('src',img);
            $this.append($image);
            $empty.hide();
            $temp.val(1);
        }
        
        var change = function(e){
            $targetEmpty = $empty;
            var file = e.target.files[0];
            fileReader.onload = function(event) {
                var loadedImageUri = event.target.result;
                imgload(loadedImageUri);
            }
            fileReader.readAsDataURL(file);
        };
        
        $image.on('click',function(e){
            $input.trigger('click');
        });
        $input.on('change',change);
        $this.on('delete',function(e){
            $holder.append($image);
            $empty.show();
            $temp.val(0);
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
        }
    });
    
    $('a.js-upload-delete').on('click',function(e){
        var $target = $($(this).data('target'));
        $target.trigger('delete');
        return false;
    });
    
})(jQuery);

/* ========================================================================
 * add box
 * ======================================================================== */
+(function($){
    
})(jQuery);

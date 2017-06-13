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
        var $input_delete = $this.find('input[type=hidden].delete');
        var $image = $('<img>');
        var $holder = $('<div>');
        
        $image.on('click',function(e){
            $input.trigger('click');
        });
        
        var imgload = function(img){
            $image.attr('src',img);
            $this.append($image);
            $empty.hide();
            $input_delete.val(0);
        }
        
        $input.on('change',function(e){
            $targetEmpty = $empty;
            var file = e.target.files[0];
            fileReader.onload = function(event) {
                var loadedImageUri = event.target.result;
                imgload(loadedImageUri);
            }
            fileReader.readAsDataURL(file);
        });
        
        $this.on('delete',function(e){
            $holder.append($image);
            $empty.show();
            $input_delete.val(1);
        });
        
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







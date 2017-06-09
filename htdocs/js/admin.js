/* ========================================================================
 * anchor link
 * ======================================================================== */
+(function($){
    $('a[href^="#"]').on('click', function (e) {
        var href = $(this).attr("href");
        var $target = $(href == "#" || href == "" ? 'html' : href);
        var position = $target.offset().top;
        $("html, body").animate({scrollTop:position}, 'slow');
        return false;
    });
})(jQuery);

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

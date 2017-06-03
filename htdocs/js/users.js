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
        if(!window.confirm('Are you sure, you want to delete this user?')){
            return false;
        }
    });
})(jQuery);

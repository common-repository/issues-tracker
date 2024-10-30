(($) => {

    const links = $('.nav-link');
    
    jQuery.each(links, (index, link) => {
        const href = $(link).attr('href');

        if (href === location.href) {
            $(link).parent().addClass('active');
        }
    })


})(jQuery)
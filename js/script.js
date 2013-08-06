$(document).ready(function() {

	$('.carousel').carousel('cycle');

    $('li.menu-item a').click(function(e) {
        if ($(window).width() < 767) {
            var $menu = $(this).parent().find('ul.sub-menu');
            if ($menu.length > 0) {
                e.preventDefault();
                $menu.slideToggle('fast');
            }
        }
    });

    /* generate anchor links on pages */
    /*var anchors = '<ul class="anchors">';
    $('.page a[name]').each(function(){
        if ($(this).attr('name') != 'teachers') {
            anchors += '<li><a href="#' + $(this).attr('name') + '">' + $(this).attr('name') + '</a></li>';
        } else {
            anchors += '<li><a href="/events/kids-marathon/teachers-page">' + $(this).attr('name') + '</a></li>';
        }
    });
    anchors += '</ul></div>';
    if ($('a[name]').length !== 0){
        $('.page .entry-content').before(anchors);
    }*/

});

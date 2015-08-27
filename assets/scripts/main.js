/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */
const animationSpeed = 300;

(function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        // Navigation javascript
        $navRoot = $('nav');
        $hamburger = $navRoot.find('#mobile-nav-toggle');

        var navRootRect = null;
        var currentPageScroll = null;
        $hamburger.click(function() {
            $this = $(this);
            if (!$navRoot.hasClass('open')) {
                navRootRect = $navRoot[0].getBoundingClientRect();
                currentPageScroll = $('.current-menu-item').position().top;

                $('body').addClass('noscroll');

                $navRoot.removeClass('closed').addClass('open').scrollTop(currentPageScroll).css({
                    'top': navRootRect.top + 'px',
                    'bottom': (window.innerHeight - navRootRect.bottom) + 'px'
                }).find('.menu-item').show();
                window.setTimeout(function() {
                    $navRoot.addClass('animating').css({
                        'top': "",
                        'bottom': ""
                    }).animate({
                        'scrollTop': 0
                    }, animationSpeed);
                }, 0);
                window.setTimeout(function() {
                    $navRoot.removeClass('animating').addClass('open');
                }, animationSpeed);
            } else {
                $('body').removeClass('noscroll');

                $navRoot.addClass('animating').css({
                    'top': navRootRect.top + 'px',
                    'bottom': (window.innerHeight - navRootRect.bottom) + 'px'
                }).animate({
                    'scrollTop': currentPageScroll
                }, animationSpeed);
                window.setTimeout(function() {
                    $navRoot.css({
                        'top': "",
                        'bottom': ""
                    }).removeClass('animating open').addClass('closed').find('.menu-item').not('.current-page-ancestor, .current_page_item').hide();
                }, animationSpeed);
            }
        });
        $navRoot.find('.menu-item-has-children').click(function(e) {
            if (window.innerWidth <= 767) {
                if (!$navRoot.hasClass('open')) {
                    $hamburger.click();
                    e.preventDefault();
                }
                $this = $(this);
                $subMenu = $this.find('.sub-menu');
                if (!$subMenu.is(":visible")) {
                    $subMenu.animate({
                        height: 'toggle'
                    }, animationSpeed);
                    e.preventDefault();
                }
            }
        });
        // -- end Navigation javascript

        // Parallax javascript
        var $parallaxEl = $('.header-parallax');
        var $mountains = $parallaxEl.find('.mountains');
        var $mountainsImg = $parallaxEl.find('img.mountains');
        var $mountainsBg = $parallaxEl.find('.mountains.bg');
        var $foothills = $parallaxEl.find('.foothills');
        var $foothillsImg = $parallaxEl.find('img.foothills');
        var $foothillsBg = $parallaxEl.find('.foothills.bg');
        var $trees = $parallaxEl.find('.trees');
        var $treesImg = $parallaxEl.find('img.trees');
        var $treesBg = $parallaxEl.find('.trees.bg');

        window.addEventListener('scroll', function(e) {
            var sx = window.scrollY;
            if (sx < 150) {
                /*
                var percent = sx / 150;
                var mountainAdg = (50 * percent);
                $mountainsImg.css('bottom', mountainAdg + 'px');
                $mountainsBg.css('height', (40 + mountainAdg) + 'px');
                var foothillAdg = (30 * percent);
                $foothillsImg.css('bottom', foothillAdg + 'px');
                $foothillsBg.css('height', (20 + foothillAdg) + 'px');
                var treeAdg = (10 * percent);
                $treesImg.css('bottom', treeAdg + 'px');
                $treesBg.css('height', (3 + treeAdg) + 'px');
                */

                var percent = sx / 150;
                $mountains.css('bottom', '-' + (40 * percent) + 'px');
                $foothills.css('bottom', '-' + (20 * percent) + 'px');
                $trees.css('bottom', '-' + (3 * percent) + 'px');
            }
        });
        // -- end Parallax javascript
      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page
      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.


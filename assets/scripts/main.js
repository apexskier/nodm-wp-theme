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
        window.addEventListener('keyup', function(e) {
            if ((e.keyCode || e.which) === 27 && window.innerWidth <= 767 && $navRoot.hasClass('open')) {
                $hamburger.click();
            }
        });
        // -- end Navigation javascript

        // Parallax javascript
        var $parallaxEl = $('.header-parallax');
        var $mountains = $parallaxEl.find('.mountains');
        // var $mountainsImg = $parallaxEl.find('img.mountains');
        // var $mountainsBg = $parallaxEl.find('.mountains.bg');
        var $foothills = $parallaxEl.find('.foothills');
        // var $foothillsImg = $parallaxEl.find('img.foothills');
        // var $foothillsBg = $parallaxEl.find('.foothills.bg');
        var $trees = $parallaxEl.find('.trees');
        // var $treesImg = $parallaxEl.find('img.trees');
        // var $treesBg = $parallaxEl.find('.trees.bg');
        // var $logo = $('.brand img');

        // var $rightEls = $parallaxEl.find('.right');
        // var $rightFoothills = $parallaxEl.find('.right.foothills');
        // var $rightTrees = $parallaxEl.find('.right.trees');
        // var $leftEls = $parallaxEl.find('.left');
        // var $leftFoothills = $parallaxEl.find('.left.foothills');
        // var $leftTrees = $parallaxEl.find('.left.trees');
        var hh = $parallaxEl.innerHeight();

        function parallaxResize () {
            hh = $parallaxEl.innerHeight();
        }

        function parallaxScroll (e, sy) {
            if (sy < hh) {
                var percent = sy / 150;
                $mountains.css('bottom', '-' + (40 * percent) + 'px');
                $foothills.css('bottom', '-' + (20 * percent) + 'px');
                // $logo.css('margin-top', ((20 * percent) + 20) + 'px');
                $trees.css('bottom', '-' + (3 * percent) + 'px');
            }
        }
        // -- end Parallax javascript

        // Back to top affix
        var $topLink = $('.top-link'),
            $content = $('.content'),
            topLinkOffsetTop;

        function topAffixScroll (e, sy) {
            var offset = sy - topLinkOffsetTop;
            if (offset > -15) {
                $topLink
                    .addClass('affix-free')
                    .removeClass('affix-top affix-bottom');
            } else {
                $topLink
                    .addClass('affix-top')
                    .removeClass('affix-free affix-bottom');
            }
        }

        function topAffixResize () {
            $topLink.css('right', $content.offset().left + 'px');
        }

        // init
        if ($topLink.length > 0) {
            topLinkOffsetTop = $topLink.offset().top;
            topAffixScroll(null, window.scrollY);
            topAffixResize(null);

            window.addEventListener('scroll', function(e) {
                var sy = window.scrollY;
                topAffixScroll(e, sy);
            });
            window.addEventListener('resize', function(e) {
                topAffixResize(e);
            });
        }

        window.addEventListener('scroll', function(e) {
            var sy = window.scrollY;
            parallaxScroll(e, sy);
        });
        window.addEventListener('resize', function(e) {
            parallaxResize(e);
        });
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



/*! promise-polyfill 2.1.0 */
// https://github.com/taylorhakes/promise-polyfill
!function(a){function b(a,b){return function(){a.apply(b,arguments)}}function c(a){if("object"!=typeof this)throw new TypeError("Promises must be constructed via new");if("function"!=typeof a)throw new TypeError("not a function");this._state=null,this._value=null,this._deferreds=[],i(a,b(e,this),b(f,this))}function d(a){var b=this;return null===this._state?void this._deferreds.push(a):void j(function(){var c=b._state?a.onFulfilled:a.onRejected;if(null===c)return void(b._state?a.resolve:a.reject)(b._value);var d;try{d=c(b._value)}catch(e){return void a.reject(e)}a.resolve(d)})}function e(a){try{if(a===this)throw new TypeError("A promise cannot be resolved with itself.");if(a&&("object"==typeof a||"function"==typeof a)){var c=a.then;if("function"==typeof c)return void i(b(c,a),b(e,this),b(f,this))}this._state=!0,this._value=a,g.call(this)}catch(d){f.call(this,d)}}function f(a){this._state=!1,this._value=a,g.call(this)}function g(){for(var a=0,b=this._deferreds.length;b>a;a++)d.call(this,this._deferreds[a]);this._deferreds=null}function h(a,b,c,d){this.onFulfilled="function"==typeof a?a:null,this.onRejected="function"==typeof b?b:null,this.resolve=c,this.reject=d}function i(a,b,c){var d=!1;try{a(function(a){d||(d=!0,b(a))},function(a){d||(d=!0,c(a))})}catch(e){if(d)return;d=!0,c(e)}}var j="function"==typeof setImmediate&&setImmediate||function(a){setTimeout(a,1)},k=Array.isArray||function(a){return"[object Array]"===Object.prototype.toString.call(a)};c.prototype["catch"]=function(a){return this.then(null,a)},c.prototype.then=function(a,b){var e=this;return new c(function(c,f){d.call(e,new h(a,b,c,f))})},c.all=function(){var a=Array.prototype.slice.call(1===arguments.length&&k(arguments[0])?arguments[0]:arguments);return new c(function(b,c){function d(f,g){try{if(g&&("object"==typeof g||"function"==typeof g)){var h=g.then;if("function"==typeof h)return void h.call(g,function(a){d(f,a)},c)}a[f]=g,0===--e&&b(a)}catch(i){c(i)}}if(0===a.length)return b([]);for(var e=a.length,f=0;f<a.length;f++)d(f,a[f])})},c.resolve=function(a){return a&&"object"==typeof a&&a.constructor===c?a:new c(function(b){b(a)})},c.reject=function(a){return new c(function(b,c){c(a)})},c.race=function(a){return new c(function(b,c){for(var d=0,e=a.length;e>d;d++)a[d].then(b,c)})},c._setImmediateFn=function(a){j=a},"undefined"!=typeof module&&module.exports?module.exports=c:a.Promise||(a.Promise=c)}(this);

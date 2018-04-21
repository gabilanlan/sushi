/*
Plugin: jQuery Parallax
Version 1.1.3
Author: Ian Lunn
Twitter: @IanLunn
Author URL: http://www.ianlunn.co.uk/
Plugin URL: http://www.ianlunn.co.uk/plugins/jquery-parallax/

Dual licensed under the MIT and GPL licenses:
http://www.opensource.org/licenses/mit-license.php
http://www.gnu.org/licenses/gpl.html
*/
(function(b){var a=b(window);var c=a.height();a.resize(function(){c=a.height()});b.fn.parallax=function(f,j,i){var k=b(this);var h;var e;var g=0;k.each(function(){e=k.offset().top});if(i){h=function(l){return l.outerHeight(true)}}else{h=function(l){return l.height()}}if(arguments.length<1||f===null){f="50%"}if(arguments.length<2||j===null){j=0.1}if(arguments.length<3||i===null){i=true}function d(){var l=a.scrollTop();k.each(function(){var n=b(this);var o=n.offset().top;var m=h(n);if(o+m<l||o>l+c){return}k.css("backgroundPosition",f+" "+Math.round((e-l)*j)+"px")})}a.bind("scroll",d).resize(d);d()}})(jQuery);
jQuery(window).load(function(){
    "use strict";
    var is_touch = function(){
		return !!('ontouchstart' in window) || ( !! ('onmsgesturechange' in window) && !! window.navigator.maxTouchPoints);
	}
    /* Method for parallax */
    if ( jQuery('.noo_parallax').length && !is_touch()) {
        jQuery('.noo_parallax').each(function(){
            jQuery(this).parallax("30%", 0.1);
        });
    }
});

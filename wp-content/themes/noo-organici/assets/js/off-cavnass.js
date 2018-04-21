!function($){

    $(document).ready(function( $ ){
        "use strict";
        var $btn = $('.btn-navbar'),
            $nav = null,
            $fixeditems = null;

        if ( nooCV.eff === 'top' ) {

            $nav    = $('<div class="noo-main-canvas-top" />').appendTo($('<div id="off-canvas-top-nav"></div>').appendTo('.navbar'));
            $($btn.data('target')).clone().appendTo($nav);

            $( '#off-canvas-top-nav' ).resize(function() {
    
                var height = $('#off-canvas-top-nav').height();
                if ( height <= 280 ) {
                    $('.noo-header.menu-eff-top #off-canvas-top-nav').css({
                        'overflow-y': 'visible'
                    });
                }
            });

            $btn.click (function(e){

                if ($(this).data('off-canvas') == 'show') {
                    $btn.data('off-canvas', 'hide');
                    $('#off-canvas-top-nav').removeClass( 'show-menu' ).slideUp(200);

                    jQuery('#noo-site-wraper').removeClass('mobile-site');

                } else {

                    jQuery('#noo-site-wraper').addClass('mobile-site');
                    $btn.data('off-canvas', 'show');
                    $('#off-canvas-top-nav').addClass( 'show-menu' ).slideDown(200);

                }

                return false;

            });


            /**
             * Add icon show child-menu
             */
                $('.noo-main-canvas-top .menu-item-has-children').each(function(index, el) {
                    
                    $(this).find('>a').append('<i class="fa fa-angle-down" aria-hidden="true" data-id="' + $(this).prop('id') + '" data-child=""></i>');
                    
                });
                

            /**
             * Process event when click button arrow
             */
                $('.noo-main-canvas-top .navbar-nav > .menu-item-has-children > a').on('click', 'i', function(event) {
                    event.stopPropagation();
                    event.preventDefault();
                    /**
                     * VAR
                     */
                        var $$_child    = $(this),
                            id          = $$_child.data('id'),
                            child       = $$_child.data('child');
                    $('.noo-main-canvas-top .menu-item-has-children > a  i').removeClass('fa-angle-up').addClass('fa-angle-down').data('child', 'hide');
                    $('.noo-main-canvas-top .navbar-nav > .menu-item-has-children .sub-menu').slideUp(200);
                    /**
                     * Process
                     */
                        if ( child === 'show' ) {

                            $$_child.removeClass('fa-angle-up').addClass('fa-angle-down');
                            $$_child.data('child', 'hide');
                            $('li#' + id + ' > ul' ).slideUp(200);

                        } else {

                            $$_child.addClass('fa-angle-up').removeClass('fa-angle-down');
                            $$_child.data('child', 'show');
                            $('li#' + id + ' > ul' ).slideDown(200);

                        }

                });

            /**
             * Process event when click button children arrow
             */
                $('.noo-main-canvas-top .menu-item-has-children .sub-menu  a').on('click', 'i', function(event) {
                    event.stopPropagation();
                    event.preventDefault();
                    /**
                     * VAR
                     */
                        var $$_child    = $(this),
                            id          = $$_child.data('id'),
                            child       = $$_child.data('child');
                    /**
                     * Process
                     */
                        if ( child === 'show' ) {

                            $$_child.removeClass('fa-angle-up').addClass('fa-angle-down');
                            $$_child.data('child', 'hide');
                            $('li#' + id + ' > ul' ).slideUp(200);

                        } else {

                            $$_child.addClass('fa-angle-up').removeClass('fa-angle-down');
                            $$_child.data('child', 'show');
                            $('li#' + id + ' > ul' ).slideDown(200);

                        }
                });

            /**
             * Hide menu when click outside
             */
                //$(document).on("click", function(event){
                //    var $trigger = $("#off-canvas-top-nav");
                //    if($trigger !== event.target && !$trigger.has(event.target).length){
                //        $btn.data('off-canvas', 'hide');
                //        $('#off-canvas-top-nav').removeClass( 'show-menu' ).slideUp(200);
                //    }
                //});

            return;
        } else{
            $nav = $('<div id="off-canvas-nav"></div>').appendTo('body');
            $nav = $('<div class="noo-main-canvas"></div>').appendTo($nav);
            $($btn.data('target')).clone().appendTo($nav);
            $('.nav-user-collapse').clone().appendTo($nav);
            $('<a class="exit-cavas" href="#">&nbsp;</a>').appendTo($nav);

            var slideout = new Slideout({
                'panel': document.getElementById('noo-site-wraper'),
                'menu': document.getElementById('off-canvas-nav'),
                'padding': 256,
                'tolerance': 70,
                'side': 'right',
                'touch' : false
            });

            // Toggle button
            if( $('.btn-navbar').length ) {
                document.querySelector('.btn-navbar').addEventListener('click', function() {
                    slideout.toggle();
                    if(slideout.isOpen()){
                        $('.btn-navbar').addClass('eff');
                    } else{
                        $('.btn-navbar').removeClass('eff');
                    }
                });
            }

            $('.exit-cavas').click(function () {
                slideout.toggle();
                if(slideout.isOpen()){
                    $('.btn-navbar').addClass('eff');
                } else{
                    $('.btn-navbar').removeClass('eff');
                }
            });

            $('html').click(function(e) {
                var target = $(e.target);
                if( !target.closest('#off-canvas-nav').length && !target.is('#off-canvas-nav') && !target.closest('.btn-navbar').length && !target.is('.btn-navbar') ){
                    slideout.close();
                }
            });
        }

        if (!$btn.length){
            return;
        }
    })

}(jQuery);

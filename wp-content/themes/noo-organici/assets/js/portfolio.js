function noo_masonry(){

    "use strict";

    var $container = jQuery('.noo-product-grid'),
        $layout = $container.data('layout');
    $container.imagesLoaded(function(){
        $container.isotope({
            itemSelector : '.masonry-item',
            transitionDuration : '0.8s',
            layoutMode : $layout ? $layout : 'fitRows'
        });

    });
}
function noo_masonry2(){
    "use strict";

    var $container2 = jQuery('.noo-product-masonry');
    $container2.imagesLoaded(function(){
        $container2.isotope({
            itemSelector : '.product-masonry',
            transitionDuration : '0.8s',
            masonry : {
                'gutter' : 0
            }
        });

    });
}
// jQuery(document).ready(function(){

//     "use strict";
//     noo_masonry2();

//     //Init masonry isotope
//     noo_masonry();
//     var $container = jQuery('.noo-product-grid');


//     var $filter = jQuery('.masonry-filters a');
//     $filter.click(function(e){
//         e.stopPropagation();
//         e.preventDefault();
//         var $this = jQuery(this);
//         // don't proceed if already selected
//         if ($this.hasClass('selected')) {
//             return false;
//         }
//         var filters = $this.closest('ul');
//         filters.find('.selected').removeClass('selected');
//         $this.addClass('selected');

//         var options = {},
//             key = filters.attr('data-option-key'),
//             value = $this.attr('data-option-value');

//         value = value === 'false' ? false : value;
//         options[key] = value;

//         $container.isotope(options);

//     });

// });
jQuery(document).ready(function(){
    "use strict";
    
    noo_masonry();
    noo_masonry2();
});

jQuery(document).on('noo-layout-changed', function() {
    "use strict";
    noo_masonry();
    noo_masonry2();
});


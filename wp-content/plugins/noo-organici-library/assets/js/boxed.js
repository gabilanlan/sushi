jQuery(document).ready(function(){

   sort_tabel();
    // add new box
    jQuery('.noo_new_box_item').click(function(){
       var  $new_html = jQuery('.noo_box_attribute:first-child').clone();
            $new_html.find('input').val('');
            var $src = $new_html.find('.box-admin-img').data('url');
            $new_html.find('.box-admin-img').attr('src',$src);
            $new_html.find('.noo_attribute_name').text(' ');
            $new_html.find('.noo-set-image').removeClass('noo_am_hide').addClass('noo_am_show');
            $new_html.find('.noo-remove-image').removeClass('noo_am_show').addClass('noo_am_hide');
        jQuery('.box_contents_wrap').append($new_html);
    });

    jQuery('.box_contents_wrap').on('keyup','.noo_box_title_item',function(){
        var $title = jQuery(this).val();
        jQuery(this).closest('.noo_box_attribute').find('.noo_attribute_name').text($title);

    });

    jQuery('.box_contents_wrap').on('click','.noo_delete',function(){
        var $check = confirm('Remove this box item?');
        if( $check == true ){
            jQuery(this).closest('.noo_box_attribute').remove();
        }
    });

    jQuery('.box_contents_wrap').on('click','.noo_handlediv_closed',function(){
        jQuery(this).addClass('noo_handlediv_open').removeClass('noo_handlediv_closed');
        var $element = jQuery(this).closest('.noo_box_attribute');
        $element.removeClass('noo_closed');
        $element.addClass('noo_open');
        $element.find('.noo_box_attribute_item').slideUp();
    });
    jQuery('.box_contents_wrap').on('click','.noo_handlediv_open',function(){
        jQuery(this).addClass('noo_handlediv_closed').removeClass('noo_handlediv_open');
        var $element = jQuery(this).closest('.noo_box_attribute');
        $element.removeClass('noo_open');
        $element.addClass('noo_closed');
        $element.find('.noo_box_attribute_item').slideDown();
    });


});

function sort_tabel(){
    jQuery('.box_contents_wrap').sortable({
        placeholder: "ui-state-highlight",
        forcePlaceholderSize: true,
        item: 'noo_box_attribute',
        handle: 'h3.noo_sort'
    });
}
jQuery(document).ready(function(){
    page_filter = jQuery('#filter-listing-script').val();

    if(page_filter == "membre"){

        type = jQuery('#type_membre').val();
        let ajaxurl = WP_AJAX_URL;
        data = {
            type:type,
            action:'find_membre'
        };
        
        jQuery.post(ajaxurl, data, function(response) {
            print_membre(response);
        });

        function print_membre(response) {
            let htmlResult = ``;
            jQuery.each(response, (key, item)=>{
                
                htmlResult += `<div class="vc_fluid col-sm-3">
                <div class="vc_column-inner ">
                    <div class="wpb_wrapper">
                        <div class="wpb_single_image widget wpb_content_element vc_align_center">
                            <figure class="wpb_wrapper vc_figure">
                                <a href="${item.post_meta._cge_membre_url[0]}" target="_blank" class="vc_single_image-wrapper   vc_box_border_grey">
                                    <img width="200" height="93" src=" ${item.thumbnail}" class="vc_single_image-img attachment-large" alt=""/>
                                </a>
                            </figure>
                        </div>
                        <div class="widget wpb_text_column wpb_content_element ">
                            <div class="wpb_wrapper">
                                <p style="text-align: center;">
                                    <a href="${item.post_meta._cge_membre_url[0]}" target="_blank" rel="noopener noreferrer">${item.post.post_title}</a>
                                </p>
            
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;
            });
            jQuery('#cge_entry_membre').html(htmlResult);
        }

    }
    

});
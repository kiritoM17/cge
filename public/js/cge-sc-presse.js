jQuery(document).ready(function(){

    page_filter = jQuery('#filter-listing-script').val();

    if(page_filter == "presse"){
        jQuery('#presse_search').on('click',function(e){
            e.preventDefault();
            let ajaxurl = WP_AJAX_URL;
            el = jQuery('#type_document');
            type_document  = jQuery('#type_document :selected').val();
            annee = jQuery('#annee :selected').val();
            mots  = jQuery('#mots').val();

            data = {
                type_document:type_document,
                annee:annee,
                mots:mots,
                action:'find_presse'
            };
            
            jQuery.post(ajaxurl, data, function(response) {
                print_presse(response);
            });

        });

        jQuery(document).ready(function() {
            let ajaxurl = WP_AJAX_URL;
            data = {
                    type_document:"",
                    annee:"",
                    mots:"",
                    action:'find_presse'
            };
            
            jQuery.post(ajaxurl, data, function(response) {
                print_presse(response);
            });

        });

        function print_presse(response) {
            jQuery('.nb_res_presse').html(response.length);
            let $presseLogo = "image_pdf.png";
            let htmlResult = ``; 
            jQuery.each(response, (key, item)=>{
                let msec = Date.parse(item.post_meta._cge_presse_date);
                let date_emp = new Date(msec).toLocaleDateString();
                htmlResult += `<div class="col-md-4">
                <a href=" ${item.post_permalink}">
                    <article class="post post-grid type-post format-standard format-formation post-grid-link">
                        <div class="entry-content">
                            <div class="vc_logo-wrapper">
                                <img src="${ CGE_PUBLIC_IMG + 'presse/' + $presseLogo }">
                            </div>
                            <div class="entry-meta">
                                <div class="info">
                                    <div class="meta">
                                        <span class="category "> </span>                
                                    </div>
                                    
                                    <h4 class="entry-title">
                                    ${item.post.post_title}
                                    </h4> 
                                    <ul>
                                        <li>
                                            Date de publicaton : 
                                            ${ date_emp != undefined && date_emp != "" ? date_emp : ""}
                                        </li>
                                        <li>
                                            Thématique : 
                                            ${item.post_meta._cge_presse_thematique != undefined && item.post_meta._ecole_statut[0] != "" ? item.post_meta._ecole_statut[0]: ""}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
            </div>`;
            });
            jQuery('#cge_entry_presse').html(htmlResult);
        }
    }

});
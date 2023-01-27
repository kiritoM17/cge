jQuery(document).ready(function(){

    page_filter = jQuery('#filter-listing-script').val();

    if(page_filter == "publication"){

        jQuery('#publication_search').on('click',function(e){
            e.preventDefault();
            let ajaxurl = WP_AJAX_URL;
            el = jQuery('#type_document');
            type   = jQuery('#type_document :selected').val();
            annee  = jQuery('#annee :selected').val();
            source = jQuery('#source :selected').val();
            mots   = jQuery('#mots').val();
            type_document_spe   = jQuery('#type_document_spe :selected').val();

            data = {
                type:type,
                annee:annee,
                source:source,
                mots:mots,
                type_document_spe:type_document_spe,
                action:'find_publication'
            };
            
            jQuery.post(ajaxurl, data, function(response) {
                print_publication(response);
            });

        });

        jQuery(document).ready(function() {
            let ajaxurl = WP_AJAX_URL;
            data = {
                    type:"",
                    annee:"",
                    source:"",
                    mots:"",
                    type_document_spe:"",
                    action:'find_publication'
            };
            
            jQuery.post(ajaxurl, data, function(response) {
                print_publication(response);
            });

        });

        function print_publication(response) {
            jQuery('.nb_res_publication').html(response.length);
            let $publicationLogo = "image_doc.png";
            let htmlResult = ``; 
            jQuery.each(response, (key, item)=>{
                let msec = Date.parse(item.post_meta._cge_publication_date);
                let date_emp = new Date(msec).toLocaleDateString();
                htmlResult += `<div class="col-md-4">
                <a href="${item.post_permalink}">
                    <article class="post post-grid type-post format-standard format-formation post-grid-link">
                        <div class="entry-content">
                            <div class="vc_logo-wrapper">
                                <img src="${ CGE_PUBLIC_IMG + 'publication/' + $publicationLogo }">
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
                                            ${item.post_meta._cge_publication_thematique != undefined && item.post_meta._ecole_statut[0] != "" ? item.post_meta._ecole_statut[0]: ""}
                                        </li>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </article>
                </a>
            </div>`;
            });
            jQuery('#cge_entry_publication').html(htmlResult);
        }
    }

});
jQuery(document).ready(function(){
	jQuery('#publication_search').on('click',function(e){
        e.preventDefault();
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

        console.log(data)
        
        jQuery.post(ajaxurl, data, function(response) {
            print_publication(response);
        });

    });

    jQuery(document).ready(function() {
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
        jQuery('.nb_res').html(response.length);
        console.log(response);
        let htmlResult = ``; 
        jQuery.each(response, (key, item)=>{
            htmlResult += `<div class="col-md-4">
            <a href="">
                <article class="post post-grid type-post format-standard format-formation post-grid-link">
                    <div class="entry-content">
                        <div class="vc_logo-wrapper">
                            <img src="https://www.cge.asso.fr/wp-content/uploads/2017/02/image_doc.png">
                        </div>
                        <div class="entry-meta">
                            <div class="info">
                                <div class="meta">
                                    <span class="category "> </span>                
                                </div>
                                
                                <h4 class="entry-title">
                                ${item.post.post_title}
                                </h4> 
                            </div>
                        </div>
                    </div>
                </article>
            </a>
        </div>`;
        });
        jQuery('#cge_entry_publication').html(htmlResult);
    }
});
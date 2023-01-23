jQuery(document).ready(function(){
	jQuery('#recrutement_search').on('click',function(e){
        e.preventDefault();
		el = jQuery('#lieu_emplois :selected');

        $lieu_emplois = jQuery('#lieu_emplois :selected').val();
        $demandeur_emplois = jQuery('#demandeur_emplois :selected').val();
        $poste_propose_emplois = jQuery('#mots').val();


        data = {
            lieu_emplois:lieu_emplois,
            demandeur_emplois:demandeur_emplois,
            poste_propose_emplois:poste_propose_emplois,
            action:'find_recrutement'
        };
        
        jQuery.post(ajaxurl, data, function(response) {
            print_recrutement(response);
        });

    });

    jQuery(document).ready(function() {
        data = {
            lieu_emplois:"",
            demandeur_emplois:"",
            poste_propose_emplois:"",
            action:'find_recrutement'
        };
        
        jQuery.post(ajaxurl, data, function(response) {
            print_recrutement(response);
        });

    });

    function print_recrutement(response) {
        jQuery('.nb_res').html(response.length);
        console.log(response);
        let $recrutementLogo = "image_doc.png";
        let htmlResult = ``; 
        jQuery.each(response, (key, item)=>{
            htmlResult += `<div class="col-md-4">
            <a href="">
                <article class="post post-grid type-post format-standard format-formation post-grid-link">
                    <div class="entry-content">
                        <div class="entry-meta">
                            <div class="info">
                                <div class="meta">
                                    <span class="category "> </span>                
                                </div>
                                
                                <h4 class="entry-title">
                                ${item.post.post_title}
                                </h4> 
                                <span class="date">${item.post_meta.date_debut_emplois}</span>
                            </div>
                        </div>
                        <div class="entry-description">${item.post_meta.poste_propose_emplois}
                        </div>
                    </div>
                </article>
            </a>
        </div>`;
        });
        jQuery('#cge_entry_recrutement').html(htmlResult);
    }
});
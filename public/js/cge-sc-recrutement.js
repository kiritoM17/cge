/**
 * @typedef {Object} Data
 * @property {string} lieu_emplois
 * @property {string} demandeur_emplois
 * @property {string} poste_propose_emplois
 * @property {string} action
 * 
 *  
 */

jQuery(document).ready(function(){
    
	jQuery('#recrutement_search').on('click',function(e){
        e.preventDefault();
        let ajaxurl = WP_AJAX_URL;
		el = jQuery('#lieu_emplois').val();
        lieu_emplois = jQuery('#lieu_emplois').val();
        demandeur_emplois = jQuery('#demandeur_emplois').val();
        poste_propose_emplois = jQuery('#poste_propose_emplois').val();

        /**
         * @type {Data}
         */
        let data = {
            lieu_emplois,
            demandeur_emplois,
            poste_propose_emplois,
            action:'find_recrutement'
        };
        
        jQuery.post(ajaxurl, data, function(response) {
            print_recrutement(response);
        });

    });

    jQuery(document).ready(function() {
        let ajaxurl = WP_AJAX_URL;
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
        jQuery('.nb_res_recrutement').html(response.length);
        let htmlResult = ``; 
        jQuery.each(response, (key, item)=>{
            let msec = Date.parse(item.post_meta.date_debut_emplois);
            let date_emp = new Date(msec).toLocaleDateString();
            htmlResult += `<div class="col-md-4">
            <a href="${item.post_permalink}">
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
                                <span class="date">${date_emp}</span>
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
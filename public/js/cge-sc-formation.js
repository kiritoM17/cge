jQuery(document).ready(function() {
    
    jQuery('#cge_formation_search').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        let ajaxurl = WP_AJAX_URL;
        el = jQuery('#formations_domaines');
        type_formation = jQuery('#type_formation :selected').val();
        ecole_formation = jQuery('#ecole_formation :selected').val();
        co_accrediteurs = '';//jQuery('#ecole_formation :selected').text();
        formations_domaines = jQuery('#formations_domaines :selected').val();
        formations_themes = jQuery('#formations_themes :selected').val();
        mots = jQuery('#mots').val();
        if (type_formation == '' && ecole_formation == '' && mots == '' && formations_themes == '' && formations_domaines == '') {   
            jQuery('.nb_res_formation').text(nb_res);
        } else {
            jQuery('#cge_entry_formation').html('');
            data = {
                type_formation: type_formation,
                ecole_formation: ecole_formation,
                co_accrediteurs: co_accrediteurs,
                formations_domaines: formations_domaines,
                formations_themes: formations_themes,
                mots: mots,
                action: 'find_formation'
            };
            jQuery.post(ajaxurl, data, function(response) {
                print_formation(response);
            });
        }
        return false;
    });

    jQuery(document).ready(function() {
        let ajaxurl = WP_AJAX_URL;
        data = {
            type_formation: "",
            ecole_formation: "",
            co_accrediteurs: "",
            formations_domaines: "",
            formations_themes: "",
            mots: "",
            action: 'find_formation'
        };
        jQuery.post(ajaxurl, data, function(response) {
            print_formation(response);
        });

    });

    function print_formation(response) {
        
        jQuery('.nb_res_formation').html(response.length);
        let htmlResult = ``;
        jQuery.each(response, (key, item)=>{
            let $logo = "";
            console.log(item);
            if (item.formation_type[0].name == "MS") {
                $logo = "logo-ms.png";
            } else if (item.formation_type[0].name == "MSc") {
                $logo = "logo-msc.png";
            } else if (item.formation_type[0].name == "BADGE") {
                $logo = "logo-badge.png";
            } else if (item.formation_type[0].name == "CQC") {
                $logo = "logo-cqc.png";
            }
            let logoHtml = "";
            if ($logo != "")
                logoHtml += `
                <div class="vc_logo-wrapper">
                    <img src="${ CGE_PUBLIC_IMG + 'formation_type/' + $logo }" />
                </div>`;
            let htmlCoAccrediteurs = "";
            jQuery.each(item._formation_co_accrediteurs, (key, $c)=>{
                htmlCoAccrediteurs += `${$c} <br />`;
            });

            htmlResult += `
            <div class="col-md-12 col-msalumni">
                <article class="post post-grid type-post format-standard format-msalumni">
                    <a href="${item.post_meta._formation_website[0]}" target="_blanc">
                        <div  class="entry-content row">
                            <div class="col-md-4">
                                ${logoHtml}
                            </div>
                            <div class="col-md-8">
                            <div class = "row">
                                <div class="col-md-6">
                                    <h4 class="entry-title-2">
                                        ${item.post.post_title}
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <span class="date">
                                        ${item.post_meta._formation_ecole_nom[0] != "" ? item.post_meta._formation_ecole_nom[0] : ""}
                                    </span>
                                    <span class="date">
                                        ${htmlCoAccrediteurs}
                                    </span>
                                </div>
                                   
                                <div class = "row">
                                    <div class="col-md-12">
                                        <span class="date">
                                            ${item.post_meta._formation_langues_enseignements[0] != "" ? item.post_meta._formation_langues_enseignements[0] : ""}
                                        </span>
                                        <span class="date">
                                            ${item.post_meta._formation_duree_formation_mois[0] != "" ? item.post_meta._formation_duree_formation_mois[0] : ""}
                                        </span>
                                        <span class="date">
                                           ${ item.post_meta._formation_voix_admission[0] != "" ? item.post_meta._formation_voix_admission[0] : "" }
                                        </span>
                                        <span class="date">
                                            ${item.post_meta._formation_niveau_entree[0] != "" ? item.post_meta._formation_niveau_entree[0] : ""}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div> 
                    </a>
                </article>
            </div>
            `;
        });
        jQuery('#cge_entry_formation').html(htmlResult);
    }
    
   
});
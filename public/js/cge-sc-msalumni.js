jQuery(document).ready(function(){
    
    page_filter = jQuery('#filter-listing-script').val();

    if(page_filter == "msalumn"){
        
        jQuery('#i_search').on('click',function(e){
            e.preventDefault();
            filter_student(1);
        });
    
        jQuery('#load-student-more').on('click',function(e){
            e.preventDefault();
            var paged = jQuery(this).data('paged');
            var totalPaged = jQuery(this).data('total-paged');
            paged = parseInt(paged) + 1 ;
            if( parseInt(paged) <  parseInt(totalPaged) )
                filter_student(paged, 'append');
            jQuery(this).data('paged', paged);
        });
    
        jQuery(document).ready(function() {
            let ajaxurl = WP_AJAX_URL;
            data = {
                    annee:"",
                    nom:"",
                    intitule:"",
                    ecole:"",
                    paged: 1,
                    action:'find_msalumini'
            };
            
            jQuery.post(ajaxurl, data, function(result) {
                print_msalumini(result.response, result.total, result.total_page);
            });
    
        });
    
        function filter_student(paged, actionHtml="insert")
        {
            jQuery("#loader-wrapper").show('fast');
            var keys =[];
            var values = [];
            var compares =[];
            annee = jQuery('#annee :selected').val();
            if(annee > 0) {
                keys.push("annee_obtention");
                values.push(annee);
                compares.push("=");
            }
            
            nom  = jQuery('#nom').val();
            if(nom!=''){
                keys.push("nom");
                values.push(nom);
                compares.push("LIKE");
                
            }
            
            ecole = jQuery('#ecole_formation').val();
            if(ecole!=''){
                keys.push("ecole");
                values.push(ecole);
                compares.push("LIKE");
            }
    
            intitule = jQuery('#intitule').val();
            if(intitule!=''){
                keys.push("formation");
                values.push(intitule);
                compares.push("LIKE");
            } 
    
            if(nom ==''  && annee ==''){
                el.data('post-in','');
                data2 = el.data();
                jQuery.post(ajaxurl, data, function(result) {
                    print_msalumini(result.response, result.total, result.total_page);
                    jQuery("#loader-wrapper").hide('fast');
                }); 
            }else{
                data = {
                        annee:annee,
                        nom:nom,
                        intitule:intitule,
                        ecole:ecole,
                        paged: paged,
                        action:'find_msalumini'
                }
                jQuery.post(ajaxurl, data, function(result) {
                    print_msalumini(result.response, result.total, result.total_page, actionHtml);
                    jQuery("#loader-wrapper").hide('fast');
                });
    
            }
        }
    
        function print_msalumini(response, total, total_page, actionHtml="insert") {
            jQuery('.nb_res_msalumni').html(`${total} diplômés`);
            jQuery('#load-student-more').data('total-paged', total_page);
            let htmlResult = ``; 
            jQuery.each(response, (key, item)=>{
                htmlResult += `<div class="col-md-12 col-msalumni">
                <article class="post post-grid type-post format-standard format-msalumni">
                    <div class="entry-content row">
                        <div class="col-md-3">
                           <h4 class="entry-title-2">${item.post.post_title}</h4> 
                        </div>
                        <div class="col-md-3">
                            <span class="ecole">${item.post_meta.ecole[0]}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="date">${item.post_meta.annee_obtention[0]}</span>
                        </div>
                        <div class="col-md-3">
                            <span class="intitule">${item.post_meta.formation[0]}</span>
                        </div>
                    </div>
                </article>
            </div>`;
            });
            if(actionHtml == "append")
                jQuery('#cge_entry_msalumni').append(htmlResult);
            else
                jQuery('#cge_entry_msalumni').html(htmlResult);
        }

    }

});
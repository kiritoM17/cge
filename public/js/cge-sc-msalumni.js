jQuery(document).ready(function(){
    jQuery('#msalumni_search').on('click',function(e){
        e.preventDefault();
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
        
        ecole = jQuery('#ecole').val();
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
            jQuery.post(ajaxurl, data, function(response) {
                print_msalumini(response);
            }); 
        }else{
            data = {
                    annee:annee,
                    nom:nom,
                    action:'find_msalumini'
            }

            //call ajax function to get filred item
            jQuery.post(ajaxurl, data, function(response) {
                print_msalumini(response);
                    // if(response !="ko" ){
                    //     jQuery('#message_load').hide();
                    //     postsins = response;

                    //     el.data('post-in',postsins);
                    //     data2 = el.data(); // Get data values of selected item 

                    //     ajaxloadmore.filter('fade', '300', data2) ;
                    //     var cnt=response.split(",").length;
                        
                        
                    //     jQuery('.result-search').html("");
                    //     if(cnt > 1){
                    //         jQuery('.result-search').html(cnt+" résultats");
                    //     }else{
                    //         jQuery('.result-search').html(cnt+" résultat");
                    //     }
                    // }else{
                    //     jQuery('#ajax-load-more').hide();
                    //     jQuery('#message_load').show();
                    //     jQuery('.result-search').html("0 résultats");
                            
                    // }
            });

        }	
    });

    jQuery(document).ready(function() {
        data = {
                annee:annee,
                nom:nom,
                action:'find_msalumini'
        };
        jQuery.post(ajaxurl, data, function(response) {
            print_msalumini(response);
        });

    });

    function print_msalumini(response) {
        jQuery('.nb_res').html(response.length);
        let htmlResult = ``; 
        jQuery.each(response, (key, item)=>{
            htmlResult += `<div class="col-md-12 col-msalumni">
            <article class="post post-grid type-post format-standard format-msalumni">
                <div class="entry-content row">
                    <div class="col-md-3">
                       <h4 class="entry-title-2">
                            <?php echo $post->post_title; ?>
                        </h4>
                    </div>
                    <div class="col-md-3">
                        <span class="ecole"></span>
                    </div>
                    <div class="col-md-3">
                        <span class="intitule"></span>
                    </div>
                    <div class="col-md-3">
                        <span class="annee"></span>
                    </div>
                </div>
            </article>
        </div>`;
        });
        jQuery('#cge_entry_formation').html(htmlResult);
    }

   
});
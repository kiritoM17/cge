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
                    intitule:intitule,
                    ecole:ecole,
                    action:'find_msalumini'
            }

            console.log(data);
            //call ajax function to get filred item
            jQuery.post(ajaxurl, data, function(response) {
                print_msalumini(response);
            });

        }	
    });

    jQuery(document).ready(function() {
        data = {
                annee:"",
                nom:"",
                intitule:"",
                ecole:"",
                action:'find_msalumini'
        };
        
        jQuery.post(ajaxurl, data, function(response) {
            print_msalumini(response);
        });

    });

    function print_msalumini(response) {
        jQuery('.nb_res').html(response.length);
        console.log(response);
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
        jQuery('#cge_entry_msalumni').html(htmlResult);
    }
});
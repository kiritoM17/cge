jQuery(document).ready(function(){
    page_filter = jQuery('#filter-listing-script').val();

    if(page_filter == "job_listing"){

        jQuery(document).on('change', '#job_region_select,#job_type_select,#job_amenity_select,#label4digital', function(){
            onFilterJobListing();
        });

        jQuery(document).on('keyup', '#job_search_keywords', function(){
            if(jQuery(this).val() && jQuery(this).val().length >1)
                onFilterJobListing();
        });

        jQuery(document).on('click','.open-post-popup',function(){
            markers[jQuery(this).attr('post')].openPopup();

        });

        function onFilterJobListing()
        {
            jQuery("#loader-wrapper").show('fast');
            let ajaxurl = WP_AJAX_URL;
            let job_region_select   = jQuery('#job_region_select').val();
            let job_type_select  = jQuery('#job_type_select').val();
            let job_amenity_select = jQuery('#job_amenity_select').val();
            let job_search_keywords   = jQuery('#job_search_keywords').val();
            let label4digital = jQuery('#label4digital').is(':checked');
            data = {
                job_region_select:job_region_select,
                job_type_select:job_type_select,
                job_amenity_select:job_amenity_select,
                job_search_keywords:job_search_keywords,
                label4digital: label4digital == true ? '1' : '',
                action:'find_job_listing'
            };
            jQuery.post(ajaxurl, data, function(result) {
                print_job_listing(result.response);
                add_map_multiple_markers(result.map_information);
                jQuery("#loader-wrapper").hide('fast');
            });
        }

        function subStringContent(content)
        {
            return content.substring(0, 100);
        }

        function print_job_listing(posts)
        {
            console.log(response)
            let htmlResult = ``;
            if(Array.isArray(posts))
            {
                jQuery('#count_members_school').html(posts.length);
                jQuery.each(posts, (key, item)=>{
                    let post_content = item.post.post_content.substring(0,150);
                    htmlResult +=`
                        <div class="row-content">
                            <div class="logo-ecole">
                                <div class="grid-style1" itemscope itemtype="http://schema.org/LocalBusiness" data-longitude="${item.post_meta.geolocation_long != undefined && item.post_meta.geolocation_long[0] != ""? item.post_meta.geolocation_long[0] : ""}" data-latitude="${item.post_meta.geolocation_lat != undefined && item.post_meta.geolocation_lat[0] !="" ? item.post_meta.geolocation_lat[0] : "" }" data-img="${ item.post_meta._ecole_logo != undefined && item.post_meta._ecole_logo[0] != "" ? item.post_meta._ecole_logo[0] : ""}">  
                                    <div class="listing-image">
                                        <div class="image-wrapper">
                                            <a href="#">
                                                <img src="${item.post_meta._ecole_logo != undefined && item.post_meta._ecole_logo[0] != "" ? item.post_meta._ecole_logo[0]: ""}" data-src="${item.post_meta._ecole_logo != undefined && item.post_meta._ecole_logo[0] != "" ? item.post_meta._ecole_logo[0]: ""}" alt="" class="unveil-image">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="detail-ecole">
                                <div class="listing-title-wrapper">
                                    <h3 class="listing-title">
                                        <a href="#">
                                            ${item.post.post_title}
                                        </a>
                                    </h3>
                                    <ul>
                                        <li>
                                            Date de création : 
                                            ${ item.post_meta._ecole_annee_creation != undefined && item.post_meta._ecole_annee_creation[0] != "" ? item.post_meta._ecole_annee_creation[0]: ""}
                                        </li>
                                        <li> Nom du membre : 
                                            ${item.post_meta._ecole_nom != undefined && item.post_meta._ecole_nom[0] != "" ? item.post_meta._ecole_nom[0]: ""}
                                        </li>
                                        <li> Descriprtion : 
                                            ${post_content != undefined && post_content != "" ? post_content : ""}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }
            jQuery('#cge_entry_job_listing').html(htmlResult);
        }

        function  add_map_multiple_markers(data){
            let container = L.DomUtil.get('map');
            if(container != null){
                container._leaflet_id = null;
            }
            markers = [];
            var locations = data;
            var markers_cluster = L.markerClusterGroup();
            if(locations.length>0){
                map = L.map('map').setView([locations[0][1], locations[0][2]], 1);
            }else {
                map = L.map('map').setView([49.540612, 1.821614], 1);
            }
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
            var marker, i;
            if(Array.isArray(locations))
            {
                for (i = 0; i < locations.length; i++) {
                    let contentString = `
                        <div class="col"  style="width:100%;padding-top: 0;padding-bottom: 15px;padding-left: 0;padding-right: 0">
                            <div class="map-card-header">
                            <div class="map-card-header-options">
                                    &nbsp;
                                </div>
                            <span><a class="close-card-map">X</a> </span>
                            </div>
                            <div class="map-image">
                                <img title="${locations[i][0]}" alt="${locations[i][0]}" src="${locations[i][3]}" style="width: 300px; max-width: 100% !important;height: 300px!important;object-fit: contain;">
                            </div>
                        <div><span style="font-size:24px !important;color: ${locations[i][9]}"><b>${locations[i][0]}</b></span></div>
                        <div><p><i>${locations[i][8]}</i></p></div>
                            <div style="width:100%;margin-bottom: 15px;">${locations[i][4]}</div><br>
                            <div class="map-card-btn"><a href="${locations[i][6]}" target="_blank" style="background-color:${locations[i][10]} !important;color: ${locations[i][11]} !important;"><span class="e-torisme-btn" style="width: 100% !important;background-color:${locations[i][10]};color:${locations[i][11]} ">Discover</span></a></div>
                        </div>
                    `;
                    marker = new L.marker([locations[i][1], locations[i][2]],
                        {
                            icon: L.divIcon({
                                className:'ship-div-icon',
                                html: '<i class="fa fa-map-marker fa-3x" style="color:'+locations[i][7]+'"></i>'
                            }),
                        }
                    ).bindPopup(contentString);
                    map.on('popupclose',function (marker){
                        var cM = map.project(marker.popup._latlng);
                        map.setView(map.unproject(cM),10, {animate: true});
                    });
                    let post_id = locations[i][5]
                    markers[post_id] = marker;
                    markers_cluster.addLayer(marker);
                }
            }
            map.addLayer(markers_cluster);
        }

    }
    
});
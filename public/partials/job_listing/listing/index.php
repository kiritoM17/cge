<?php
echo '<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="">';
echo '<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.css" />';
echo '<link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.3.0/dist/MarkerCluster.Default.css" />';
?>

<input type="hidden" value="job_listing" id="filter-listing-script" name="filter-listing-script"/>


<div class="row" style="width: 100% !important;margin: 0;padding: 0;max-width: 100%;">
    <?php if (file_exists(CGE_PUBLIC_PARTIALS . 'job_listing/listing/filter.php')) {
            require_once(CGE_PUBLIC_PARTIALS . 'job_listing/listing/filter.php');
        } ?>
    <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
        <?php if (file_exists(CGE_PUBLIC_PARTIALS . 'job_listing/listing/list.php')) {
            require_once(CGE_PUBLIC_PARTIALS . 'job_listing/listing/list.php');
        } ?>
    </div>
    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
        <?php if (file_exists(CGE_PUBLIC_PARTIALS . 'job_listing/listing/map.php')) {
            require_once(CGE_PUBLIC_PARTIALS . 'job_listing/listing/map.php');
        } ?>
    </div>
</div>
<div id="loader-wrapper">
    <div id="loader-overlay">
        <div class="loader"></div>
    </div>
</div>


<script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.3.0/build/ol.js"></script>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.markercluster@1.3.0/dist/leaflet.markercluster.js"></script>
<script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
</script>
<?php //die(var_dump($location_array_string)); 
?>
<script>
    let map;
    let markers = [];
    var markers_cluster = L.markerClusterGroup();
    var locations = <?php echo $location_array_string;
                    ?>;
    map = L.map('map').setView([49.540612, 1.821614], 0, {
        closePopupOnClick: false
    });
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    var marker, i;
    var marker, i;

    for (i = 0; i < locations.length; i++) {
        let contentString = `
        <div class="col"  style=" min-width: 300px;max-width:100%;padding-top: 0;padding-bottom: 15px;padding-left: 0;padding-right: 0">
            <div class="map-card-header"><span><a class="close-card-map">X</a> </span></div>
            <div class="map-image">
                <img title="${locations[i][0]}" alt="${locations[i][0]}" src="${locations[i][3]}" style="width: 100% !important;height: 300px!important;">
            </div>
        <div><p style="font-size:24px !important;color: ${locations[i][9]}"><b>${locations[i][0]}</b></p></div>
        <div><p><i>${locations[i][8]}</i></p></div>
            <div style="width:100%;margin-bottom: 15px;">${locations[i][4]}</div><br>
            <div class="map-card-btn"><a href="${locations[i][6]}" target="_blank" style="background-color:${locations[i][10]} !important;color: ${locations[i][11]} !important;"><span class="e-torisme-btn" style="width: 100% !important;background-color:${locations[i][10]};color:${locations[i][11]} ">Discover</span></a></div>
        </div>
    `;
        marker = new L.marker([locations[i][1], locations[i][2]], {
            icon: L.divIcon({
                className: 'ship-div-icon',
                html: '<i class="fa fa-map-marker fa-3x" style="color:' + locations[i][7] + '"></i>'
            }),
        }).bindPopup(contentString);
        map.on('popupclose', function(marker) {
            var cM = map.project(marker.popup._latlng);
            cM.y -= marker.popup._container.clientHeight / 2
            map.setView(map.unproject(cM), 13, {
                animate: true
            });
        });
        map.on('popupopen', function(marker) {
            var cM = map.project(marker.popup._latlng);
            map.setView(map.unproject(cM), 17, {
                animate: true
            });
        });
        let post_id = locations[i][5]
        markers[post_id] = marker;
        markers_cluster.addLayer(marker);
    }
    map.addLayer(markers_cluster);
</script>
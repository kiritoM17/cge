<?php
$location_array_string = '[';
foreach ($post_type_information_array as $post_info) {
    $location_array_string = $location_array_string . "['" . str_replace(["'", '"'], ["\'", '\"'], $post_info[0]) . "'," . $post_info[1] . "," . $post_info[2] . ",'" . $post_info[3] . "','" . str_replace(["'", '"'], ["\'", '\"'], wp_trim_words($post_info[4], 20, ' ...')) . "'," . $post_info[5] . ",'" . $post_info[6] . "','" . $post_info[7] . "','" . str_replace(["'", '"'], ["\'", '\"'], $post_info[8]) . "','" . $post_info[9] . "','" . $post_info[10] . "','" . $post_info[11] . "'],";
}
$location_array_string = $location_array_string . "]";
?>
<div id="map" style="width: 100% !important;position: relative;overflow: hidden;height: 100%;min-height: 800px;"></div>

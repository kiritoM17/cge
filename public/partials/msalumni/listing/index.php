
<?php

?>

<input type="hidden" value="msalumni" id="filter-listing-script" name="filter-listing-script">
<div style="
    margin: 0;
    padding: 0;
    width: 100%;
    max-width: 100%;
" >
    <div class="row" >
        <div class="col-md-12">
            <?php if (file_exists(CGE_PUBLIC_PARTIALS . 'msalumni/listing/filter.php')) {
                require_once(CGE_PUBLIC_PARTIALS . 'msalumni/listing/filter.php');
            } ?>
        </div>
    </div>
    <?php if (file_exists(CGE_PUBLIC_PARTIALS . 'msalumni/listing/list.php')) {
        require_once(CGE_PUBLIC_PARTIALS . 'msalumni/listing/list.php');
    } ?>
</div>
<div id="loader-wrapper">
    <div id="loader-overlay">
        <div class="loader"></div>
    </div>
</div>
<script>
var ajaxurl ='<?php echo  admin_url( 'admin-ajax.php' )?>';
</script>
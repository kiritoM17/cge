<?php

?>
<div class="row" style="width: 100% !important;margin: 0;padding: 0;max-width: 100%;">
    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
        <div class="row col-md-12">
            <?php if (file_exists(CGE_PUBLIC_PARTIALS . 'job_listing/listing/filter.php')) {
                require_once(CGE_PUBLIC_PARTIALS . 'job_listing/listing/filter.php');
            } ?>
        </div>
        <?php if (file_exists(CGE_PUBLIC_PARTIALS . 'job_listing/listing/list.php')) {
            require_once(CGE_PUBLIC_PARTIALS . 'job_listing/listing/list.php');
        } ?>
    </div>

    <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

    </div>

</div>

<script>
    var ajaxurl = '<?php echo admin_url('admin-ajax.php') ?>';
    var nb_res = <?php echo count($myposts); ?>;
</script>
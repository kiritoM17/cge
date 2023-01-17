<?php

?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php if (file_exists(CGE_PUBLIC_PARTIALS . 'formation/listing/filter.php')) {
                require_once(CGE_PUBLIC_PARTIALS . 'formation/listing/filter.php');
            } ?>
        </div>
    </div>
    <?php if (file_exists(CGE_PUBLIC_PARTIALS . 'formation/listing/list.php')) {
        require_once(CGE_PUBLIC_PARTIALS . 'formation/listing/list.php');
    } ?>
</div>
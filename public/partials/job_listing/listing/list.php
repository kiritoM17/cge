<div class="row col-md-12">
    <?php
        foreach($wp_query->posts as $post)
        {
            $data = get_post_custom($post->ID);?>
            <?php die(var_dump($post, $data));?>
        <?php }?>

</div>
<div class="row" id="cge_entry_presse" >
    <?php foreach ($myposts as $post) { ?>
        
    <div class="col-md-4">
        <a href="">
            <article class="post post-grid type-post format-standard format-formation post-grid-link">
                <div class="entry-content">
                    <div class="vc_logo-wrapper">
                        <img src="https://www.cge.asso.fr/wp-content/uploads/2017/02/image_pdf.png">
                    </div>
                    <div class="entry-meta">
                        <div class="info">
                            <div class="meta">
                                <span class="category "> </span>                
                            </div>
                            
                            <h4 class="entry-title">
                                <?php echo $post->post_title; ?>
                            </h4> 
                        </div>
                    </div>
                </div>
            </article>
        </a>
    </div>
        
    <?php } ?>
</div> 
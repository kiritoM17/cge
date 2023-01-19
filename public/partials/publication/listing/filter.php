<div class="col-md-12">
    <div class="widget-filtre widget-listingsearch layout1 filtre-pub">
        <form class="form-inline search-form clearfix" action="" method="get" role="search">
            <div class="form-group">
                <label for="select1" class="hidden">Type de documents</label>
                <select form="select1" name="type_document" id="type_document" data-post-in="">
                    <option value="">Type de documents</option>
                    <?php 
                        foreach ($taxonomy_documents as $doc){ ?>
                                <option value="<?php echo  $doc->slug ?>"><?php echo  $doc->name ?></option>
                        <?php }
                    
                    
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="type_document_spe" class="hidden">Thèmes</label>
                <select form="type_document_spe" name="type_document_spe" id="type_document_spe" data-post-in="">
                    <option value="">Thème de document</option>
                    <?php 
                        foreach ($taxonomy_type_spe as $doc_spe){ ?>
                                <option value="<?php echo  $doc_spe->slug ?>"><?php echo  $doc_spe->name ?></option>
                        <?php }
                    
                    
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="annee" class="hidden">Année</label>
                <select form="select1" name="annee" id="annee" data-post-in="">
                    <option value="">Année</option>
                    <?php 
                        foreach ($taxonomy_annees as $doc){ ?>
                                <option value="<?php echo  $doc->slug ?>"><?php echo  $doc->name ?></option>
                        <?php }
                    ?>
                </select>
            </div>
            
            
            <div class="form-group">
                <label for="source" class="hidden">Source</label>
                <select form="select1" name="source" id="source" data-post-in="">
                    <option value="">Source</option>
                    <?php 
                        foreach ($taxonomy_sources as $doc){ ?>
                                <option value="<?php echo  $doc->slug ?>"><?php echo  $doc->name ?></option>
                        <?php }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                    <input type="text" class="form-text" name="mots" id="mots" placeholder="Mots clés"/>
            </div>
            

            <button type="submit" class="btn-2" id="publication_search">Rechercher</button>
        </form>
        <div class="result-search"><span class="nb_res"></span> résultats</div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="widget-filtre widget-listingsearch layout1">
            <form class="form-inline search-form clearfix" action="" method="get" role="search">
                <div class="form-group hidden">
                    <label for="select1" class="hidden">Format</label>
                    <select form="select1" name="type_document" id="type_document" data-post-in="">
                        <option value="">Format</option>
                        <?php 
                            foreach ($taxonomy_format as $doc){ ?>
                                    <option value="<?php echo  $doc->slug ?>"><?php echo  $doc->name ?></option>
                            <?php }
                        
                        
                        ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="type_document_spe" class="hidden">Type de documents</label>
                    <select form="type_document_spe" name="type_document_spe" id="type_document_spe" data-post-in="">
                        <option value="">Type de documents</option>
                        <?php 
                            foreach ($taxonomy_type_documents as $doc_spe){ ?>
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
                        <input type="text" class="form-text" name="mots" id="mots" placeholder="Mots clés"/>
                </div>
                

                <button type="submit" class="btn-2" id="search">Rechercher</button>
            </form>
            <div class="result-search"><?php echo count($myposts) ; ?> résultats</div>
        </div>
    </div>
</div>
   

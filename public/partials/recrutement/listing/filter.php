<div class="col-md-12">
    <div class="widget-filtre widget-listingsearch layout1 filtre-pub">
        <form class="form-inline search-form clearfix" action="" method="get" role="search" style="display: flex;">
            <div class="form-group">
                <label for="select1" class="hidden">Lieux</label>
                <select form="select1" name="lieu_emplois" id="lieu_emplois" data-post-in="">
                    <option value="">Lieux</option>
                    <?php 
                        foreach ($taxonomy_lieu_emplois as $doc){ ?>
                                <option value="<?php echo  $doc ?>"><?php echo  $doc ?></option>
                        <?php }
                    
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="select" class="hidden">Membres</label>
                <select form="select" name="demandeur_emplois" id="demandeur_emplois" data-post-in="">
                    <option value="">Membres</option>
                    <?php 
                        foreach ($taxonomy_demandeur_emplois as $doc_spe){ ?>
                                <option value="<?php echo  $doc_spe ?>"><?php echo  $doc_spe ?></option>
                        <?php }
                    
                    
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                    <input type="text" class="form-text" name="poste_propose_emplois" id="poste_propose_emplois" placeholder="intitulé"/>
            </div>
            

            <button type="submit" class="btn-2" id="recrutement_search">Rechercher</button>
        </form>
        <div class="result-search"><span class="nb_res"></span> résultats</div>
    </div>
</div>

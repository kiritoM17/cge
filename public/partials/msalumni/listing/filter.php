<?php

?>

<div class="widget-filtre widget-listingsearch layout1 filtre-pub filtre-msalumni">
    <form class="form-inline search-form clearfix" action="" method="get" role="search">
        
        
        <div class="form-group">
                <input type="text" class="form-text" name="nom" id="nom" placeholder="Nom"/>
        </div>
        
        <div class="form-group">
                <input type="text" class="form-text" name="ecole" id="ecole" placeholder="Ecole"/>
        </div>
        
        <div class="form-group">
                <input type="text" class="form-text" name="intitule" id="intitule" placeholder="Intitulé du MS"/>
        </div>
        
        <div class="form-group">
            <label for="select2" class="hidden">Année</label>
            <select form="select2" name="annee" id="annee">
                <option value="0">Année</option>
                <?php
                for($i = date("Y"); $i >= 1950; $i--){
                    echo '<option value="'.$i.'"  data-meta-key="annee_obtention" data-meta-value="'.$i.'">'.$i.'</option>';
                }
                ?>
            </select>
        </div>
        

        <button type="submit" class="btn-2" id="search">Rechercher</button>
    </form>
    <div class="result-search hidden"><?php echo count($myposts) ; ?> résultats</div>
</div>
<?php

?>

<div class="widget-filtre widget-listingsearch layout1">
    <form class="form-inline search-form clearfix form-filtre-formation" action="" method="get" role="search">
        <div class="form-group">
            <label for="select1" class="hidden">Type de formation</label>
            <select form="select1" name="type_formation" id="type_formation">
                <option value="">Type de formation</option>
                <?php foreach ($taxonomy_documents as $doc) { ?>
                    <option value="<?php echo $doc->slug ?>"><?php echo $doc->name ?></option>
                <?php }
                ?>
            </select>
        </div>
        <div class="form-group form-group-lg">
            <label for="select1" class="hidden">École</label>
            <select form="select1" name="ecole_formation" id="ecole_formation">
                <option value="">École</option>
                <?php foreach ($taxonomy_ecoles as $ecole) { ?>
                    <option value="<?php echo $ecole->slug ?>"><?php echo $ecole->name ?></option>
                <?php }
                ?>
            </select>
        </div>


        <div class="form-group">
            <label for="select1" class="hidden">Domaines</label>
            <select form="select1" name="formations_domaines" id="formations_domaines">
                <option value="">Domaines</option>
                <?php foreach ($formations_domaines as $doc) { ?>
                    <option value="<?php echo $doc->slug ?>"><?php echo $doc->name ?></option>
                <?php }
                ?>
            </select>
        </div>


        <div class="form-group">
            <label for="select1" class="hidden">Thèmes</label>
            <select form="select1" name="formations_themes" id="formations_themes">
                <option value="">Thèmes</option>
                <?php foreach ($formations_themes as $doc) { ?>
                    <option value="<?php echo $doc->slug ?>"><?php echo $doc->name ?></option>
                <?php }
                ?>
            </select>
        </div>


        <div class="form-group">
            <input type="text" class="form-text" name="mots" id="mots" placeholder="Mots clés" />
        </div>


        <button type="submit" class="btn-2" id="search">Rechercher</button>
    </form>
    <div class="result-search"><span class="nb_res"><?php echo count($myposts); ?></span>
        résultats
    </div>
</div>
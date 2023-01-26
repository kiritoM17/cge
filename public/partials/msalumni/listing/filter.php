<?php

?>

<div class="widget-filtre widget-listingsearch layout1 filtre-pub filtre-msalumni">
    <form class="form-inline search-form clearfix" action="" method="get" role="search">


        <div class="form-group">
            <input type="text" class="form-text" name="nom" id="nom" placeholder="Nom" />
        </div>

        <div class="form-group">
            <label for="select1" class="hidden">École</label>
            <select form="select1" name="ecole_formation" id="ecole_formation">
                <option value="">École</option>
                <?php foreach ($taxonomy_ecoles as $ecole) {
                ?>
                    <option value="<?php echo $ecole ?>"><?php echo $ecole ?></option>
                <?php }
                ?>
            </select>
        </div>

        <div class="form-group">
            <input type="text" class="form-text" name="intitule" id="intitule" placeholder="Intitulé du MS" />
        </div>

        <div class="form-group">
            <label for="select2" class="hidden">Année</label>
            <select form="select2" name="annee" id="annee">
                <option value="0">Année</option>
                <?php foreach ($taxonomy_annees as $annee) {
                ?>
                    <option value="<?php echo $annee ?>"><?php echo $annee ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn-2" id="msalumni_search">Rechercher</button>
    </form>
    <div class="result-search"><span class="nb_res_msalumni"></span></div>
</div>
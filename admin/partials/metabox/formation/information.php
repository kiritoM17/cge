<?php
global $post;
$data = get_post_custom($post->ID);
?>

<table class="form-table">
    <tbody>

        <tr class="form-field">
            <th scope="row">
                <label for="langues_enseignements" class="box-label"><?php echo __('Langues enseignements :', 'cge'); ?></label>
            </th>
            <td><input id="langues_enseignements" type="text" name="Formation[langues_enseignements]" value="<?php echo isset($data[$this->meta_prefix . 'langues_enseignements'][0]) ? $data[$this->meta_prefix . 'langues_enseignements'][0] : null; ?>"></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="partenaires" class="box-label"><?php echo __('Partenaires :', 'cge'); ?></label>
            </th>
            <td><input id="partenaires" type="text" name="Formation[partenaires]" value="<?php echo isset($data[$this->meta_prefix . 'partenaires'][0]) ? $data[$this->meta_prefix . 'partenaires'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="description_lieu_formation" class="box-label"><?php echo __('Description lieu formation :', 'cge'); ?></label>
            </th>
            <td><input id="description_lieu_formation" type="text" name="Formation[description_lieu_formation]" value="<?php echo isset($data[$this->meta_prefix . 'description_lieu_formation'][0]) ? $data[$this->meta_prefix . 'description_lieu_formation'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="duree_formation_mois" class="box-label"><?php echo __('duree formation mois :', 'cge'); ?></label>
            </th>
            <td><input id="duree_formation_mois" type="number" name="Formation[duree_formation_mois]" value="<?php echo isset($data[$this->meta_prefix . 'duree_formation_mois'][0]) ? $data[$this->meta_prefix . 'duree_formation_mois'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="voix_admission" class="box-label"><?php echo __('Voix d\'admission :', 'cge'); ?></label>
            </th>
            <td><input id="voix_admission" type="number" name="Formation[voix_admission]" value="<?php echo isset($data[$this->meta_prefix . 'voix_admission'][0]) ? $data[$this->meta_prefix . 'voix_admission'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="niveau_entree" class="box-label"><?php echo __('Niveau d\'entrée :', 'cge'); ?></label>
            </th>
            <td><input id="niveau_entree" type="number" name="Formation[niveau_entree]" value="<?php echo isset($data[$this->meta_prefix . 'niveau_entree'][0]) ? $data[$this->meta_prefix . 'niveau_entree'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="website" class="box-label"><?php echo __('website :', 'cge'); ?></label>
            </th>
            <td><input id="website" type="url" name="Formation[website]" value="<?php echo isset($data[$this->meta_prefix . 'website'][0]) ? $data[$this->meta_prefix . 'website'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="directeur_responsable_ms_msc_badge_cqc" class="box-label"><?php echo __('directeur responsable ms msc badge cqc :', 'cge'); ?></label>
            </th>
            <td><input id="directeur_responsable_ms_msc_badge_cqc" type="text" name="Formation[directeur_responsable_ms_msc_badge_cqc]" value="<?php echo isset($data[$this->meta_prefix . 'directeur_responsable_ms_msc_badge_cqc'][0]) ? $data[$this->meta_prefix . 'directeur_responsable_ms_msc_badge_cqc'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="responsable_academique" class="box-label"><?php echo __('directeur responsable ms msc badge cqc :', 'cge'); ?></label>
            </th>
            <td><input id="responsable_academique" type="text" name="Formation[responsable_academique]" value="<?php echo isset($data[$this->meta_prefix . 'responsable_academique'][0]) ? $data[$this->meta_prefix . 'responsable_academique'][0] : null; ?>"></td>
        </tr>
    </tbody>
</table>
<br>
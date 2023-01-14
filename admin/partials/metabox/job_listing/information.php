<?php
    global $post;
    $data = get_post_custom($post->ID);
?>

<table class="form-table">
    <tbody>

        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_acronyme" class="box-label"><?php echo __('Acronyme:', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_acronyme" type="text" name="EcoleInformation[_ecole_acronyme]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_acronyme'][0]) ? $data[$this->meta_prefix.'_ecole_acronyme'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_nom" class="box-label"><?php echo __('Nom :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_nom" type="text" name="EcoleInformation[_ecole_nom]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_nom'][0]) ? $data[$this->meta_prefix.'_ecole_nom'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_type_formation" class="box-label"><?php echo __('Type formation :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_type_formation" type="text" name="EcoleInformation[_ecole_type_formation]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_type_formation'][0]) ? $data[$this->meta_prefix.'_ecole_type_formation'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_statut" class="box-label"><?php echo __('Statut :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_statut" type="text" name="EcoleInformation[_ecole_statut]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_statut'][0]) ? $data[$this->meta_prefix.'_ecole_statut'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_annee_creation" class="box-label"><?php echo __('Année de creation :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_annee_creation" type="date" name="EcoleInformation[_ecole_annee_creation]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_annee_creation'][0]) ? $data[$this->meta_prefix.'_ecole_annee_creation'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_type_structure" class="box-label"><?php echo __('Type Structure:', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_type_structure" type="text" name="EcoleInformation[_ecole_type_structure]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_type_structure'][0]) ? $data[$this->meta_prefix.'_ecole_type_structure'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_ministere_tutelle_1" class="box-label"><?php echo __('Ministere de tutelle :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_ministere_tutelle_1" type="text" name="EcoleInformation[_ecole_ministere_tutelle_1]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_ministere_tutelle_1'][0]) ? $data[$this->meta_prefix.'_ecole_ministere_tutelle_1'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_organisme_rattachement" class="box-label"><?php echo __('Organisme de rattachement :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_organisme_rattachement" type="text" name="EcoleInformation[_ecole_organisme_rattachement]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_organisme_rattachement'][0]) ? $data[$this->meta_prefix.'_ecole_organisme_rattachement'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_habilitation_delivrer_doctorat" class="box-label"><?php echo __('Habilitation à delivrer un doctorat :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_habilitation_delivrer_doctorat" type="text" name="EcoleInformation[_ecole_habilitation_delivrer_doctorat]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_habilitation_delivrer_doctorat'][0]) ? $data[$this->meta_prefix.'_ecole_habilitation_delivrer_doctorat'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_prepa_integree" class="box-label"><?php echo __('Prepa integree :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_prepa_integree" type="text" name="EcoleInformation[_ecole_prepa_integree]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_prepa_integree'][0]) ? $data[$this->meta_prefix.'_ecole_prepa_integree'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_type_habilitation" class="box-label"><?php echo __('Type habilitation :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_type_habilitation" type="text" name="EcoleInformation[_ecole_type_habilitation]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_type_habilitation'][0]) ? $data[$this->meta_prefix.'_ecole_type_habilitation'][0] : null;?>" ></td>
        </tr>

    </tbody>
</table>
<br>
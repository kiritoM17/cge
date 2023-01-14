<?php
    global $post;
    $data = get_post_custom($post->ID);
?>

<table class="form-table">
    <tbody>

        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_centres_documentation_horaires" class="box-label"><?php echo __('Horaires :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_centres_documentation_horaires" type="text" name="EcoleInformationDocumentation[_ecole_centres_documentation_horaires]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_centres_documentation_horaires'][0]) ? $data[$this->meta_prefix.'_ecole_centres_documentation_horaires'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_centres_documentation_responsable_civilite" class="box-label"><?php echo __('Civilité :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_centres_documentation_responsable_civilite" type="text" name="EcoleInformationDocumentation[_ecole_centres_documentation_responsable_civilite]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_centres_documentation_responsable_civilite'][0]) ? $data[$this->meta_prefix.'_ecole_centres_documentation_responsable_civilite'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_centres_documentation_responsable_nom" class="box-label"><?php echo __('Nom :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_centres_documentation_responsable_nom" type="text" name="EcoleInformationDocumentation[_ecole_centres_documentation_responsable_nom]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_centres_documentation_responsable_nom'][0]) ? $data[$this->meta_prefix.'_ecole_centres_documentation_responsable_nom'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_centres_documentation_responsable_prenom" class="box-label"><?php echo __('Prenom :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_centres_documentation_responsable_prenom" type="text" name="EcoleInformationDocumentation[_ecole_centres_documentation_responsable_prenom]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_centres_documentation_responsable_prenom'][0]) ? $data[$this->meta_prefix.'_ecole_centres_documentation_responsable_prenom'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_centres_documentation_responsable_telephone" class="box-label"><?php echo __('Téléphone :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_centres_documentation_responsable_telephone" type="text" name="EcoleInformationDocumentation[_ecole_centres_documentation_responsable_telephone]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_centres_documentation_responsable_telephone'][0]) ? $data[$this->meta_prefix.'_ecole_centres_documentation_responsable_telephone'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_centres_documentation_responsable_email" class="box-label"><?php echo __('Email :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_centres_documentation_responsable_email" type="email" name="EcoleInformationDocumentation[_ecole_centres_documentation_responsable_email]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_centres_documentation_responsable_email'][0]) ? $data[$this->meta_prefix.'_ecole_centres_documentation_responsable_email'][0] : null;?>" ></td>
        </tr>
        
    </tbody>
</table>
<br>
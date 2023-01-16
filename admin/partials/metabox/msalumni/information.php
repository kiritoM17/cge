<?php
global $post;
$data = get_post_custom($post->ID);
?>

<table class="form-table">
    <tbody>

        <tr class="form-field">
            <th scope="row">
                <label for="nom" class="box-label"><?php echo __('Nom:', 'cge'); ?></label>
            </th>
            <td><input id="nom" type="text" name="Msalumni[nom]" value="<?php echo isset($data[$this->meta_prefix . 'nom'][0]) ? $data[$this->meta_prefix . 'nom'][0] : null; ?>"></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="prenom" class="box-label"><?php echo __('Prenom :', 'cge'); ?></label>
            </th>
            <td><input id="prenom" type="text" name="Msalumni[prenom]" value="<?php echo isset($data[$this->meta_prefix . 'prenom'][0]) ? $data[$this->meta_prefix . 'prenom'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="civilite" class="box-label"><?php echo __('Civilite :', 'cge'); ?></label>
            </th>
            <td><input id="civilite" type="text" name="Msalumni[civilite]" value="<?php echo isset($data[$this->meta_prefix . 'civilite'][0]) ? $data[$this->meta_prefix . 'civilite'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="ecole" class="box-label"><?php echo __('Ecole :', 'cge'); ?></label>
            </th>
            <td><input id="ecole" type="number" name="Msalumni[ecole]" value="<?php echo isset($data[$this->meta_prefix . 'ecole'][0]) ? $data[$this->meta_prefix . 'ecole'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="formation" class="box-label"><?php echo __('Formation :', 'cge'); ?></label>
            </th>
            <td><input id="formation" type="url" name="Msalumni[formation]" value="<?php echo isset($data[$this->meta_prefix . 'formation'][0]) ? $data[$this->meta_prefix . 'formation'][0] : null; ?>"></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="annee_obtention" class="box-label"><?php echo __('annee obtention :', 'cge'); ?></label>
            </th>
            <td><input id="annee_obtention" type="text" name="Msalumni[annee_obtention]" value="<?php echo isset($data[$this->meta_prefix . 'annee_obtention'][0]) ? $data[$this->meta_prefix . 'annee_obtention'][0] : null; ?>"></td>
        </tr>
    </tbody>
</table>
<br>
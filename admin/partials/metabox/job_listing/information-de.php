<?php
    global $post;
    $data = get_post_custom($post->ID);
?>

<table class="form-table">
    <tbody>

        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_de_civilite" class="box-label"><?php echo __('Civilité :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_de_civilite" type="text" name="EcoleInformationDe[_ecole_de_civilite]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_de_civilite'][0]) ? $data[$this->meta_prefix.'_ecole_de_civilite'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_de_nom" class="box-label"><?php echo __('Nom :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_de_nom" type="text" name="EcoleInformationDe[_ecole_de_nom]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_de_nom'][0]) ? $data[$this->meta_prefix.'_ecole_de_nom'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_ecole_de_prenom" class="box-label"><?php echo __('Prenom :', 'cge'); ?></label>
            </th>
            <td><input id="_ecole_de_prenom" type="text" name="EcoleInformationDe[_ecole_de_prenom]" value="<?php echo isset($data[$this->meta_prefix.'_ecole_de_prenom'][0]) ? $data[$this->meta_prefix.'_ecole_de_prenom'][0] : null;?>" ></td>
        </tr>
        
    </tbody>
</table>
<br>
<?php
global $post;
$data = get_post_custom($post->ID);
?>
<table class="form-table">
    <tbody>
        <tr class="form-field">
            <th scope="row">
                <label for="_cge_membre_organisme" class="box-label"><?php echo __('Type de Membre Organisme:', 'cge'); ?></label>
            </th>
            <td>
                <select id="_cge_membre_organisme" name="Membre[_cge_membre_organisme]">
                    <option value=""> Selectionner l'organisme du membre</option>
                    <option value="association_professeur" <?php echo isset($data[$this->meta_prefix . '_cge_membre_organisme'][0]) && $data[$this->meta_prefix . '_cge_membre_organisme'][0] == 'association_professeur' ? 'selected="selected"' : ""; ?>><?php echo __('Association de professeurs', 'cge'); ?></option>
                    <option value="association_alumni" <?php echo isset($data[$this->meta_prefix . '_cge_membre_organisme'][0]) && $data[$this->meta_prefix . '_cge_membre_organisme'][0] == 'association_alumni' ? 'selected="selected"' : ""; ?>><?php echo __('Association d\'Alumni', 'cge'); ?></option>
                    <option value="association_autre" <?php echo isset($data[$this->meta_prefix . '_cge_membre_organisme'][0]) && $data[$this->meta_prefix . '_cge_membre_organisme'][0] == 'association_autre' ? 'selected="selected"' : ""; ?>><?php echo __('Autres organismes membres', 'cge'); ?></option>
                </select>
            </td>
        </tr>
    </tbody>
</table>
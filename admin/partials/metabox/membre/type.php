<?php
global $post;
$data = get_post_custom($post->ID);
?>
<table class="form-table">
    <tbody>
        <tr class="form-field">
            <th scope="row">
                <label for="_cge_membre_type" class="box-label"><?php echo __('Type de Membre:', 'cge'); ?></label>
            </th>
            <td>
                <select id="_cge_membre_type" type="text" name="Membre[_cge_membre_type]">
                    <option value="entreprise" <?php echo isset($data[$this->meta_prefix . '_cge_membre_type'][0]) && $data[$this->meta_prefix . '_cge_membre_type'][0] == 'entreprise' ? 'selected="selected"' : ""; ?>><?php echo __('Entreprise:', 'cge'); ?></option>
                    <option value="organisme" <?php echo isset($data[$this->meta_prefix . '_cge_membre_type'][0]) && $data[$this->meta_prefix . '_cge_membre_type'][0] == 'organisme' ? 'selected="selected"' : ""; ?>><?php echo __('Organisme:', 'cge'); ?></option>
                </select>
            </td>
        </tr>
    </tbody>
</table>
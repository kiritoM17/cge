<?php
    global $post;
    $data = get_post_custom($post->ID);
?>
<table class="form-table">
    <tbody>
    <tr class="form-field">
            <th scope="row">
                <label for="co_accrediteurs" class="box-label"><?php echo __('Co accrediteurs :', 'cge'); ?></label>
            </th>
            <td><input id="co_accrediteurs" type="text" name="Formation[co_accrediteurs][]" value="<?php echo isset($data[$this->meta_prefix.'co_accrediteurs'][0]) ? $data[$this->meta_prefix.'langues_enseignements'][0] : null;?>" required></td>
        </tr>
    </tbody>
</table>
<?php
    global $post;
    $data = get_post_custom($post->ID);
?>

<table class="form-table">
    <tbody>
        
        <tr class="form-field">
            <th scope="row">
                <label for="_cge_presse_url" class="box-label"><?php echo __('Url :', 'cge'); ?></label>
            </th>
            <td><input id="_cge_presse_url" type="text" name="Presse[_cge_presse_url]" value="<?php echo isset($data[$this->meta_prefix.'_cge_presse_url'][0]) ? $data[$this->meta_prefix.'_cge_presse_url'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="_cge_presse_file_name" class="box-label"><?php echo __('File name :', 'cge'); ?></label>
            </th>
            <td><input id="_cge_presse_file_name" type="text" name="Presse[_cge_presse_file_name]" value="<?php echo isset($data[$this->meta_prefix.'_cge_presse_file_name'][0]) ? $data[$this->meta_prefix.'_cge_presse_file_name'][0] : null;?>" ></td>
        </tr>
        
        <!-- <tr class="form-field">
            <th scope="row">
                <label for="lieu_emplois" class="box-label"><?php echo __('Lieu emplois :', 'cge'); ?></label>
            </th>
            <td><input id="lieu_emplois" type="text" name="Presse[lieu_emplois]" value="<?php echo isset($data[$this->meta_prefix.'lieu_emplois'][0]) ? $data[$this->meta_prefix.'lieu_emplois'][0] : null;?>" ></td>
        </tr>
        
        <tr class="form-field">
            <th scope="row">
                <label for="document_emplois" class="box-label"><?php //echo __('Document emplois :', 'cge'); ?></label>
            </th>
            <td><input id="document_emplois" type="number" name="Presse[document_emplois]" value="<?php //echo isset($data[$this->meta_prefix.'document_emplois'][0]) ? $data[$this->meta_prefix.'document_emplois'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="date_debut_emplois" class="box-label"><?php //echo __('Date de debut emplois :', 'cge'); ?></label>
            </th>
            <td><input id="date_debut_emplois" type="url" name="Presse[date_debut_emplois]" value="<?php //echo isset($data[$this->meta_prefix.'date_debut_emplois'][0]) ? $data[$this->meta_prefix.'date_debut_emplois'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="date_depot_emplois" class="box-label"><?php //echo __('Date de depot emplois :', 'cge'); ?></label>
            </th>
            <td><input id="date_depot_emplois" type="text" name="Presse[date_depot_emplois]" value="<?php //echo isset($data[$this->meta_prefix.'date_depot_emplois'][0]) ? $data[$this->meta_prefix.'date_depot_emplois'][0] : null;?>" ></td>
        </tr> -->
    </tbody>
</table>
<br>
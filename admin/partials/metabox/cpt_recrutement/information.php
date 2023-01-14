<?php
    global $post;
    $data = get_post_custom($post->ID);
?>

<table class="form-table">
    <tbody>
        
        <tr class="form-field">
            <th scope="row">
                <label for="demandeur_emplois" class="box-label"><?php echo __('Demandeur emplois :', 'cge'); ?></label>
            </th>
            <td><input id="demandeur_emplois" type="text" name="Recrutement[demandeur_emplois]" value="<?php echo isset($data[$this->meta_prefix.'demandeur_emplois'][0]) ? $data[$this->meta_prefix.'demandeur_emplois'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="poste_propose_emplois" class="box-label"><?php echo __('Poste propose emplois :', 'cge'); ?></label>
            </th>
            <td><input id="poste_propose_emplois" type="text" name="Recrutement[poste_propose_emplois]" value="<?php echo isset($data[$this->meta_prefix.'poste_propose_emplois'][0]) ? $data[$this->meta_prefix.'poste_propose_emplois'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="lieu_emplois" class="box-label"><?php echo __('Lieu emplois :', 'cge'); ?></label>
            </th>
            <td><input id="lieu_emplois" type="text" name="Recrutement[lieu_emplois]" value="<?php echo isset($data[$this->meta_prefix.'lieu_emplois'][0]) ? $data[$this->meta_prefix.'lieu_emplois'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="document_emplois" class="box-label"><?php echo __('Document emplois :', 'cge'); ?></label>
            </th>
            <td><input id="document_emplois" type="text" name="Recrutement[document_emplois]" value="<?php echo isset($data[$this->meta_prefix.'document_emplois'][0]) ? $data[$this->meta_prefix.'document_emplois'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="date_debut_emplois" class="box-label"><?php echo __('Date de debut emplois :', 'cge'); ?></label>
            </th>
            <td><input id="date_debut_emplois" type="date" name="Recrutement[date_debut_emplois]" value="<?php echo isset($data[$this->meta_prefix.'date_debut_emplois'][0]) ? $data[$this->meta_prefix.'date_debut_emplois'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="date_depot_emplois" class="box-label"><?php echo __('Date de depot emplois :', 'cge'); ?></label>
            </th>
            <td><input id="date_depot_emplois" type="text" name="Recrutement[date_depot_emplois]" value="<?php echo isset($data[$this->meta_prefix.'date_depot_emplois'][0]) ? $data[$this->meta_prefix.'date_depot_emplois'][0] : null;?>" ></td>
        </tr>
    </tbody>
</table>
<br>
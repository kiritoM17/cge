<?php
    global $post;
    $data = get_post_custom($post->ID);
?>

<table class="form-table">
    <tbody>
        
        <tr class="form-field">
            <th scope="row">
                <label for="_cge_publication_url" class="box-label"><?php echo __('Url :', 'cge'); ?></label>
            </th>
            <td><input id="_cge_publication_url" type="text" name="Publication[_cge_publication_url]" value="<?php echo isset($data[$this->meta_prefix.'_cge_publication_url'][0]) ? $data[$this->meta_prefix.'_cge_publication_url'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="_cge_publication_date" class="box-label"><?php echo __('Date :', 'cge'); ?></label>
            </th>
            <td><input id="_cge_publication_date" type="date" name="Publication[_cge_publication_date]" value="<?php echo isset($data[$this->meta_prefix.'_cge_publication_date'][0]) ? $data[$this->meta_prefix.'_cge_publication_date'][0] : null;?>" ></td>
        </tr>
        
    </tbody>
</table>
<br>
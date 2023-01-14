<?php
    global $post;
    $data = get_post_custom($post->ID);
?>

<table class="form-table">
    <tbody>

        <tr class="form-field">
            <th scope="row">
                <label for="_job_location" class="box-label"><?php echo __('Location:', 'cge'); ?></label>
            </th>
            <td><input id="_job_location" type="text" name="EcoleInformationContact[_job_location]" value="<?php echo isset($data[$this->meta_prefix.'_job_location'][0]) ? $data[$this->meta_prefix.'_job_location'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="_job_hours" class="box-label"><?php echo __('Hours :', 'cge'); ?></label>
            </th>
            <td><input id="_job_hours" type="text" name="EcoleInformationContact[_job_hours]" value="<?php echo isset($data[$this->meta_prefix.'_job_hours'][0]) ? $data[$this->meta_prefix.'_job_hours'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="_company_website" class="box-label"><?php echo __('Website :', 'cge'); ?></label>
            </th>
            <td><input id="_company_website" type="url" name="EcoleInformationContact[_company_website]" value="<?php echo isset($data[$this->meta_prefix.'_company_website'][0]) ? $data[$this->meta_prefix.'_company_website'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="geolocation_formatted_address" class="box-label"><?php echo __('Adress :', 'cge'); ?></label>
            </th>
            <td><input id="geolocation_formatted_address" type="text" name="EcoleInformationContact[geolocation_formatted_address]" value="<?php echo isset($data[$this->meta_prefix.'geolocation_formatted_address'][0]) ? $data[$this->meta_prefix.'geolocation_formatted_address'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="geolocation_city" class="box-label"><?php echo __('City :', 'cge'); ?></label>
            </th>
            <td><input id="geolocation_city" type="text" name="EcoleInformationContact[geolocation_city]" value="<?php echo isset($data[$this->meta_prefix.'geolocation_city'][0]) ? $data[$this->meta_prefix.'geolocation_city'][0] : null;?>" ></td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="geolocation_state_long" class="box-label"><?php echo __('State :', 'cge'); ?></label>
            </th>
            <td><input id="geolocation_state_long" type="text" name="EcoleInformationContact[geolocation_state_long]" value="<?php echo isset($data[$this->meta_prefix.'geolocation_state_long'][0]) ? $data[$this->meta_prefix.'geolocation_state_long'][0] : null;?>" ></td>
        </tr>
        <tr class="form-field">
            <th scope="row">
                <label for="geolocation_country_long" class="box-label"><?php echo __('Country :', 'cge'); ?></label>
            </th>
            <td><input id="geolocation_country_long" type="text" name="EcoleInformationContact[geolocation_country_long]" value="<?php echo isset($data[$this->meta_prefix.'geolocation_country_long'][0]) ? $data[$this->meta_prefix.'geolocation_country_long'][0] : null;?>" ></td>
        </tr>
    </tbody>
</table>
<br>
<?php
global $post;
$data = get_post_custom($post->ID);
?>

<table>
    <tbody>
        <tr>
            <td>
                <table class="form-table">
                    <?php
                    $dataCoAccrediteurs = (isset($data[$this->meta_prefix . '_ecole_resp_formation']) && strlen($data[$this->meta_prefix . '_ecole_resp_formation'][0]) > 0) ? explode('##', $data[$this->meta_prefix . '_ecole_resp_formation'][0]) : [];
                    foreach ($dataCoAccrediteurs as $co) {
                        if (strlen(trim($co)) > 0) {
                    ?>
                            <tbody>
                                <tr>
                                    <td>
                                        <?php echo '<label>' . __('Responsable Formation :', 'cge') . '</label><br>' ?>
                                        <?php echo '<input type="text" name="EcoleInformationFormation[_ecole_resp_formation][]" value="' . $co . '" placeholder="' . __('Co Accrediteurs', 'cge') . '">' ?>
                                    </td>
                                    <td><a class="remove_ecole_resp_formation dashicons dashicons-trash" href="#" onclick="return false;"></a> </td>
                                </tr>
                            </tbody>
                    <?php }
                    }
                    ?>
                </table>
                <table class="form-table" id="from_ecole_resp_formation">
                </table>
                <table class="hidden" id="add_ecole_resp_formation">
                    <tr>
                        <td>
                            <?php echo '<label>' . __('Responsable Formation :', 'cge') . '</label><br>' ?>
                            <div class="tarrif-input">
                                <?php echo '<input type="text" name="EcoleInformationFormation[_ecole_resp_formation][]" value="" placeholder="' . __('Co accrediteur', 'cge') . '">' ?>
                            </div>
                        </td>
                        <td><a class="remove_ecole_resp_formation dashicons dashicons-trash" href="#" onclick="return false;"></a> </td>
                    </tr>
                </table>
            </td>
        </tr>
    </tbody>

    <tfoot>
        <tr>
            <td colspan="5">
                <br>
                <button type="button" id="btn_add_tarif" class="button">
                    <span class="dashicons dashicons-money-alt"></span><?php echo __(' New Responsable Formation', 'cge'); ?>
                </button>
            </td>
        </tr>
    </tfoot>
</table>
<br>
<!-- end tarif meta box -->
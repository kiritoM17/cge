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
                $dataCoAccrediteurs = ( isset($data[$this->meta_prefix . '_ecole_accords_internationaux_']) && strlen($data[$this->meta_prefix . '_ecole_accords_internationaux_'][0]) > 0 ) ? unserialize($data[$this->meta_prefix . '_ecole_accords_internationaux_'][0]) : [];
                foreach ($dataCoAccrediteurs as $co) {
                    ?>
                    <tbody>
                    <tr>
                        <td>
                            <?php echo '<label>' . __('Accords Internationaux :', 'cge') . '</label><br>' ?>
                            <?php echo '<input type="text" name="EcoleInformationAccords[_ecole_accords_internationaux_][]" value="' . $co . '" placeholder="' . __('Co Accrediteurs', 'cge') . '">' ?>
                        </td>
                        <td><a class="remove_ecole_accords_internationaux_ dashicons dashicons-trash" href="#" onclick="return false;"></a> </td>
                    </tr>
                    </tbody>
                <?php }
                ?>
            </table>
            <table class="form-table" id="from_ecole_accords_internationaux_">
            </table>
            <table class="hidden" id="add_ecole_accords_internationaux_">
                <tr>
                    <td>
                        <?php echo '<label>' . __('Accords Internationaux  :', 'cge') . '</label><br>' ?>
                        <div class="tarrif-input">
                            <?php echo '<input type="text" name="EcoleInformationAccords[_ecole_accords_internationaux_][]" value="" placeholder="' . __('Co accrediteur', 'cge') . '">' ?>
                        </div>
                    </td>
                    <td><a class="remove_ecole_accords_internationaux_ dashicons dashicons-trash" href="#" onclick="return false;"></a> </td>
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
                <span class="dashicons dashicons-money-alt"></span><?php echo __(' New Accords ', 'cge'); ?>
            </button>
        </td>
    </tr>
    </tfoot>
</table>
<br>
<!-- end tarif meta box -->
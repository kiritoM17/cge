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
                $dataCoAccrediteurs = ( isset($data[$this->meta_prefix . 'co_accrediteurs']) && strlen($data[$this->meta_prefix . 'co_accrediteurs'][0]) > 0 ) ? unserialize($data[$this->meta_prefix . 'co_accrediteurs'][0]) : [];
                foreach ($dataCoAccrediteurs as $co) {
                    ?>
                    <tbody>
                    <tr>
                        <td>
                            <?php echo '<label>' . __('Co accrediteur :', 'cge') . '</label><br>' ?>
                            <?php echo '<input type="text" name="Formation[co_accrediteurs][]" value="' . $co . '" placeholder="' . __('Co Accrediteurs', 'cge') . '">' ?>
                        </td>
                        <td><a class="remove_co_accrediteurs dashicons dashicons-trash" href="#" onclick="return false;"></a> </td>
                    </tr>
                    </tbody>
                <?php }
                ?>
            </table>
            <table class="form-table" id="from_co_accrediteurs">
            </table>
            <table class="hidden" id="add_co_accrediteurs">
                <tr>
                    <td>
                        <?php echo '<label>' . __('Co accrediteur :', 'cge') . '</label><br>' ?>
                        <div class="tarrif-input">
                            <?php echo '<input type="text" name="Formation[co_accrediteurs][]" value="" placeholder="' . __('Co accrediteur', 'cge') . '">' ?>
                        </div>
                    </td>
                    <td><a class="remove_co_accrediteurs dashicons dashicons-trash" href="#" onclick="return false;"></a> </td>
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
                <span class="dashicons dashicons-money-alt"></span><?php echo __(' New co accrediteur', 'cge'); ?>
            </button>
        </td>
    </tr>
    </tfoot>
</table>
<br>
<!-- end tarif meta box -->
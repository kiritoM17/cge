<?php
    $cgeToken = get_option("_CGE_CLIENT_ACCESS_TOKEN");
    $cgeUsername = get_option("_CGE_CLIENT_USERNAME");
    $cgePassword = get_option("_CGE_CLIENT_PWD");
    $error_message = isset($_GET['cge_error_message']) && !empty($_GET['cge_error_message']) ? $_GET['cge_error_message'] : '';
?>

<div id="cge-settings-block" class="cge-content-block">
    <h1 class="cge-title">
        <!-- <img src="<?php //echo CGE_ADMIN_IMG . 'icon-settings-bleu.svg'; ?>" alt="" /> -->
        Login to API
    </h1>
    <form method="post" action="options.php" autocomplete="off" style="width: 50%;">
        <div class="form-section">
            <div class="section-one-block">
                <?php if(isset($error_message) && $error_message == 1){?>
                    <div style="text-align:center; color: red; font-weigth:500;">
                        <?= $error_message ?>
                    </div>
                <?php }?>
                <div class="modal-input-group">
                    <label for="cge-username" class="modal-form-label">Nom</label>
                    <input type="text" name="cge-username" id="cge-username" class="modal-form-control form-control" value="<?php echo (isset($cgeUsername) && $cgeUsername != '') ? $cgeUsername : ''; ?>">
                </div>
                <div class="modal-input-group">
                    <label for="cge-password" class="modal-form-label">URL DE RATTACHEMENT</label>
                    <input name="cge-password" id="cge-password" type="password" class="modal-form-control form-control" value="<?php echo (isset($cgePassword) && $cgePassword != '') ? $cgePassword : ''; ?>">
                </div>
                <div class="modal-footer-form" style="margin:20px 0px 20px 0px;">
                    <?php if(isset($cgeToken) && $cgeToken != ''){?>
                        <button type="button" class="btn btn-modal-close" id="btn-modal-close">Se déconnecter</button>
                    <?php }?>
                    <?php if(!(isset($cgeToken) && $cgeToken != '')){?>
                        <button  type="submit" class="btn btn-modal-submit" id="login-to-api" data-id="" >Se connecter</button>
                    <?php }?>
                </div>
            </div>
        </div>
    </form>
</div>
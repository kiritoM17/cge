<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://http://gdt-core.com
 * @since      1.0.0
 *
 * @package    Cge
 * @subpackage Cge/admin/partials
 */
    $currentPage = isset($_GET['emaffp_menu']) ? $_GET['emaffp_menu'] : 'settings';
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="cge-adminzone">
    <div id="cge-adminmenu">
        <h1>
            CGE Manager
        </h1>
        <div class="multimaff-adminmenu-item">
            <a href="?page=cge-admin-menu&emaffp_menu=settings" class="active">Paramètre</a>
        </div>
    </div>
    <div id="cge-admincontent">
        <?php 
            if (file_exists(CGE_ADMIN_VIEWS . 'cge-admin-view-' . $currentPage . '.php')) {
                include_once CGE_ADMIN_VIEWS . 'cge-admin-view-' . $currentPage . '.php';
            }
        ?>
    </div>
</div>
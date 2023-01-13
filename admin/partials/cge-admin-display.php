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
//page=cge-admin-menu
    $currentPage = isset($_GET['page']) ? $_GET['page'] : 'cge-admin-menu';
    $currentMenu = isset($_GET['cge_menu']) ? $_GET['cge_menu'] : 'settings';
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="cge-adminzone">
    <div id="cge-adminmenu">
        <h1>
            CGE Settings
        </h1>
        <div class="multimaff-adminmenu-item">
            <a href="?post_type=msalumni&page=cge-admin-menu&cge_menu=settings" class="active">Login to API</a>
        </div>
    </div>
    <div id="cge-admincontent">
        <?php 
            if (file_exists(CGE_ADMIN_VIEWS . 'cge-admin-view-' . $currentMenu . '.php')) {
                include_once CGE_ADMIN_VIEWS . 'cge-admin-view-' . $currentMenu . '.php';
            }
        ?>
    </div>
</div>
<?php 
    $cron_path = str_replace('\\','/',CGE_ADMIN_CRONS) . 'class-cge-cron-';
    $cron_path_url = CGE_ADMIN_CRONS_URL . 'class-cge-cron-';
?>
<div id="cge-settings-block" class="cge-content-block">
    <h1 class="cge-title">
        Liste des crons d'import de donées
    </h1>
    <section>
        <p><strong>Access Token</strong> <code><?= $cron_path . 'access-token.php'?></code><a href="<?= $cron_path_url . 'access-token.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
        <p><small style="color: red; font-weight: 500">la cron Access Token doit être exécuter après 58min</small></p>
        <p><strong>Formations Labellisées</strong> <code><?= $cron_path . 'cpt-formation.php'?></code> <a href="<?= $cron_path_url . 'cpt-formation.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
        <p><strong>Étudiants  Alumni</strong> <code><?= $cron_path . 'msalumni.php'?></code> <a href="<?= $cron_path_url . 'msalumni.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
        <p><strong>Membres Écoles</strong> <code><?= $cron_path . 'job-listing.php'?></code> <a href="<?= $cron_path_url . 'job-listing.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
        <p><strong>Entreprises Membres</strong> <code><?= $cron_path . 'membre-entreprise.php'?></code> <a href="<?= $cron_path_url . 'membre-entreprise.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
        <p><strong>Organismes Membres</strong> <code><?= $cron_path . 'membre-organisme.php'?></code> <a href="<?= $cron_path_url . 'membre-organisme.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
        <p><strong>Offres d'emploi</strong> <code><?= $cron_path . 'cpt-recrutement.php'?></code> <a href="<?= $cron_path_url . 'cpt-recrutement.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
        <p><strong>Publications</strong> <code><?= $cron_path . 'cpt-publication.php'?></code> <a href="<?= $cron_path_url . 'cpt-publication.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
        <p><strong>Communiqués de presse</strong> <code><?= $cron_path . 'cpt-presse.php'?></code> <a href="<?= $cron_path_url . 'cpt-presse.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
        <p><strong>Évènements</strong> <code><?= $cron_path . 'ajde-event.php'?></code> <a href="<?= $cron_path_url . 'ajde-event.php'?>" class="btn" target="_blanc" style="color:#fff; padding : 5px;"><span class="dashicons dashicons-welcome-view-site"></span></a></p>
    </section>
</div>
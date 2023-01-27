<?php
    $sc_debut = '[cge_';
    $sc_fin = ']';
?>
<style>
    .sc_note_section small{
        color: red;
        font-weight: 500;
        margin: 0 0 0 15px;
    }
</style>
<div id="cge-settings-block" class="cge-content-block">
    <h1 class="cge-title">
        Liste des Shortcodes
    </h1>
    <section class="sc_note_section">
        <p><strong>Formations Labellisées</strong> <code><?= $sc_debut . 'formation' . $sc_fin?></code> <small>affiche le listing des formations labellisées</small></p>
        <p><strong>Étudiants  Alumni</strong> <code><?= $sc_debut . 'student' . $sc_fin?></code><small>affiche le listing des étudiants ALUMI</small></p>
        <p><strong>Membres Écoles</strong> <code><?= $sc_debut . 'ecole' . $sc_fin?></code><small>affiche le listing des école membres</small></p>
        <p><strong>Entreprises Membres</strong> <code><?= $sc_debut . 'membre type="entreprise"' . $sc_fin?></code><small>affiche le listing des membres entreprises</small></p>
        <p><strong>Organismes Membres</strong> <code><?= $sc_debut . 'membre type="organisme"' . $sc_fin?></code><small>affiche le listing des membres organisme</small></p>
        <p><strong>Offres d'emploi</strong> <code><?= $sc_debut . 'recrutement' . $sc_fin?></code><small>affiche le listing des offres d'emploie</small></p>
        <p><strong>Publications</strong> <code><?= $sc_debut . 'publication' . $sc_fin?></code><small>affiche le listing des publications</small></p>
        <p><strong>Communiqués de presse</strong> <code><?= $sc_debut . 'presse' . $sc_fin?></code><small>affiche le listing des communiqués de presse</small></p>
    </section>
</div>
<?php
switch ($vd->getSottoPagina()) {
    case 'dati_personali':
        include 'dati_personali.php';
        break;
    
    case 'reg_tornei':
        include 'reg_tornei.php';
        break;
    
    case 'reg_tornei_step1':
        include 'reg_tornei_step1.php';
        break;
    
    case 'reg_tornei_step2':
        include 'reg_tornei_step2.php';
        break;
    
    case 'reg_tornei_step3':
        include 'reg_tornei_step3.php';
        break;

    case 'tornei':
        include 'tornei.php';
        break;
            
    case 'torneo_dettagli':
        include 'torneo_dettagli.php';
        break;
    
    case 'calendario':
        include 'calendario.php';
        break;
    
    case 'risultato':
        include 'risultato.php';
        break;
    
    default: ?>
        <h2 class="icon-title" id="h-home">Pannello di Controllo</h2>
        <p>
            Benvenuto/a <?= $user->getNome() ?>!
        </p>
        <p>
            Scegli una fra le seguenti sezioni:
        </p>
        <ul class="panel">
            <li><a href="organizzatore/dati_personali<?= $vd->scriviToken('?')?>" id="pnl-dati_personali">Dati personali</a></li>
            <li><a href="organizzatore/reg_tornei<?= $vd->scriviToken('?')?>" id="pnl-registrazione">Crea Torneo</a></li>
            <li><a href="organizzatore/tornei<?= $vd->scriviToken('?')?>" id="pnl-tornei">Miei Tornei</a></li>
        </ul>
        <?php
        break;
}
?>



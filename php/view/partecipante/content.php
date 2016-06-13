<?php
switch ($vd->getSottoPagina()) {
    case 'dati_personali':
        include 'dati_personali.php';
        break;
    
    case 'iscrizione':
        include 'iscrizione.php';
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
    
    case 'el_tornei':
        include 'el_tornei.php';
        break;
    
    case 'el_tornei_json':
        include 'el_tornei_json.php';
        break;    
    
    default: ?>
        <h2 class="icon-title" id="h-home">Pannello di Controllo</h2>
        <p>
            Benvenuto/a <?= $user->getNome() ?>
        </p>
        <p>
            Scegli una fra le seguenti sezioni:
        </p>
        <ul class="panel">
            <li><a href="partecipante/dati_personali<?= $vd->scriviToken('?')?>" id="pnl-dati_personali">
                    Dati personali
                </a>
            </li>
            <li><a href="partecipante/tornei<?= $vd->scriviToken('?')?>" id="pnl-tornei"> Miei Tornei</a></li>
            <li><a href="partecipante/el_tornei<?= $vd->scriviToken('?')?>" id="pnl-elenco_tornei"> Elenco Tornei</a></li>
        </ul>
        <?php
        break;
}
?>
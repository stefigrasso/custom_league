<h2 class="icon-title" id="h-dettagli">Dettaglio torneo</h2>
<div class="input-form">
    <h3> <?= $torneo->getNome() ?> </h3>
    <ul class="none">
        <li><strong>Organizzatore: </strong> <?= $organizzatore ?></li>
        <li><strong>Data inizio: </strong> <?= $torneo->getDataInizio()->format('d/m/Y') ?></li>
        <li><strong>Luogo: </strong> <?= $torneo->getLuogo() ?></li>
        <li><strong>Indirizzo: </strong> <?= $torneo->getIndirizzo() ?></li>
        <li><strong>Disciplina: </strong> <?= $torneo->getDisciplina() ?></li>
        <li><strong>Tipologia: </strong> <?= $torneo->getTipologia() ?></li>
        <li><strong>Iscritti [min/max]: </strong> <?= $torneo->getNumIscritti() ?> [<?= $torneo->getMinPartecipanti() ?>/<?= $torneo->getMaxPartecipanti() ?>]</li>
        <li><strong>Posti disponibili: </strong> <?= $torneo->getPostiDisponibili() ?></li>
    </ul>
    <h4>Iscritti al torneo:</h4>
    <ol>
        <?php
        if (count($torneo->getIscritti()) > 0) {
            foreach ($torneo->getIscritti() as $utente) {
                ?>
                <li><?= $utente->getNome() ?> <?= $utente->getCognome() ?></li>
                <?php
            }
        } else { ?>
                <p>Nessun iscritto</p>
        <?php
        }
        ?>
    </ol>
    <form method="get" action="organizzatore/tornei<?= $vd->scriviToken('?')?>">
        <button type="submit" name="cmd" value="torneo_annulla">Chiudi</button>
    </form>
</div>
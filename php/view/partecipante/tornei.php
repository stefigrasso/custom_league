<h2 class="icon-title" id="h-tornei">Tornei a cui sei iscritto</h2>
<?php
if (count($tornei) > 0) {
    $i = 0;
    foreach ($tornei as $torneo) {
        if ($i == 0) { ?>
            <table>
                <thead>
                    <tr>
                        <th class="table-col">Data Inizio</th>
                        <th class="table-col">Nome</th>
                        <th class="table-col">Disciplina</th>
                        <th class="table-col">Tipologia</th>
                        <th class="table-col">Edit</th>
                    </tr>
                </thead>
                <tbody>
        <?php
        } ?>
                    <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                        <td><?= $torneo->getDataInizio()->format('d/m/Y') ?></td>
                        <td><?= $torneo->getNome() ?></td>
                        <td><?= $torneo->getDisciplina() ?></td>
                        <td><?= $torneo->getTipologia() ?></td>
                        <td>
                            <a href="partecipante/torneo_dettagli?torneo=<?= $torneo->getId() ?><?= $vd->scriviToken('&') ?>" title="Dettagli sul torneo">
                                <img  src="../images/zoom.png" alt="Dettagli">
                            </a>
                            <?php if (count($torneo->getRisultati()) > 0) { ?>
                            <a href="partecipante/calendario?torneo=<?= $torneo->getId() ?><?= $vd->scriviToken('&') ?>" title="Vedi calendario e risultati">
                                <img  src="../images/calendar.png" alt="Calendario"></a>
                            <?php } else { ?>
                            <a href="partecipante/tornei?cmd=iscrizione_cancella&amp;torneo=<?= $torneo->getId() ?><?= $vd->scriviToken('&') ?>" title="Cancella la tua iscrizione">
                                <img  src="../images/trash.png" alt="Elimina">
                            </a>
                            <?php } ?>
                        </td>
                    </tr>
        <?php
        $i++;
    } ?>
                </tbody>
            </table>
<?php
} else { ?>
    <p>Nessuna iscrizione ad un torneo</p>
<?php
} ?>

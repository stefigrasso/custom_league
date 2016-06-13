<h2 class="icon-title" id="h-tornei">Tornei inseriti</h2>
<?php if (count($tornei) > 0) { ?>
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
            $i = 0;
            foreach ($tornei as $torneo) {
                ?>
                <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                    <td><?= $torneo->getDataInizio()->format('d/m/Y')?></td>
                    <td><?= $torneo->getNome() ?></td>
                    <td><?= $torneo->getDisciplina() ?></td>
                    <td><?= $torneo->getTipologia() ?></td>
                    <td>
                        <a href="organizzatore/torneo_dettagli?torneo=<?= $torneo->getId() ?><?= $vd->scriviToken('&') ?>" title="Dettagli sul torneo">
                            <img  src="../images/zoom.png" alt="Dettagli">
                        </a>
                        <?php if (count($torneo->getRisultati()) > 0) { ?>
                        <a href="organizzatore/calendario?torneo=<?= $torneo->getId() ?><?= $vd->scriviToken('&') ?>" title="Vedi calendario e risultati">
                            <img  src="../images/calendar.png" alt="Calendario"></a>
                        <?php } else { ?>
                        <a href="organizzatore/tornei?cmd=calendario_genera&amp;torneo=<?= $torneo->getId() ?><?= $vd->scriviToken('&') ?>" title="Genera il calendario del torneo">
                            <img  src="../images/calendar-add.png" alt="Genera"></a>
                        <?php } ?>
                        <a href="organizzatore/tornei?cmd=torneo_cancella&amp;torneo=<?= $torneo->getId() ?><?= $vd->scriviToken('&') ?>" title="Elimina il torneo">
                            <img  src="../images/trash.png" alt="Elimina"></a>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
<?php } else { ?>
    <p>Nessun torneo inserito</p>
<?php } ?>
<div class="input-form">
    <form method="post" action="organizzatore/reg_tornei<?= $vd->scriviToken('?') ?>">
        <button type="submit"name="cmd" value="torneo_crea">Crea Torneo</button>
    </form>
</div>


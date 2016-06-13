<h2 class="icon-title" id="h-calendario">Calendario e Risultati</h2>

<h3 class="none"><?= $torneo->getNome() ?></h3>
<?php
if (count($risultati) > 0) {
    $i = 0;
    foreach ($risultati as $risultato) { 
        if ($i == 0) { ?>
        <table>
            <thead>
                <tr>
                    <th class="table-col">Giornata</th>
                    <th class="table-col">Partecipante <br>A<br/></th>
                    <th class="table-col">Partecipante <br>B<br/></th>
                    <th class="table-col">Punteggio <br>A - B<br/></th>
                    <th class="table-col">Modifica</th>
                </tr>
            </thead>
        <?php
        } ?>
            <tbody>
                <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                    <td><?= $risultato->getGiornata() ?></td>
                    <?php
                    foreach ($iscritti as $iscritto) {
                        if ($iscritto->getId() == $risultato->getPartecipanteAId()) { ?>
                            <td><?= $iscritto->getNome(); ?></td>
                        <?php
                        }
                    } ?>
                    <?php
                    foreach ($iscritti as $iscritto) {
                       if ($iscritto->getId() == $risultato->getPartecipanteBId()) { ?>
                            <td><?= $iscritto->getNome(); ?></td>
                        <?php
                        }
                    } ?>
                    <td><?= $risultato->getPunteggioA() ?> - <?= $risultato->getPunteggioB() ?></td>
                    <td>
                        <a href="organizzatore/risultato?risultato=<?= $risultato->getId() ?><?= $vd->scriviToken('&') ?>" title="Modifica il risultato">
                            <img  src="../images/edit.png" alt="Modifica">
                        </a>
                    </td>
                </tr>
                <?php
                $i++;
    } ?>
            </tbody>
        </table>
<?php
} else { ?>
    <p>Nessun calendario inserito</p>
<?php
} ?>
<div class="input-form">
    <form method="get" action="organizzatore/tornei<?= $vd->scriviToken('?')?>">
        <button type="submit" name="cmd" value="calendario_annulla">Chiudi</button>
    </form>
</div>


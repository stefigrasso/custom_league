<div>
    <h2 class="icon-title" id="h-registrazione">Registrazione Tornei</h2>
    <p>
        <strong>Organizzatore:</strong> <?= $user->getNome() ?> <?= $user->getCognome() ?>
    </p>
    <p>
        <strong> Luogo e Indirizzo: </strong> <?= $sel_luogo ?>, <?= $sel_indirizzo ?>
    </p>
    <p>
        <strong> Disciplina e Tipologia: </strong> <?= $sel_disciplina ?>, <?= $sel_tipologia ?>
    </p>
    <p>
        <strong> Partecipanti: </strong> min: <?= $sel_min_partecipanti ?>, max: <?= $sel_max_partecipanti ?>
    </p>
</div>
<div class="input-form">
    <form action="organizzatore/reg_tornei_step1?elenco=<?= $elenco_id ?><?= $vd->scriviToken('&')?>" method="get">
        <input type="submit" name="r_modifica" value="Modifica"/>
    </form>
</div>
<div class="input-form">
    <h3>Passo 3: Data inizio e Nome</h3>
    <h4>Nuovo Torneo</h4>
    <form method="post" action="organizzatore/reg_tornei_step3?&amp;elenco=<?= $elenco_id ?><?= $vd->scriviToken('&')?>">
        <label for="data_inizio">Data Inizio (g/m/aaaa)</label>
        <input type="text" name="data_inizio" id="data_inizio"/>
        <br/>
        <label for="nome">Nome Torneo</label>
        <input type="text" name="nome" id="nome"/>
        <br/>
        <button type="submit" name="cmd" value="r_add_torneo">Aggiungi</button>
    </form>
</div>
<div class="input-form">
    <form method="get" action="organizzatore/reg_tornei">
        <?= $vd->scriviToken('', ViewDescriptor::post)?>
        <button type="submit" name="cmd" value="r_indietro">Indietro</button>
    </form>
</div>

<h3>Elenco Tornei</h3>
<?php
if (count($sel_tornei) == 0) {
    ?>
    <p>
        <strong>
            Nessuno torneo inserito
        </strong>
    </p>
    <?php
} else {
    ?>
    <table>
        <thead>
            <tr>
                <th class="table-col">DataInizio</th>
                <th class="table-col">Nome</th>
                <th class="table-col">Disciplina</th>
                <th class="table-col">Tipologia</th>
                <th class="table-col">Cancella</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $i = 0;
            foreach ($sel_tornei as $torneo) {
                ?>
                <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                    <td><?= $torneo->getDataInizio()->format('d/m/Y') ?></td>
                    <td><?= $torneo->getNome() ?></td>
                    <td><?= $torneo->getDisciplina() ?></td>
                    <td><?= $torneo->getTipologia() ?></td>
                    <td>
                        <a href="organizzatore/reg_tornei_step3?elenco=<?= $elenco_id ?>&index=<?= $i ?>&cmd=r_del_torneo<?= $vd->scriviToken('&')?>" title="Elimina il torneo dall'elenco">
                            <img  src="../images/trash.png" alt="Elimina">
                        </a>
                    </td>
                </tr>
                <?php
                $i++;
            }
            ?>
        </tbody>
    </table>
    <form method="get" action="organizzatore/reg_tornei_step3">
        <?= $vd->scriviToken('', ViewDescriptor::post)?>
        <input type="hidden" name="elenco" value="<?= $elenco_id ?>"/>
        <div class="btn-group">
            <button type="submit" name="cmd" value="r_salva_elenco">Registra Elenco</button>
        </div>
    </form>
    <?php
}
?>


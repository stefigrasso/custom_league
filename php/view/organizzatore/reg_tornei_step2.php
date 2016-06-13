<div>
    <h2 class="icon-title" id="h-registrazione">Registrazione Tornei</h2>
    <p>
        <strong>Organizzatore:</strong> <?= $user->getNome() ?> <?= $user->getCognome() ?>
    </p>
    <p>
    <strong> Luogo e Indirizzo: </strong> <?= $sel_luogo ?>, <?= $sel_indirizzo ?>
    </p>
</div>
<div class="input-form">
    <h3>Passo 2: Selezione Tipologia</h3>
    <form method="post" action="organizzatore/reg_tornei_step3?elenco=<?= $elenco_id ?><?= $vd->scriviToken('&')?>">
        <label for="disciplina">Disciplina</label>
        <input type="text" name="disciplina" id="disciplina"
               <?= isset($sel_disciplina) ? 'value="'.$sel_disciplina.'"' : '' ?>/>
        <br/>
        <label for="tipologia">Tipologia</label>
        <select name="tipologia" id="tipologia">
            <?php foreach ($tipologie as $tipologia) {
                if (isset($sel_tipologia) && ($sel_tipologia == $tipologia)) { ?>
                    <option value="<?= $sel_tipologia ?>" selected=‘selected’> <?= $sel_tipologia ?></option>
                <?php } else { ?>
                    <option value="<?= $tipologia ?>"> <?= $tipologia ?></option>
                <?php }
            } ?>
        </select>
        <label for="min_partecipanti">Min partecipanti (min 2)</label>
        <input type="text" name="min_partecipanti" id="min_partecipanti"
               <?= isset($sel_min_partecipanti) ? 'value="'.$sel_min_partecipanti.'"' : '' ?>/>
        <br/>
        <label for="max_partecipanti">Max partecipanti</label>
        <input type="text" name="max_partecipanti" id="max_partecipanti"
               <?= isset($sel_max_partecipanti) ? 'value="'.$sel_max_partecipanti.'"' : '' ?>/>
        <br/>
        <button type="submit" name="cmd" value="r_sel_tipologia">Avanti</button>
    </form>
    <form method="get" action="organizzatore/reg_tornei">
        <?= $vd->scriviToken('', ViewDescriptor::post)?>
        <button type="submit" name="cmd" value="r_indietro">Indietro</button>
    </form>
</div>

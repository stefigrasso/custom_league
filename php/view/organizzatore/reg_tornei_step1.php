<div>
    <h2 class="icon-title" id="h-registrazione">Registrazione Tornei</h2>
    <p>
        <strong>Organizzatore:</strong> <?= $user->getNome() ?> <?= $user->getCognome() ?>
    </p>
</div>
<div class="input-form">
    <h3>Passo 1: Selezione Luogo</h3>
    <form method="post" action="organizzatore/reg_tornei_step2?elenco=<?= $elenco_id ?><?= $vd->scriviToken('&')?>">
        <label for="luogo">Luogo</label>
        <input type="text" name="luogo" id="luogo"
                 <?= isset($sel_luogo) ? 'value="'.$sel_luogo.'"' : '' ?>/>
        <br/>
        <label for="indirizzo">Indirizzo</label>
        <input type="text" name="indirizzo" id="indirizzo"
                <?= isset($sel_indirizzo) ? 'value="'.$sel_indirizzo.'"' : '' ?>/>
        <button type="submit" name="cmd" value="r_sel_luogo">Avanti</button>
    </form>
    <form method="get" action="organizzatore/reg_tornei">
        <?= $vd->scriviToken('', ViewDescriptor::post)?>
        <button type="submit" name="cmd" value="r_indietro">Indietro</button>
    </form>
</div>
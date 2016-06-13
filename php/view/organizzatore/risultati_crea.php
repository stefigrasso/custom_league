<div class="input-form">
    <h3>Crea Risultati</h3>
    <form method="post" action="organizzatore/risultati_crea<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="cmd" value="risultati_nuovo"/>
        <label for="nome_torneo">Nome torneo</label>
        <select name="nome_torneo" id="nome_torneo">
            <?php foreach ($tornei as $torneo) { ?>
                <option value="<?= $torneo->getNome() ?>" ><?= $torneo->getNome() ?></option>
            <?php } ?>
        </select>
        <div class="btn-group">
            <button type="submit" name="cmd" value="risultati_nuovo">Salva</button>
            <button type="submit" name="cmd" value="risultati_annulla">Annulla</button>
        </div>
    </form>
</div>
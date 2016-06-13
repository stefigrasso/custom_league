<h2 class="icon-title" id="h-registrazione">Risultato</h2>
<h3><?= $torneo->getNome() ?></h3>
<ul>
    <li>Giornata: <?= $risultato->getGiornata() ?></li>
    <li>Partecipante A: <?= $risultato->getPartecipanteAId() ?></li>
    <li>Partecipante B: <?= $risultato->getPartecipanteBId() ?></li>
</ul>
<h4> Modifica punteggio </h4>
<div class="input-form">
    <form method="post" action="organizzatore/calendario?torneo=<?= $torneo->getId()?> <?= $vd->scriviToken('&')?>">
        <input type="hidden" name="risultato" value="<?= $risultato->getId(); ?>"/>
        <label for="punteggioA">Punteggio A</label>
        <input type="text" name="punteggioA" id="punteggioA" value ="<?= $risultato->getPunteggioA() ?>"/>
        <br/>
        <label for="punteggioB">Punteggio B</label>
        <input type="text" name="punteggioB" id="punteggioB" value ="<?= $risultato->getPunteggioB() ?>"/>
        <br/>
        <div class="btn-group">
            <button type="submit" name="cmd" value="risultato_modifica">Salva</button>
            <button type="submit" name="cmd" value="risultato_annulla">Annulla</button>
        </div>
    </form>
</div>
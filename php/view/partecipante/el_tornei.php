<h2 class="icon-title" id="h-elenco_tornei">Elenco tornei disponibili</h2>
<div class="error">
    <div>
        <ul><li>Testo</li></ul>
    </div>
</div>
<div class="input-form">
    <h3 class="icon-title" id="h-cerca">Filtro</h3>
    <form method="post" action="partecipante/el_tornei<?= $vd->scriviToken('?') ?>">
        <label for="nome">Nome</label>
        <input name="nome" id="nome" type="text"/>
        <br/>      
        <label for="disciplina">Disciplina</label>
        <input type="text" name="disciplina" id="disciplina"/>
        <br/>
        <label for="tipologia">Tipologia</label>
        <select name="tipologia" id="tipologia">
            <option value="qualsiasi">Qualsiasi</option>
            <?php foreach ($tipologie as $tipologia) { ?>
                    <option value="<?= $tipologia ?>"> <?= $tipologia ?></option>
            <?php } ?>
        </select>        
        <button id="filtra" type="submit" name="cmd" value="e_cerca">Cerca</button>
    </form>
</div>



<h3>Elenco tornei disponibili</h3>

<p id="nessuno">Nessun torneo trovato</p>

<table id="tabella_tornei">
    <thead>
        <tr>
            <th>Data Inizio</th>
            <th>Nome</th>
            <th>Disciplina</th>
            <th>Tipologia</th>
            <th>Edit</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>data_inizio</td>
            <td>nome</td>
            <td>disciplina</td>
            <td>tipologia</td>
            <td>edit</td>
        </tr>

    </tbody>
</table>
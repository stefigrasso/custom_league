<div class="input-form">
    <h2 class="icon-title" id="h-dati_personali">Dati personali</h2>

    <form method="post" action="partecipante/dati_personali<?=$vd->scriviToken('?')?>">
        <input type="hidden" name="cmd" value="dati_personali"/>
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= $user->getNome() ?>"/>
        <br/>
        <label for="cognome">Cognome:</label>
        <input type="text" name="cognome" id="cognome" value="<?= $user->getCognome() ?>"/>
        <br/>
        <label for="email">Email:</label>
        <input type="text" name="email" id="email" value="<?= $user->getEmail() ?>"/>
        <br/>
        <input type="submit" value="Salva"/>
    </form>
</div>

<div class="input-form">
    <h3 class="icon-title" id="h-password">Password</h3>
    <form method="post" action="partecipante/dati_personali<?= $vd->scriviToken('?')?>">
        <input type="hidden" name="cmd" value="password"/>
        <label for="pass1">Nuova Password:</label>
        <input type="password" name="pass1" id="pass1"/>
        <br/>
        <label for="pass2">Conferma:</label>
        <input type="password" name="pass2" id="pass2"/>
        <br/>
        <input type="submit" value="Cambia"/>
    </form>
</div>
<div class="input-form">
    <form method="get" action="partecipante/home<?= $vd->scriviToken('?')?>">
        <button type="submit" name="cmd" value="dati_personali_annulla">Indietro</button>
    </form>
</div>
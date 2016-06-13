<h2 id="help" class="icon-title">Istruzioni</h2>
<?php
switch ($vd->getSottoPagina()) {
    case 'dati_personali':
        ?>
        <p>
            In questa sezione puoi modificare i tuoi dati personali e la password:
        </p>
        <ul>
            <li>
                Il tuo <strong>nome</strong> e <strong>cognome</strong>.
            </li>
            <li>
                I tuoi contatti  (<strong>email</strong>).
            </li>
            <li>
                La tua <strong>password</strong>.
            </li>
        </ul>
        <p>
            Nota: la password deve essere di almeno 4 caratteri e può contenere solo lettere (maiuscole e minuscole) e numeri.
        </p>
        <p>
            Per salvare le modifiche ai dati personali premere il pulsante <em>Salva</em>.
        </p>
        <p>
            Per cambiare la password inserire la nuova password e confermarla una seconda volta.
            Per salvarla la nuova password premere il pulsante <em>Cambia</em>.
        </p>
        <p>
            Per tornare alla pagina principale senza effettuare alcuna modifica, 
            premere sul pulsante <em>Indietro</em>.
        </p>
        <?php break; ?>
        
    <?php case 'reg_tornei': ?>
        <p>
            In questa sezione puoi organizzare un torneo.
        </p>
        <p>
            Per creare un nuovo torneo premere il pulsante <strong><em>Nuovo Elenco</em></strong> ed inserire i dati passo passo.
        </p>
        <p>
            Se la creazione non viene completata, il torneo e i dati già inseriti
            rimangono salvati in elenco temporaneamente, 
            fino alla disconnessione dell'account.
        </p>
        <p>
            Nel caso sia stato creato un elenco di un torneo, puoi:
        </p>
        <ul>
            <li>
                completarlo e modificarlo premendo sull'icona <em>Modifica</em> 
                <img  src="../images/edit.png" alt="icona modifica">
            </li>
            <li>
                eliminarlo premendo sull'icona <em>Cancella</em> 
                <img  src="../images/trash.png" alt="icona elimina">
            </li>
        </ul>
        <?php break; ?>
        
    <?php case 'reg_tornei_step1': ?>
        <p>
            In questa sezione puoi inserire i seguenti dati del torneo:
        </p>
        <ul>
            <li>Il <strong>luogo</strong> del torneo (ad esempio: Nome della società, quartiere, provincia)</li>
            <li>L'<strong>indirizzo</strong>: dove verrà svolto il torneo.</li>
        </ul>
        <p>
            &Egrave; possibile proseguire con la registrazione del torneo
            tramite il pulsante  <em>Avanti</em>.
        </p>
        <p>
            &Egrave; possibile interrompere la registrazione del torneo
            tramite il pulsante  <em>Indietro</em>.
        </p>
        <?php break; ?>
        
    <?php case 'reg_tornei_step2': ?>
        <p>
            In questa sezione puoi inserire i seguenti dati del torneo:
        </p>
        <ul>
            <li>La <strong>disciplina</strong>: lo sport da praticare (ad es. calcio, basket, ping pong, dama, ecc.).</li>
            <li>La <strong>tipologia</strong>: la modalità di svolgimento del torneo.</li>
            <li>Il numero <strong>minimo</strong> e <strong>massimo</strong> di partecipanti.</li>
        </ul>
        <p>
            &Egrave; possibile proseguire con la registrazione del torneo
            tramite il pulsante  <em>Avanti</em>.
        </p>
        <p>
            &Egrave; possibile interrompere la registrazione del torneo
            tramite il pulsante  <em>Indietro</em>.
        </p>
        <?php break; ?>
        
    <?php case 'reg_tornei_step3': ?>
        <p>
            In questa sezione puoi inserire i seguenti dati del torneo:
        </p>
        <ul>
            <li>La <strong>data</strong> di inizio del torneo.</li>
            <li>Il <strong>nome</strong> del torneo.</li>
        </ul>
        <p>
            &Egrave; possibile proseguire con la registrazione del torneo
            tramite il pulsante  <em>Aggiungi</em>.
        </p>
        <p>
            &Egrave; possibile interrompere la registrazione del torneo
            tramite il pulsante  <em>Indietro</em>.
        </p>
        <p>
            Inoltre, &egrave; possibile creare più tornei dello stesso tipo, 
            modificando solo la data di inizio e il nome del torneo e 
            premendo nuovamente il pulsante  <em>Aggiungi</em>.
        </p>
        <p>
            &Egrave; possibile cancellare dall'elenco un torneo premendo sull'icona <em>Cancella</em> 
            <img  src="../images/trash.png" alt="icona elimina">
        </p>
        <p>
            Per registrare definitivamente il/i torneo/i creati
            premere il pulsante <strong><em>Registra Elenco</em></strong>.
        </p>
        <?php break; ?>
        
    <?php case 'tornei': ?>
        <p>
            In questa sezione puoi visualizzare i tornei creati da te.
        </p>
        <p>
            Per ogni torneo sono riportati i seguenti dati:
        </p>
        <ul>
            <li>La <strong>data</strong> di inizio del torneo.</li>
            <li>Il <strong>nome</strong> del torneo.</li>
            <li>La <strong>disciplina</strong>: lo sport da praticare al torneo.</li>
            <li>La <strong>tipologia</strong>: la modalità di svolgimento del torneo.</li>
        </ul>
        <p>
            &Egrave; anche possibile:
        </p>
        <ul>
            <li>visualizzare ulteriori dati relativi ad un torneo (luogo di svolgimento, iscritti al torneo, ecc.) 
                premendo sull'icona <em>Dettagli</em> <img  src="../images/zoom.png" alt="icona dettagli"></li>
            <li>generare il <strong>calendario</strong> di un torneo 
                premendo sull'icona <em>Calendario</em> <img  src="../images/calendar-add.png" alt="icona modifica"></li>
            <li>visualizzare il calendario e modificarne i <strong>risultati</strong>,
                nel caso il calendario sia già stato generato, premendo sull'icona <em>Calendario</em>
                <img  src="../images/calendar.png" alt="Calendario">.</li>
            <li>cancellare un torneo premendo sull'icona <em>Cancella</em>
                <img  src="../images/trash.png" alt="icona elimina"></li>
        </ul>
        <p>
            Inoltre, &egrave; possibile creare un nuovo torneo
            cliccando sul pulsante <strong><em>Crea Torneo</em></strong>.
        </p>
        <?php break; ?>
        
    <?php case 'torneo_dettagli': ?>
        <P>
            In questa sezione sono riportati i dati del torneo selezionato:
        </p>
        <ul>
            <li>Il <strong>nome</strong> del torneo.</li>
            <li>L'<strong>organizzatore: </strong> del torneo.</li>
            <li>La <strong>data</strong> di inizio del torneo.</li>
            <li>Il <strong>luogo</strong> del torneo.</li>
            <li>L'<strong>indirizzo</strong>: dove verrà svolto il torneo.</li>
            <li>La <strong>disciplina</strong>: lo sport da praticare al torneo.</li>
            <li>La <strong>tipologia</strong>: la modalità di svolgimento del torneo.
            <li>Gli <strong>iscritti</strong> al torneo
                [min: numero minimo necessario per attivare il torneo / max: numero massimo di iscritti].</li>
            <li>I <strong>posti ancora disponibili</strong> per l'iscrizione al torneo.</li>
        </ul>
        <p>
            Inoltre, sono riportati tutti i nomi degli iscritti al torneo.
        </p>
        <p>
            Premendo sul pulsante <em>Chiudi</em>, si torna alla pagina dei tornei.
        </p>
        <?php break; ?>
        
    <?php case 'calendario': ?>
        <P>
            In questa sezione è possibile visualizzare il calendario del torneo selezionato.
        </p>
        <p>
            Il calendario riporta i seguenti dati:
        </p>
        <ul>
            <li>Le <strong>giornate</strong> del torneo.</li>
            <li>I <strong>partecipanti</strong> di ogni incontro della giornata del torneo.</li>
            <li>Il <strong>punteggio</strong> di ogni incontro della giornata del torneo.</li>
        </ul>
        <p>
            &Egrave; possibile modificare il risultato di un incontro 
            premendo sull'icona <em>Modifica</em> 
            <img  src="../images/edit.png" alt="icona modifica">
        </p>
        <p>
            Premendo sul pulsante <em>Chiudi</em>, si torna alla pagina dei tornei.
        </p>
        <?php break; ?>
        
    <?php case 'risultato': ?>
        <P>
            In questa sezione è possibile modificare il risultato di un incontro del torneo selezionato.
        </p>
        <p>
            I dati riportati sono:
        </p>
        <ul>
            <li>La <strong>giornata</strong> dell'incontro.</li>
            <li>I <strong>partecipanti</strong> dell'incontro.</li>
            <li>Il <strong>punteggio</strong> dell'incontro.</li>
        </ul>
        <p>
            &Egrave; possibile modificare il risultato dell'incontro 
            sostituendo il punteggio totalizzato da ogni partecipante e 
            infine premendo sul pulsante <em>Salva</em>. 
        </p>
        <p>
            Per tornare alla pagina del calendario senza effettuare alcuna modifica, 
            premere sul pulsante <em>Annulla</em>.
        </p>
        <?php break; ?>
        
    <?php default:
        ?>
        <p>
            Seleziona una delle seguenti funzionalit&agrave; disponibili:
        </p>
        <ol>
            <li>
                <strong>Dati personali</strong> per visualizzare e modificare i tuoi dati 
                personali e la tua password.
            </li>
            <li>
                <strong>Crea Torneo</strong> per organizzare un nuovo torneo.
            </li>
            <li>
                <strong>Miei Tornei</strong> per visualizzare e modificare tutti i tuoi tornei e il relativo calendario.
            </li>
        </ol>
        <?php break; ?>
<?php } ?>
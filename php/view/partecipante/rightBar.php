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

    <?php case 'tornei': ?>
        <p>
            In questa sezione puoi visualizzare i tornei a cui sei iscritto.
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
            <li>visualizzare il calendario con i risultati, solo nel caso il calendario sia già stato generato, 
                premendo sull'icona <em>Calendario</em> <img  src="../images/calendar.png" alt="Calendario"></li>
            <li>cancellare l'iscrizione ad un torneo, solo nel caso in cui il calendario non sia stato già generato,
                premendo sull'icona <em>Cancella</em> <img  src="../images/trash.png" alt="Elimina"></li>
        </ul>
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
            Premendo sul pulsante <em>Chiudi</em>, si torna alla pagina dei tornei.
        </p>
        <?php break; ?>
        
    <?php case 'el_tornei': ?>
        <P>
            In questa sezione è possibile ricercare un torneo disponibile e iscriversi.
        </p>
        <p>
            La ricerca del torneo può essere filtrata tramite:
        </p>
        <ul>
            <li>Il <strong>nome</strong> del torneo.</li>
            <li>La <strong>disciplina</strong> del torneo.</li>
            <li>La <strong>tipologia</strong> del torneo.</li>
        </ul>
        <p>
            Premendo sul pulsante <em>Cerca</em>, si avvia la ricerca dei tornei.
        </p>
        <p>
            I tornei trovati a seguito della ricerca verranno visualizzati in <em>Elenco tornei disponibili</em>.
        </p>
        <p>
            Per visualizzare ulteriori dati riguardanti il torneo disponibile, 
            &egrave; possibile premere sull'icona <em>Dettagli</em> <img  src="../images/zoom.png">  
            (apre una nuova finestra)
        </p>
        <p>
            &Egrave; possibile iscriversi al torneo premendo sull'icona <em>Iscriviti</em> <img  src="../images/subscribe.png">
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
                <strong>Miei Tornei</strong> per visualizzare i tornei a cui sei iscritto.
            </li>
            <li>
                <strong>Elenco Tornei</strong> per visualizzare i tornei disponibili per potersi iscrivere.
            </li>
        </ol>
        <?php break; ?>
<?php } ?>


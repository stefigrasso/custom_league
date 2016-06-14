<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h1>Accesso all'applicazione del progetto</h1>
        <p>
            Potete scaricare il codice direttamente dal web o facendo un git clone
            al seguente indirizzo 
            <a href="https://github.com/stefigrasso/custom_league">https://github.com/stefigrasso/custom_league</a>
        </p>

        <h2>Descrizione dell'applicazione</h2>
        <p>
            L’applicazione supporta la creazione di tornei sportivi e permette di parteciparvi.
            La funzionalit&agrave di base prevede che un organizzatore possa inserire i dati relativi al torneo.
            I dati che figurano per ogni torneo sono i seguenti:
        </p>
        <ul>
            <li>Organizzatore</li>
            <li>Luogo</li>
            <li>Indirizzo</li>   
            <li>Disciplina (ad esempio: basket, calcio, tennis, dama, ecc.)</li>
            <li>Tipologia (ad esempio: girone italiano, eliminazione diretta)</li>
            <li>N° minimo e n° massimo di partecipanti</li>
            <li>Data di inizio</li>
            <li>Nome torneo</li>
        </ul>

        <p>
            Inoltre, l'organizzatore sar&agrave in grado di visualizzare tutti i tornei 
            organizzati da egli stesso.
        </p>
        <p>
            Ogni partecipante al torneo &egrave in grado di visualizzare tutti i tornei creati dagli organizzatori.
            Pu&ograve partecipare ad uno o più tornei.
        </p>
        
        <p>
            L’applicazione mantiene alcuni dati personali degli organizzatori e dei partecipanti, in particolare:
        </p>
        <ul>
            <li>Nome e Cognome</li>
            <li>Email</li>
        </ul>

        <p>
            Inoltre, fornisce istruzioni dettagliate sulla modalit&agrave di inserimento dei dati personali
            (che pu&ograve essere fatto direttamente da ogni utente) e dei dati relativi ai tornei.
        </p>
        
        <p>
            L'applicazione permette anche la visualizzazione dei tornei creati dagli organizzatori per i partecipanti
            con funzione di ricerca e filtraggio.
        </p>

        <p>
            L’applicazione gestisce la prenotazione ai tornei da parte dei partecipanti:
            l'organizzatore inserisce una data ed un numero minimo e massimo di partecipanti
            che possono partecipare al torneo.
            Il partecipante si connette e si iscrive nel caso ci siano ancora posti. 
        </p>

        <h2> Requisiti del progetto </h2>
        <ul>
            <li>Utilizzo di HTML e CSS</li>
            <li>Utilizzo di PHP e MySQL</li>
            <li>Utilizzo del pattern MVC </li>
            <li>Due ruoli (organizzatore e partecipante)</li>
            <li>Transazione per la creazione dei tornei (ruolo organizzatore) (metodo salvaElenco della classe TorneoFactory.php)</li>
            <li>Caricamento AJAX dei risultati della ricerca dei tornei (ruolo partecipante)</li>

        </ul>
    </ul>

    <h2>Accesso al progetto</h2>
    <p>
        La homepage del progetto si trova sulla URL <a href="php/login">http://spano.sc.unica.it/amm2015/grassoStefania/php/login</a>
    <p>
    <p>Si pu&ograve; accedere alla applicazione con le seguenti credenziali</p>
    <ul>
        <li>Ruolo 'organizzatore':</li>
        <ul>
            <li>username: organizzatore</li>
            <li>password: grasso</li>
        </ul>
        <li>Ruoli 'partecipante':</li>
        <ul>
            <li>username: partecipante</li>
            <li>username: part2</li>
            <li>username: part3</li>
            <li>username: part4</li>
            <li>username: part5</li>
            <li>username: part6</li>
            <li>username: part7</li>
            <li>username: part8</li>
            <li>password: grasso</li>
        </ul>
    </ul>
</body>
</html>

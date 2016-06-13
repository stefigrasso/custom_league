<?php

include_once basename(__DIR__) . '/../view/ViewDescriptor.php';
include_once basename(__DIR__) . '/../model/UtenteFactory.php';

/**
 * Controller che gestisce gli utenti non autenticati, 
 * fornendo le funzionalita' comuni anche agli altri controller
 *
 * @author Stefania Grasso
 */
class BaseController {
    
    const impersonato = '_imp';
    
    /**
     * Costruttore
     */
    public function __construct() {
        
    }
    
    /**
     * Metodo per gestire l'input dell'utente. Le sottoclassi lo sovrascrivono
     * @param type $request la richiesta da gestire
     */
    public function handleInput(&$request) {
        
        // creo il descrittore della vista
        $vd = new ViewDescriptor();

        // imposto la pagina
        $vd->setPagina($request['page']);
        
        // imposto il token per impersonare un utente 
        // (nel caso sia stato specificato nella richiesta)
        $this->setImpToken($vd, $request);
        
        // gestione dei comandi
        // tutte le variabili che vengono create senza essere utilizzate 
        // direttamente in questo switch, sono quelle che vengono poi lette
        // dalla vista, ed utilizzano le classi del modello

        $cmd = isset($request['cmd']) ? $request['cmd'] : '';
        if ($cmd == 'login') {
                // abbiamo ricevuto il comando per il login
                $username = isset($request['user']) ? $request['user'] : '';
                $password = isset($request['password']) ? $request['password'] : '';
                $user = $this->login($vd, $username, $password);             
        }
        
        if ($this->loggedIn()) {
            // utente autenticato
            // questa variabile viene poi utilizzata dalla vista
            if (!isset($user)) {
                $user = UtenteFactory::instance()->getUtenteDaId($_SESSION['user_id']);
            }
            $this->showHomeUtente($vd);
        } else {
            // utente non autenticato
            $this->showLoginPage($vd);
        }

        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }
     
    /**
     * Procedura di autenticazione 
     * @param ViewDescriptor $vd descrittore della vista
     * @param string $username lo username specificato
     * @param string $password la password specificata
     * @return Utente|NULL
     */
    protected function login($vd, $username, $password) {
        // carichiamo i dati dell'utente
        $user = UtenteFactory::instance()->getUtente($username, $password);
        if (isset($user)) {
            // utente autenticato
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_ruolo'] = $user->getRuolo();
        } else {
            $vd->setMessaggioErrore("Utente sconosciuto o password errata");
        }
        return $user;
    }
    
    /**
     * Verifica se l'utente sia correttamente autenticato
     * @return boolean true se l'utente era gia' autenticato, false altrimenti
     */
    protected function loggedIn() {
        return isset($_SESSION['user_id']);
    }
    
    /**
     * Imposta la vista master.php per visualizzare la pagina di login
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showLoginPage($vd) {
        // mostro la pagina di login
        $vd->setTitolo("custom_league - login");
        $vd->setMenuFile(basename(__DIR__) . '/../view/login/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/login/logo.php');
        $vd->setRightBarFile(basename(__DIR__) . '/../view/login/rightBar.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/login/content.php');
    }
    
    /**
     * Seleziona quale pagina mostrare in base al ruolo dell'utente corrente
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeUtente($vd) {
        $user = UtenteFactory::instance()->getUtenteDaId($_SESSION['user_id']);
        if (isset($user)) {
            switch ($user->getRuolo()) {
                case 'organizzatore':
                    $this->showHomeOrganizzatore($vd);
                    break;

                case 'partecipante':
                    $this->showHomePartecipante($vd);
                    break;

                case 'amministratore':
                    $this->showHomeAmministratore($vd);
                    break;
            }
        } else {
            $vd->setMessaggioErrore("Utente sconosciuto o password errata");
        }
    }
    
    /**
     * Imposta la vista master.php per visualizzare la pagina di gestione
     * dell'organizzatore
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeOrganizzatore($vd) {
        // mostro la home dell'organizzatore
        $vd->setTitolo("custom_league - gestione organizzatore");
        $vd->setMenuFile(basename(__DIR__) . '/../view/organizzatore/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/organizzatore/logo.php');
        $vd->setRightBarFile(basename(__DIR__) . '/../view/organizzatore/rightBar.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/organizzatore/content.php');
    }

    /**
     * Imposta la vista master.php per visualizzare la pagina di gestione
     * del partecipante
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomePartecipante($vd) {
        // mostro la home del partecipante
        $vd->setTitolo("custom_league - gestione partecipante");
        $vd->setMenuFile(basename(__DIR__) . '/../view/partecipante/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/partecipante/logo.php');
        $vd->setRightBarFile(basename(__DIR__) . '/../view/partecipante/rightBar.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/partecipante/content.php');
    }
    
    /**
     * Imposta la vista master.php per visualizzare la pagina di gestione
     * dell'amministratore
     * @param ViewDescriptor $vd il descrittore della vista
     */
    protected function showHomeAmministratore($vd) {
        // mostro la home dell'amministratore
        $vd->setTitolo("custom_league - Super User ");
        $vd->setMenuFile(basename(__DIR__) . '/../view/amministratore/menu.php');
        $vd->setLogoFile(basename(__DIR__) . '/../view/amministratore/logo.php');
        $vd->setRightBarFile(basename(__DIR__) . '/../view/amministratore/rightBar.php');
        $vd->setContentFile(basename(__DIR__) . '/../view/amministratore/content.php');
    }
    
    /**
     * Imposta la variabile del descrittore della vista legato 
     * all'utente da impersonare nel caso sia stato specificato nella richiesta
     * @param ViewDescriptor $vd il descrittore della vista
     * @param array $request la richiesta
     */
    protected function setImpToken(ViewDescriptor $vd, &$request) {

        if (array_key_exists('_imp', $request)) {
            $vd->setImpToken($request['_imp']);
        }
    }
    
    /**
     * Procedura di logout dal sistema 
     * @param type $vd il descrittore della pagina
     */
    protected function logout($vd) {
        // reset array $_SESSION
        $_SESSION = array();
        // termino la validita' del cookie di sessione
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            // imposto il termine di validita' al mese scorso
            setcookie(session_name(), '', time() - 2592000, '/');
        }
        // distruggo il file di sessione
        session_destroy();
        $this->showLoginPage($vd);
    }

    /**
     * Aggiorna i dati personali di un utente
     * @param User $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali
     * messaggi d'errore
     */
    protected function aggiornaDatiPersonali($user, &$request, &$msg) {

        if (isset($request['nome'])) {
            if (!$user->setNome($request['nome'])) {
                $msg[] = '<li>Errore durante il salvataggio del nome</li>';
            }
        }

        if (isset($request['cognome'])) {
            if (!$user->setCognome($request['cognome'])) {
                $msg[] = '<li>Errore durante il salvataggio del cognome</li>';
            }
        }
        
        if (isset($request['email'])) {
            if (!$user->setEmail($request['email'])) {
                $msg[] = '<li>L\'indirizzo email specificato non &egrave; corretto</li>';
            }
        }

        // salviamo i dati se non ci sono stati errori
        if (count($msg) == 0) {
            if (UtenteFactory::instance()->salva($user) != 1) {
                $msg[] = '<li>Salvataggio non riuscito</li>';
            }
        }
    }
    
    /**
     * Aggiorna la password di un utente
     * @param User $user l'utente da aggiornare
     * @param array $request la richiesta http da gestire
     * @param array $msg riferimento ad un array da riempire con eventuali
     * messaggi d'errore
     */
    protected function aggiornaPassword($user, &$request, &$msg) {
                     
        if (isset($request['pass1']) && isset($request['pass2'])) {
            if ($request['pass1'] == $request['pass2']) {
                if (!$user->setPassword($request['pass1'])) {
                    $msg[] = '<li>Il formato della password non &egrave; corretto</li>';
                }
            } else {
                $msg[] = '<li>Le due password non coincidono</li>';
            }
        }
        
        if (count($msg) == 0) {
            if (UtenteFactory::instance()->salva($user) != 1) {
                $msg[] = '<li>Salvataggio non riuscito</li>';
            }
        }
    }
    
    /**
     * Crea un messaggio di feedback per l'utente 
     * @param array $msg lista di messaggi di errore
     * @param ViewDescriptor $vd il descrittore della pagina
     * @param string $okMsg il messaggio da mostrare nel caso non ci siano errori
     */
    protected function creaFeedbackUtente(&$msg, $vd, $okMsg) {
        if (count($msg) > 0) {
            // ci sono messaggi di errore nell'array,
            // qualcosa e' andato storto...
            $error = "Si sono verificati i seguenti errori \n<ul>\n";
            foreach ($msg as $m) {
                $error = $error . $m . "\n";
            }
            // imposto il messaggio di errore
            $vd->setMessaggioErrore($error);
        } else {
            // non ci sono messaggi di errore, la procedura e' andata
            // quindi a buon fine, mostro un messaggio di conferma
            $vd->setMessaggioConferma($okMsg);
        }
    }
    
    /**
     * Restituisce il torneo specificato dall'organizzatore tramite una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array dove inserire eventuali messaggi d'errore
     * @return Torneo il torneo selezionato, null se non e' stato trovato
     */
    protected function getTorneo(&$request, &$msg, $user) {
        if (isset($request['torneo'])) {
            $torneo_id = filter_var($request['torneo'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            switch ($user->getRuolo()) {
                case 'organizzatore':
                    $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                    break;
                
                case 'partecipante':
                    $tornei = TorneoFactory::instance()->getTorneiDaPartecipante($user->getId());
                    break;
            }
            $torneo = $this->getTorneoDaId($torneo_id, $tornei);
            if ($torneo == null) {
                $msg[] = "Il torneo selezionato non &egrave; corretto</li>";
            }
            return $torneo;
        } else {
            return null;
        }
    } 
             
    /**
     * Ricerca un torneo tramite id all'interno di una lista
     * @param int $id l'id da cercare
     * @param array $tornei un array di tornei
     * @return Torneo il torneo con l'id specificato se presente nella lista,
     * null altrimenti
     */
    protected function getTorneoDaId($id, &$tornei) {
        foreach ($tornei as $torneo) {
            if ($torneo->getId() == $id) {
                return $torneo;
            }
        }

        return null;
    }


}

?>

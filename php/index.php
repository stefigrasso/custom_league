<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include_once 'controller/BaseController.php';
include_once 'controller/OrganizzatoreController.php';
include_once 'controller/PartecipanteController.php';

date_default_timezone_set("Europe/Rome");

// punto unico di accesso all'applicazione
FrontController::dispatch($_REQUEST);

/**
 * Classe che controlla il punto unico di accesso all'applicazione
 * 
 * @author Stefania Grasso
 */
class FrontController {

    /**
     * Gestore delle richieste al punto unico di accesso all'applicazione
     * @param array $request i parametri della richiesta
     */
    public static function dispatch(&$request) {
        
        // inizializza la sessione 
        session_start();
        
        if (isset($request["page"])) {
            switch ($request["page"]) {
                case "login":
                    // la pagina di login e' accessibile a tutti,
                    // la facciamo gestire al BaseController
                    $controller = new BaseController();
                    $controller->handleInput($request);
                    break;
                
                case 'organizzatore':
                    // la pagina degli organizzatori e' accessibile solo agli organizzatori
                    // ed agli amministratori
                    // il controllo viene fatto dal controller apposito
                    $controller = new OrganizzatoreController();
                    if (isset($_SESSION['user_ruolo']) &&
                        $_SESSION['user_ruolo'] != 'organizzatore') {
                        self::write403();
                    }
                    $controller->handleInput($request);
                    break;
                    
                case 'partecipante':
                    // la pagina dei partecipanti e' accessibile solo ai partecipanti
                    // ed agli amministratori
                    // il controllo viene fatto dal controller apposito
                    $controller = new PartecipanteController();
                    if (isset($_SESSION['user_ruolo']) &&
                        $_SESSION['user_ruolo'] != 'partecipante') {
                        self::write403();
                    }
                    $controller->handleInput($request);
                    break;
                    
                case 'amministratore':
                    // la pagina degli amministratori e' accessibile solo agli amministratori
                    // il controllo viene fatto dal controller apposito
                    $controller = new AmministratoreController();
                    if (isset($_SESSION['user_ruolo']) &&
                        $_SESSION['user_ruolo'] != 'amministratore') {
                        self::write403();
                    }
                    $controller->handleInput($request);
                    break;
                    
                default:
                    self::write404();
                    break;
            }
        } else {
            self::write404();
        }
    }
    
    /**
     * Crea una pagina di errore quando il path specificato non esiste
     */
    public static function write404() {
        
        // imposta il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 404 Not Found');
        $titolo = "File non trovato!";
        $messaggio = "La pagina che hai richiesto non &egrave; disponibile";
        include_once('error.php');
        exit();
    }
    
    /**
     * Crea una pagina di errore quando l'utente non ha i privilegi 
     * per accedere alla pagina
     */
    public static function write403() {
        // impostiamo il codice della risposta http a 403 (forbidden)
        header('HTTP/1.0 403 Forbidden');
        $titolo = "Accesso negato";
        $messaggio = "Non hai i diritti per accedere a questa pagina";
        $login = true;
        include_once('error.php');
        exit();
    }
}
?>
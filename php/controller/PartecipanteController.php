<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/TorneoFactory.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa ai
 * Partecipanti da parte di utenti con ruolo Partecipante o Amministratore 
 *
 * @author Stefania Grasso
 */
class PartecipanteController extends BaseController {
    
    /**
     * Costruttore
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Metodo per gestire l'input dell'utente.
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
        
        
        if ($this->loggedIn()) {
            // utente autenticato
            // questa variabile viene poi utilizzata dalla vista
            if (!isset($user)) {
                $user = UtenteFactory::instance()->getUtenteDaId($_SESSION['user_id']);
                
                // verifico quale sia la sottopagina della categoria
                // Organizzatore da servire ed imposto il descrittore 
                // della vista per caricare i "pezzi" delle pagine corretti
                // tutte le variabili che vengono create senza essere utilizzate 
                // direttamente in questo switch, sono quelle che vengono poi lette
                // dalla vista, ed utilizzano le classi del modello
                if (isset($request["subpage"])) {
                    switch ($request["subpage"]) {

                        // visualizzazione e modifica dei dati personali
                        case 'dati_personali':
                            $vd->setSottoPagina('dati_personali');
                            break;
                        
                        // visualizzazione dei tornei
                        case 'tornei':
                            // carica i tornei dal db
                            $tornei = TorneoFactory::instance()->getTorneiDaPartecipante($user->getId());
                            $vd->setSottoPagina('tornei');
                            break;
                        
                        // visualizzazione dei dettagli di un torneo
                        case 'torneo_dettagli':
                            // carica i tornei dal db
                            $tornei = TorneoFactory::instance()->getTorneiDaPartecipante($user->getId());
                            if (isset($request['torneo'])) {
                                $intVal = filter_var($request['torneo'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                                if (isset($intVal)) {
                                    $torneo = TorneoFactory::instance()->getTorneoDaId($intVal);
                                    if (isset($torneo)) {
                                        $organizzatore = UtenteFactory::instance()->getUtenteDaId($torneo->getOrganizzatoreId())->getNome();
                                        $vd->setSottoPagina('torneo_dettagli');
                                    } else {
                                        $vd->setSottoPagina('tornei');
                                    }
                                }
                            }
                            break;                            
                        
                        // visualizzazione dell'elenco tornei
                        case 'el_tornei':
                            $template = new Torneo();
                            $tipologie = $template->getTipologie();
                            $vd->setSottoPagina('el_tornei');
                            $vd->addScript("../js/jquery-2.1.1.min.js");
                            $vd->addScript("../js/elencoTornei.js");
                            break;
                        
                        
                        // gestione della richiesta ajax di filtro tornei
                        case 'filtra_tornei':
                            $vd->toggleJson();
                            $vd->setSottoPagina('el_tornei_json');
                            $errori = array();
                                                      
                            if (isset($request['nome'])) {
                                $nome = $request['nome'];
                            } else {
                                $nome = null;
                            }
                            
                            if (isset($request['disciplina'])) {
                                $disciplina = $request['disciplina'];
                            } else {
                                $disciplina = null;
                            }
                            
                            if (isset($request['tipologia']) && ($request['tipologia'] != '')) {
                                $tipologia = $request['tipologia'];
                            } else {
                                $tipologia = null;

                            }
                            
                            $tornei = TorneoFactory::instance()->ricercaTornei(
                                    $nome, $disciplina, $tipologia);
                            
                            $tornei_disponibili = array();
                            foreach ($tornei as $torneo) {
                                if ((!($torneo->isIscritto($user))) && (count($torneo->getPostiDisponibili()) > 0) && (count($torneo->getRisultati()) <= 0)) {
                                    $tornei_disponibili[] = $torneo;
                                }
                            }
                            $tornei = $tornei_disponibili;

                            break;
                                                        
                        // visualizza il calendario e i risultati di un torneo
                        case 'calendario':
                            // carica i tornei dal db
                            $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                            $torneo = $this->getTorneo($request, $msg, $user);
                            if ((isset($torneo)) && (count($torneo->getRisultati()) > 0)) {
                                $risultati = $torneo->getRisultati();
                                $iscritti = $torneo->getIscritti();
                                $vd->setSottoPagina('calendario');
                            } else {
                                $vd->setSottoPagina('tornei');
                            }
                            break;
                                                    
                        default:
                            $vd->setSottoPagina('home');
                            break;     
                    }        
                }
                
                // gestion dei comandi inviati dall'utente
                $cmd = isset($request['cmd']) ? $request['cmd'] : '';                
                switch ($cmd) {
                    
                    case 'logout': 
                        $this->logout($vd);
                        break;
                    
                    case 'dati_personali':
                        $msg = array();
                        $this->aggiornaDatiPersonali($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Dati personali aggiornati");
                        $this->showHomeUtente($vd);
                        break;
                    
                    case 'password':
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Password aggiornata");
                        $this->showHomeUtente($vd);
                        break;
                    
                    // l'utente vuole chiudere la pagina corrente senza modifiche
                    case 'torneo_annulla':
                    case 'calendario_annulla':
                        $vd->setSottoPagina('tornei');
                        $this->showHomeUtente($vd);
                        break;
                        
                    // iscrizione ad un torneo
                    case 'torneo_iscrivi':
                        $msg = array();
                        if (isset($request['torneo'])) {
                            $intVal = filter_var($request['torneo'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $torneo = TorneoFactory::instance()->getTorneoDaId($intVal);
                                if (isset($torneo)) {
                                    $iscritto = $torneo->iscrivi($user);
                                    if($iscritto) {
                                        $count = TorneoFactory::instance()->aggiungiIscrizione($user, $torneo);
                                    }
                                    if (!($iscritto) || $count != 1) {
                                        $msg[] = '<li> Impossibile iscriversi al torneo specificato</li>';
                                        if ($torneo->getPostiDisponibili() <= 0) {
                                            $msg[] = '<li> Non vi sono più posti disponibili </li>';
                                        }
                                        if ($torneo->isIscritto($user)) {
                                            $msg[] = '<li> Iscrizione già effettuata </li>';
                                        }
                                    }
                                } else {
                                    $msg[] = '<li> Torneo non trovato </li>';
                                }
                            } else {
                                $msg[] = '<li> Torneo non valido </li>';
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Iscrizione al torneo avvenuta con successo");
                        }
                        $tornei = TorneoFactory::instance()->getTorneiDaPartecipante($user->getId());
                        $this->showHomeUtente($vd);
                        break;
                        
                    // rimuove l'iscrizione ad un torneo
                    case 'iscrizione_cancella':
                        $msg = array();
                        if (isset($request['torneo'])) {
                            $intVal = filter_var($request['torneo'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $torneo = TorneoFactory::instance()->getTorneoDaId($intVal);
                                if ($torneo != null) {
                                    if (count($torneo->getRisultati()) <= 0) {
                                        if($torneo->cancellaIscrizioneUtente($user)) {
                                            $count = TorneoFactory::instance()->cancellaIscrizione($user, $torneo);
                                        }
                                        if ($count != 1) {
                                            $msg[] = '<li> Impossibile cancellarsi al torneo specificato</li>';
                                        }
                                    } else {
                                        $msg[] = '<li> Impossibile cancellarsi al torneo specificato. Il calendario è già stato creato. </li>';
                                    }
                                } else {
                                    $msg[] = '<li> Torneo non trovato </li>';
                                }
                            } else {
                                $msg[] = '<li> Torneo non valido </li>';
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Cancellazione al torneo avvenuta con successo");
                        }
                        $tornei = TorneoFactory::instance()->getTorneiDaPartecipante($user->getId());
                        $this->showHomeUtente($vd);
                        break;
                        
                    // ricerca di un torneo
                    case 'e_cerca':
                        $msg = array();
                        $this->creaFeedbackUtente($msg, $vd, "Implementato con il db");
                        $this->showHomeUtente($vd);
                        break;
                    
                    default:
                        $this->showHomeUtente($vd);
                        break;
                }
                
            }
            
        } else {
            // utente non autenticato
            $this->showLoginPage($vd);
        }
        
        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }
    
}

?>
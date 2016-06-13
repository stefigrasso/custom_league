<?php

include_once 'BaseController.php';
include_once basename(__DIR__) . '/../model/ElencoTornei.php';
include_once basename(__DIR__) . '/../model/UtenteFactory.php';
include_once basename(__DIR__) . '/../model/TorneoFactory.php';
include_once basename(__DIR__) . '/../model/RisultatoFactory.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa agli
 * Organizzatori da parte di utenti con ruolo Organizzatore o Amministratore 
 *
 * @author Stefania Grasso
 */
class OrganizzatoreController extends BaseController {
    
    const elenco = 'elenco';
    
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
                        
                        // visualizzazione della lista di tornei registrati
                        case 'tornei':
                            $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                            $vd->setSottoPagina('tornei');
                            break;
                        
                        // visualizzazione dei dettagli di un torneo
                        case 'torneo_dettagli':
                            $msg = array();
                            $torneo = $this->getTorneo($request, $msg, $user);
                            if (isset($torneo)) {
                                $organizzatore = UtenteFactory::instance()->getUtenteDaId($torneo->getOrganizzatoreId())->getNome();
                                $vd->setSottoPagina('torneo_dettagli');
                            } else {
                                // carica i tornei dal db
                                $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                                $vd->setSottoPagina('tornei');
                            }
                            break;
                        
                        // visualizzazione del form per la creazione di un nuovo torneo
                        case 'reg_tornei':
                            $msg = array();
                            if (!isset($_SESSION[self::elenco])) {
                                $_SESSION[self::elenco] = array();
                            }
                            $elenco_id = $this->getIdElenco($request, $msg, $_SESSION);
                            $elenchi_attivi = $_SESSION[self::elenco];
                            $vd->setSottoPagina('reg_tornei');
                            break;
                        
                        // registrazione dei tornei, passo 1:
                        // selezione del luogo
                        case 'reg_tornei_step1':
                            $msg = array();
                            // ricerco l'elenco da modificare, e' possibile gestirne 
                            // piu' di uno con lo stesso browser
                            $elenco_id = $this->getIdElenco($request, $msg, $_SESSION);
                            if (isset($elenco_id)) {
                                $sel_luogo = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getLuogo();
                                $sel_indirizzo = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getIndirizzo();
                            }
                            $vd->setSottoPagina('reg_tornei_step1');
                            break;

                        // registrazione dei tornei, passo 2:
                        // selezione della tipologia
                        case 'reg_tornei_step2':
                            $msg = array();
                            // ricerco l'elenco da modificare, e' possibile gestirne 
                            // piu' di uno con lo stesso browser
                            $elenco_id = $this->getIdElenco($request, $msg, $_SESSION);
                            $tipologie = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getTipologie();
                            $elenchi_attivi = $_SESSION[self::elenco];
                            if (isset($elenco_id)) {
                                $sel_luogo = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getLuogo();
                                $sel_indirizzo = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getIndirizzo();
                                $sel_disciplina = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getDisciplina();
                                $sel_tipologia = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getTipologia();
                                $sel_min_partecipanti = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getMinPartecipanti();
                                $sel_max_partecipanti = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getMaxPartecipanti();
                                $sel_tornei = $_SESSION[self::elenco][$elenco_id]->getTornei();
                                // se il luogo non e' stato specificato lo rimandiamo
                                // al passo precedente
                                if (!isset($sel_luogo) && !isset($sel_indirizzo)) {
                                    $vd->setSottoPagina('reg_tornei_step1');
                                } else {
                                    // tutto ok, passo 2
                                    $vd->setSottoPagina('reg_tornei_step2');
                                }
                            } else {
                                $vd->setSottoPagina('reg_tornei');
                            }
                            break;

                        // registrazione dei tornei, passo 3:
                        // inserimento elenco tornei
                        case 'reg_tornei_step3':
                            $msg = array();
                            // ricerco l'elenco da modificare, e' possibile gestirne 
                            // piu' di uno con lo stesso browser
                            $elenco_id = $this->getIdElenco($request, $msg, $_SESSION);
                            $elenchi_attivi = $_SESSION[self::elenco];                            
                            if (isset($elenco_id)) {
                                $sel_luogo = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getLuogo();
                                $sel_indirizzo = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getIndirizzo();
                                $sel_disciplina = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getDisciplina();
                                $sel_tipologia = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getTipologia();
                                $sel_min_partecipanti = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getMinPartecipanti();
                                $sel_max_partecipanti = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getMaxPartecipanti();
                                $sel_tornei = $_SESSION[self::elenco][$elenco_id]->getTornei();
                                // se il luogo non e' stato specificato lo 
                                // rimandiamo al passo 1
                                if (!isset($sel_luogo) && !isset($sel_indirizzo)) {
                                    $vd->setSottoPagina('reg_tornei_step1');
                                // se la tipologia non e' stata specificata lo
                                // rimandiamo al passo 2
                                } else if (!isset($sel_disciplina) && !isset($sel_tipologia)
                                        && !isset($sel_min_partecipanti) && !isset($sel_max_partecipanti)) {
                                    $vd->setSottoPagina('reg_tornei_step2');
                                } else {
                                    // tutto ok, passo 3
                                    $vd->setSottoPagina('reg_tornei_step3');
                                }
                            } else {
                                $vd->setSottoPagina('reg_tornei');
                            }
                            break;
                    
                        // visualizzazione della lista di iscritti ad un torneo
                        case 'torneo_iscritti':
                            $msg = array();
                            $torneo = $this->getTorneo($request, $msg, $user);
                            if (isset($torneo)) {
                                $vd->setSottoPagina('torneo_iscritti');
                            } else {
                                // carica i tornei dal db
                                $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                                $vd->setSottoPagina('tornei');
                            }
                            break;
                                                                                
                        // visualizza il calendario e i risultati di un torneo
                        case 'calendario':
                            $msg = array();
                            $torneo = $this->getTorneo($request, $msg, $user);
                            if ((isset($torneo)) && (count($torneo->getRisultati()) > 0)) {
                                $risultati = $torneo->getRisultati();
                                $iscritti = $torneo->getIscritti();
                                $vd->setSottoPagina('calendario');
                            } else {
                                // carica i tornei dal db
                                $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                                $vd->setSottoPagina('tornei');
                            }
                            break;
                        
                        // visualizza il risultato di un calendario
                        case 'risultato':
                            if (isset($request['risultato'])) {
                                $risultato = RisultatoFactory::instance()->getRisultatoDaId($request['risultato']);
                                if (isset($risultato)) {
                                    $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                                    $torneo = $this->getTorneoDaId($risultato->getTorneoId(), $tornei);
                                    if(isset($torneo)) {
                                        $vd->setSottoPagina('risultato');
                                    }
                                } else {
                                    $vd->setSottoPagina('calendario');
                                }
                            } else {
                                $vd->setSottoPagina('calendario');
                            }
                            break;
                                                                                        
                        default:
                            $vd->setSottoPagina('home');
                            break;
                    }
                }
                
                // gestione dei comandi inviati dall'utente
                $cmd = isset($request['cmd']) ? $request['cmd'] : '';
                switch ($cmd) {
                    // abbiamo ricevuto il comando per il logout
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
                    
                    // richiesta di creazione di un nuovo elenco di tornei
                    case 'r_nuovo':
                        $elenco_id = $this->prossimoIndiceElencoListe($_SESSION[self::elenco]);
                        // salviamo gli oggetti interi in sessione
                        $el = new ElencoTornei($elenco_id);
                        $el->getTemplate()->setOrganizzatoreId($user->getId());
                        $_SESSION[self::elenco][$elenco_id] = $el;
                        $elenchi_attivi = $_SESSION[self::elenco];

                        $this->showHomeUtente($vd);
                        break;
                    
                    // selezione del luogo
                    case 'r_sel_luogo':
                        $msg = array();
                        if (isset($elenco_id)) {
                            // richiesta di andare al passo successivo
                            if (!isset($request['luogo'])) {
                                $msg[] = "<li> Non &egrave; stato selezionato un luogo</li>";
                            } else {
                                if(!$_SESSION[self::elenco][$elenco_id]->getTemplate()->setLuogo($request['luogo'])) {
                                    $msg[] = "<li> Luogo inserito errato</li>";
                                }
                                $sel_luogo = $request['luogo'];
                            }          
                            if (!isset($request['indirizzo'])) {
                                $msg[] = "<li> Non &egrave; stato selezionato un indirizzo</li>";
                            } else {
                                if(!$_SESSION[self::elenco][$elenco_id]->getTemplate()->setIndirizzo($request['indirizzo'])) {
                                    $msg[] = "<li> Indirizzo inserito errato</li>";
                                }
                                $sel_indirizzo = $request['indirizzo'];
                            }
                            if (count($msg) == 0) {
                                // nessun errore, andiamo al passo successivo     
                                $vd->setSottoPagina('reg_tornei_step2');
                            } else { 
                                $vd->setSottoPagina('reg_tornei_step1');
                            }         
                            $this->creaFeedbackUtente($msg, $vd, "Luogo selezionato");
                        }
                        $this->showHomeUtente($vd);
                        break;
                    
                    //TODO: implementare la tipologia "Eliminazione diretta"
                    // salvataggio della disciplina e della tipologia per l'elenco di tornei
                    case 'r_sel_tipologia':
                        if (isset($elenco_id)) {
                            // richiesta di andare al passo successivo
                            if (!isset($request['disciplina'])) {
                                $msg[] = "<li> Non &egrave; stata selezionata una disciplina</li>";
                            } else {
                                if(!$_SESSION[self::elenco][$elenco_id]->getTemplate()->setDisciplina($request['disciplina'])) {
                                    $msg[] = "<li> Disciplina inserita errata</li>";
                                }
                                $sel_disciplina = $request['disciplina'];  
                            }
                            if (!isset($request['tipologia'])) {
                                $msg[] = "<li> Non &egrave; stata selezionata una tipologia</li>";
                            } else {
                                if($request['tipologia'] == "Eliminazione diretta") {
                                    $msg[] = "<li> Tipologia non ancora implementata</li>";
                                }
                                else if(!$_SESSION[self::elenco][$elenco_id]->getTemplate()->setTipologia($request['tipologia'])) {
                                   $msg[] = "<li> Tipologia inserita errata</li>";
                                }
                                $sel_tipologia = $request['tipologia'];      
                            }
                            if (!isset($request['min_partecipanti'])) {
                                $msg[] = "<li> Non &egrave; stato selezionato un minimo di partecipanti</li>";
                            } else {
                                if(!$_SESSION[self::elenco][$elenco_id]->getTemplate()->setMinPartecipanti($request['min_partecipanti'])) {
                                   $msg[] = "<li> Minimo di partecipanti inserito errato</li>";
                                }
                                $sel_min_partecipanti = $request['min_partecipanti'];
                            }
                            if (!isset($request['max_partecipanti'])) {
                                $msg[] = "<li> Non &egrave; stato selezionato un massimo di partecipanti</li>";
                            } else {
                                if(!$_SESSION[self::elenco][$elenco_id]->getTemplate()->setMaxPartecipanti($request['max_partecipanti'])) {
                                    $msg[] = "<li> Massimo di partecipanti inserito errato</li>";
                                }
                                $sel_max_partecipanti = $request['max_partecipanti'];
                            }
                            if (count($msg) == 0) {
                                // nessun errore, andiamo al passo successivo
                                $vd->setSottoPagina('reg_tornei_step3');
                            } else {
                                $tipologie = $_SESSION[self::elenco][$elenco_id]->getTemplate()->getTipologie();
                                $vd->setSottoPagina('reg_tornei_step2');
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Tipologia selezionata");
                        }
                        $this->showHomeUtente($vd);
                        break;
                        
                    // aggiunta di un torneo all'elenco
                    case 'r_add_torneo':
                        if (isset($elenco_id)) {
                            // richiesta di andare al passo successivo
                            if (!isset($request['data_inizio'])) {
                                $msg[] = "<li> Non &egrave; stata selezionata una data di inizio</li>";
                            } else {                                
                                $data = DateTime::createFromFormat("d/m/Y", $request['data_inizio']);
                                if (isset($data) && $data != false) {
                                    $_SESSION[self::elenco][$elenco_id]->getTemplate()->setDataInizio($data);
                                } else {
                                    $msg[] = "<li>Data inserita errata</li>";
                                }
                            }
                            if (!isset($request['nome'])) {
                                $msg[] = "<li> Non &egrave; stato selezionato un nome al torneo</li>";
                            } else {
                                if(!$_SESSION[self::elenco][$elenco_id]->getTemplate()->setNome($request['nome'])) {
                                    $msg[] = "<li> Nome inserito errato</li>";
                                }
                            }
                            if (count($msg) == 0) { 
                                // nessun errore, aggiungiamo un torneo alla lista
                                $new_torneo = new Torneo();
                                $new_torneo->setOrganizzatoreId($_SESSION[self::elenco][$elenco_id]->getTemplate()->getOrganizzatoreId());
                                $new_torneo->setLuogo($_SESSION[self::elenco][$elenco_id]->getTemplate()->getLuogo());
                                $new_torneo->setIndirizzo($_SESSION[self::elenco][$elenco_id]->getTemplate()->getIndirizzo());
                                $new_torneo->setDisciplina($_SESSION[self::elenco][$elenco_id]->getTemplate()->getDisciplina());
                                $new_torneo->setTipologia($_SESSION[self::elenco][$elenco_id]->getTemplate()->getTipologia());
                                $new_torneo->setMinPartecipanti($_SESSION[self::elenco][$elenco_id]->getTemplate()->getMinPartecipanti());
                                $new_torneo->setMaxPartecipanti($_SESSION[self::elenco][$elenco_id]->getTemplate()->getMaxPartecipanti());
                                $new_torneo->setDataInizio($_SESSION[self::elenco][$elenco_id]->getTemplate()->getDataInizio());
                                $new_torneo->setNome($_SESSION[self::elenco][$elenco_id]->getTemplate()->getNome());

                                if (!$_SESSION[self::elenco][$elenco_id]->aggiungiTorneo($new_torneo)) {
                                    // torneo duplicato
                                    $msg[] = '<li>Il torneo specificato &egrave; gi&agrave; presente in elenco </li>';
                                } else {
                                    // facciamo una copia aggiornata dell'elenco di tornei per la vista
                                    $sel_tornei = $_SESSION[self::elenco][$elenco_id]->getTornei();
                                }
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Torneo inserito in elenco");
                        }
                        $this->showHomeUtente($vd);
                        break;
                        
                    // salvataggio permanente dell'elenco di tornei
                    case 'r_salva_elenco':
                        if (isset($elenco_id)) {
                            if (count($_SESSION[self::elenco][$elenco_id]->getTornei()) > 0) {
                                if (!TorneoFactory::instance()->salvaElenco($_SESSION[self::elenco][$elenco_id])) {
                                    $msg[] = '<li> Impossibile salvare l\'elenco</li>';
                                } else {
                                    unset($_SESSION[self::elenco][$elenco_id]);
                                    $elenchi_attivi = $_SESSION[self::elenco];
                                    $vd->setPagina("reg_tornei");
                                    $vd->setSottoPagina('reg_tornei');
                                }
                            } else {
                                $msg[] = '<li> &Egrave; necessario inserire almeno un torneo</li>';
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Tornei registrati correttamente: vedi i Miei Tornei");
                        }
                        $this->showHomeUtente($vd);
                        break;
                        
                    // cancellazione di un elenco di tornei
                    case 'r_del_elenco':
                        if (isset($elenco_id) && array_key_exists($elenco_id, $_SESSION[self::elenco])) {
                            unset($_SESSION[self::elenco][$elenco_id]);
                            $this->creaFeedbackUtente($msg, $vd, "Elenco cancellato");
                            $elenchi_attivi = $_SESSION[self::elenco];
                        }
                        $this->showHomeUtente($vd);
                        break;                        
                        
                    // rimozione di un torneo dall'elenco
                    case 'r_del_torneo':
                        if (isset($elenco_id)) {
                            $index = filter_var($request['index'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($index) && $index >= 0 && $index < count($sel_tornei)) {
                                $old_torneo = $_SESSION[self::elenco][$elenco_id]->getTornei()[$index];
                                if (!$_SESSION[self::elenco][$elenco_id]->rimuoviTorneo($old_torneo)) {
                                    $msg[] = '<li>Il torneo specificato non &egrave; in lista </li>';
                                } else {
                                    // facciamo una copia aggiornata dell'elenco dei tornei per la vista
                                    $sel_tornei = $_SESSION[self::elenco][$elenco_id]->getTornei();
                                }
                            } else {
                                $msg[] = '<li>Impossibile trovare il torneo specificato </li>';
                            }
                            $this->creaFeedbackUtente($msg, $vd, "Torneo eliminato correttamente");
                        }
                        $this->showHomeUtente($vd);
                        break;
                        
                    // visualizzazione del form per la creazione di un nuovo torneo
                    case 'torneo_crea':
                        $vd->setSottoPagina('reg_tornei');
                        $this->showHomeUtente($vd);
                        break;
                    
                    // cancella un torneo
                    case 'torneo_cancella':
                        $msg = array();
                        $torneo = $this->getTorneo($request, $msg, $user);
                        if (isset($torneo)) {
                            if (TorneoFactory::instance()->cancella($torneo) != 1) {
                                $msg[] = '<li> Impossibile cancellare il torneo </li>';
                            }
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Torneo eliminato");
                        // carica i tornei dal db
                        $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                        $this->showHomeUtente($vd);
                        break;
                        
                    // l'utente vuole chiudere la pagina corrente senza modifiche
                    case 'dati_personali_annulla':
                    case 'torneo_annulla':
                    case 'calendario_annulla':
                        $this->showHomeUtente($vd);
                        break;
                    
                    // visualizza la pagina di creazione dei risultati di un torneo
                    case 'calendario_genera':
                        $msg = array();
                        $torneo = $this->getTorneo($request, $msg, $user);
                        if (isset($torneo)) {
                            if ($torneo->getNumIscritti() >= $torneo->getMinPartecipanti()) {
                                $this->generaTorneo($torneo, $msg);
                            } else {
                                $msg[] = '<li> Il torneo non ha raggiunto il numero minimo di iscritti </li>';
                            }
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Torneo generato: vedi il Calendario");
                        // carica i tornei dal db
                        $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                        $this->showHomeUtente($vd);
                        break;
           
                    // modifica il risultato di un torneo
                    case 'risultato_modifica':
                        if (isset($request['risultato'])) {
                            $risultato = RisultatoFactory::instance()->getRisultatoDaId($request['risultato']);
                            if (isset($risultato)) {
                                $tornei = TorneoFactory::instance()->getTorneiDaOrganizzatore($user->getId());
                                $torneo = $this->getTorneoDaId($risultato->getTorneoId(), $tornei);
                                if(isset($torneo)) {
                                    if ($risultato->setPunteggioA($request['punteggioA']) &&
                                        $risultato->setPunteggioB($request['punteggioB'])) {
                                        $count = RisultatoFactory::instance()->modifica($risultato);
                                        if ($count != 1) {
                                            $msg[] = '<li> Impossibile modificare il risultato </li>';
                                        } else {
                                            $risultati = RisultatoFactory::instance()->getRisultatiDaTorneo($torneo->getId());
                                        }
                                    } else {
                                        $msg[] = '<li> Impossibile modificare il punteggio </li>';
                                    }
                                }
                            } else {
                                $msg[] = '<li> Risultato non valido </li>';
                            }
                        } else {
                            $msg[] = '<li> Richiesta non valida </li>';
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Risultato modificato");
                        $this->showHomeUtente($vd);                       
                        break;
                        
                    // l'utente vuole chiudere la pagina corrente senza modifiche
                    case 'risultato_annulla':
                        $vd->setSottoPagina('calendario');
                        $this->showHomeUtente($vd);
                        break;
        
                    // default
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
    
    
    /**
     * Restituisce l'identificatore dell'elenco specificato in una richiesta HTTP
     * @param array $request la richiesta HTTP
     * @param array $msg un array per inserire eventuali messaggi d'errore
     * @return l'identificatore dell'elenco selezionato
     */
    private function getIdElenco(&$request, &$msg) {
        if (!isset($request['elenco'])) {
            $msg[] = "<li> Non &egrave; stato selezionato un elenco</li>";
        } else {
            // recuperiamo l'elenco dalla sessione
            $elenco_id = filter_var($request['elenco'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if (!isset($elenco_id) || !array_key_exists($elenco_id, $_SESSION[self::elenco])
                    || $elenco_id < 0) {
                $msg[] = "L'elenco selezionato non &egrave; corretto</li>";
                return null;
            }
            return $elenco_id;
        }
        return null;
    }
    
    /**
     * Restituisce il prossimo id per gli elenchi dei tornei
     * @param array $elenco un elenco di tornei
     * @return int il prossimo identificatore
     */
    private function prossimoIndiceElencoListe(&$elenco) {
        if (!isset($elenco)) {
            return 0;
        }

        if (count($elenco) == 0) {
            return 0;
        }

        return max(array_keys($elenco)) + 1;
    }
      
    /**
     * Seleziona quale torneo generare in base alla tipologia del torneo
     * @param type $torneo
     * @param string $msg
     */
    private function generaTorneo($torneo, &$msg) {
        switch ($torneo->getTipologia()) {
            case 'Girone italiano':
                $this->creaGironeItaliano($torneo, $msg);
                break;
            case 'Eliminazione diretta':
                $this->creaEliminazioneDiretta($torneo, $msg);
                break;
            default:
                $msg[] = "Tipologia torneo non definita";
                break;
        }
        
    }
    
    //TODO   
    /**
     * Genera il calendario di un torneo secondo la tipologia "Eliminazione diretta"
     * @param type $torneo
     * @param type $msg
     */
    private function creaEliminazioneDiretta($torneo, &$msg) {
        $msg[] = "Eliminazione diretta non ancora implementata";
    }
    
    /**
     * Mescola gli iscritti per dare un ordine casuale
     * @param $iscritti array lista di partecipanti al torneo
     * @return $iscritti_rand array lista di partecipanti al torneo mescolata (riferimento)
     */
    private function mescolaIscritti($iscritti) {
        $num_iscritti = count($iscritti);
        $iscritti_rand = array();
        $usciti = array();
        $i = 0;
        while ($i < $num_iscritti) {
            do {
                $uguale = false;
                $int = rand(0, $num_iscritti - 1);
                if (count($usciti) > 0) {
                    foreach ($usciti as $uscito) {
                        if ($uscito == $int) {
                            $uguale = true;
                        }
                    }
                }
                if (!$uguale) {
                    $usciti[] = $int;
                }
            } while ($uguale);
            ++$i;
        }
        
        foreach ($usciti as $uscito) {
            $iscritti_rand[] = $iscritti[$uscito];
        }
        
        return $iscritti_rand;
    }

    /**
     * Genera il calendario di un torneo secondo la tipologia "Girone italiano"
     * @param type $torneo
     * @param type $msg
     */
    private function creaGironeItaliano($torneo, $msg) {
        $risultati = array();
        $num_iscritti = $torneo->getNumIscritti();
        $num_iscritti_diviso = $num_iscritti / 2;
        $iscritti = $torneo->getIscritti();        
        
        $giornate_andata = array();
        $giornata = array();
        $match = array();
        $num_giornate = $num_iscritti - 1;
        
        for ($i = 0; $i < $num_giornate; ++$i) {
            for ($j = 0; $j < $num_iscritti_diviso; ++$j) {
                $match[] = $iscritti[$j];
                $match[] = $iscritti[$j + $num_iscritti_diviso];
                $giornata[] = $match;
                $match = array();
            }
            $giornate_andata[] = $giornata;
            $giornata = array();

            $centro = array_splice($iscritti, $num_iscritti_diviso - 1, 2);
            $perno = array_slice($iscritti, 0, 1);
            $perno[] = $centro[1];
            $coda = array_slice($iscritti, 1);
            $coda[] = $centro[0];
            $iscritti = array_merge($perno, $coda);
        }
        
        $count = 1;
        foreach ($giornate_andata as $giornata) {
            foreach ($giornata as $match) {
                $risultato = new Risultato();
                $risultato->setId(-1);
                $risultato->setGiornata($count);
                $risultato->setTorneoId($torneo->getId());
                $risultato->setPartecipanteAId($match[0]->getId());
                $risultato->setPartecipanteBId($match[1]->getId());
                $risultato->setPunteggioA(0);
                $risultato->setPunteggioB(0);
                
                $risultati_andata[] = $risultato;
            }
            ++$count;
        }
        
        foreach ($giornate_andata as $giornata) {
            foreach ($giornata as $match) {
                $risultato = new Risultato();
                $risultato->setId(-1);
                $risultato->setGiornata($count);
                $risultato->setTorneoId($torneo->getId());
                $risultato->setPartecipanteAId($match[1]->getId());
                $risultato->setPartecipanteBId($match[0]->getId());
                $risultato->setPunteggioA(0);
                $risultato->setPunteggioB(0);
                
                $risultati_ritorno[] = $risultato;
            }
            ++$count;
        }
        
        $risultati = array_merge($risultati_andata, $risultati_ritorno);
        
        if (isset($risultati)) {
            if($torneo->setRisultati($risultati)) {
                foreach ($risultati as $risultato) {
                    $count = RisultatoFactory::instance()->nuovo($risultato);
                    if ($count != 1) {
                        $msg[] = '<li> Impossibile creare il risultato </li>';
                    }
                }
            } else {
                $msg[] = '<li> Impossibile creare i risultati </li>';
            }
        } else {
            $msg[] = '<li> Impossibile creare il calendario </li>';
        }
 
    }
    
}

?>

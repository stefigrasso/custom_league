<?php

include_once 'Torneo.php';
include_once 'RisultatoFactory.php';
include_once 'UtenteFactory.php';

/**
 * Classe per creare oggetti di tipo Torneo
 *
 * @author Stefania Grasso
 */
class TorneoFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restiuisce un singleton per creare tornei
     * @return \TorneoFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new TorneoFactory();
        }

        return self::$singleton;
    }
    
    /**
     * Cerca tutti i tornei disponibili
     * @return array una lista di tornei (riferimento)
     */
    public function &getTornei() {

        $query = "select * from tornei";

        $input_bindings = array();

        $input_bind_format = '';

        $output_bindings = array('tornei_id', 'tornei_organizzatore_id', 'tornei_data_inizio', 
            'tornei_nome', 'tornei_luogo',
            'tornei_indirizzo', 'tornei_disciplina', 'tornei_tipologia', 
            'tornei_min_partecipanti', 'tornei_max_partecipanti');

        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);

        $tornei = $this->creaTornei($result);
        
        return $tornei;
    }
    
    /**
     * Cerca un torneo tramite il nome
     * @param string $nome
     * @return Torneo un oggetto Torneo nel caso sia stato trovato,
     * NULL altrimenti
     */
    public function getTorneoDaNome($nome) {

        $query = "select
            tornei.id tornei_id,
            tornei.organizzatore_id tornei_organizzatore_id,
            tornei.data_inizio tornei_data_inizio,
            tornei.nome tornei_nome,
            tornei.luogo tornei_luogo,
            tornei.indirizzo tornei_indirizzo,
            tornei.disciplina tornei_disciplina,
            tornei.tipologia tornei_tipologia,
            tornei.min_partecipanti tornei_min_partecipanti,
            tornei.max_partecipanti tornei_max_partecipanti
            
            from tornei 
            where tornei.nome = ?";

        $input_bindings = array($nome);

        $input_bind_format = 's';

        $output_bindings = array('tornei_id', 'tornei_organizzatore_id', 
            'tornei_data_inizio', 'tornei_nome', 'tornei_luogo',
            'tornei_indirizzo', 'tornei_disciplina', 'tornei_tipologia', 
            'tornei_min_partecipanti', 'tornei_max_partecipanti');

        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);

        $tornei = $this->creaTornei($result);
        
        if (count($tornei) == 1) {
            return $tornei[0];
        } else {
            return NULL;
        }
    }

    /**
     * Cerca un torneo tramite id
     * @param int $id
     * @return Torneo un oggetto Torneo nel caso sia stato trovato,
     * NULL altrimenti
     */
    public function getTorneoDaId($id) {

        $query = "select 
            tornei.id tornei_id, 
            tornei.organizzatore_id tornei_organizzatore_id, 
            tornei.data_inizio tornei_data_inizio,
            tornei.nome tornei_nome, 
            tornei.luogo tornei_luogo, 
            tornei.indirizzo tornei_indirizzo, 
            tornei.disciplina tornei_disciplina, 
            tornei.tipologia tornei_tipologia,
            tornei.min_partecipanti tornei_min_partecipanti, 
            tornei.max_partecipanti tornei_max_partecipanti
            
            from tornei 
            where tornei.id = ?";


        $input_bindings = array($id);

        $input_bind_format = 'i';

        $output_bindings = array('tornei_id', 'tornei_organizzatore_id', 
            'tornei_data_inizio', 'tornei_nome', 'tornei_luogo',
            'tornei_indirizzo', 'tornei_disciplina', 'tornei_tipologia', 
            'tornei_min_partecipanti', 'tornei_max_partecipanti');

        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);

        $tornei = $this->creaTornei($result);

        if (count($tornei) == 1) {
            return $tornei[0];
        } else {
            return NULL;
        }
    }

    /**
     * Restituisce tutti i tornei inseriti da un dato Organizzatore
     * @param $organizzatore_id l'id dell'organizzatore per la ricerca
     * @return array una lista di tornei (riferimento)
     */
    public function &getTorneiDaOrganizzatore($organizzatore_id) {

        $query = "select
            tornei.id tornei_id,
            tornei.organizzatore_id tornei_organizzatore_id,
            tornei.data_inizio tornei_data_inizio,
            tornei.nome tornei_nome,
            tornei.luogo tornei_luogo,
            tornei.indirizzo tornei_indirizzo,
            tornei.disciplina tornei_disciplina,
            tornei.tipologia tornei_tipologia,
            tornei.min_partecipanti tornei_min_partecipanti,
            tornei.max_partecipanti tornei_max_partecipanti
            
            from tornei 
            join utenti on tornei.organizzatore_id = utenti.id 
            where utenti.id = ?";

        $input_bindings = array($organizzatore_id);

        $input_bind_format = 'i';

        $output_bindings = array('tornei_id', 'tornei_organizzatore_id',
            'tornei_data_inizio', 'tornei_nome', 'tornei_luogo',
            'tornei_indirizzo', 'tornei_disciplina', 'tornei_tipologia', 
            'tornei_min_partecipanti', 'tornei_max_partecipanti');

        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);

        $tornei = $this->creaTornei($result);
        
        return $tornei;
    }

    /**
     * Restituisce tutti i tornei in cui si è iscritto un dato Partecipante
     * @param $utente_id l'id del partecipante per la ricerca
     * @return array una lista di tornei (riferimento)
     */
    public function &getTorneiDaPartecipante($partecipante_id) {

        $query = "select
            tornei.id tornei_id,
            tornei.organizzatore_id tornei_organizzatore_id,
            tornei.data_inizio tornei_data_inizio,
            tornei.nome tornei_nome,
            tornei.luogo tornei_luogo,
            tornei.indirizzo tornei_indirizzo,
            tornei.disciplina tornei_disciplina,
            tornei.tipologia tornei_tipologia,
            tornei.min_partecipanti tornei_min_partecipanti,
            tornei.max_partecipanti tornei_max_partecipanti
                              
            from tornei 
            join iscrizioni on tornei.id = iscrizioni.torneo_id 
            where iscrizioni.partecipante_id = ?";

        $input_bindings = array($partecipante_id);

        $input_bind_format = 'i';

        $output_bindings = array('tornei_id', 'tornei_organizzatore_id',
            'tornei_data_inizio', 'tornei_nome', 'tornei_luogo',
            'tornei_indirizzo', 'tornei_disciplina', 'tornei_tipologia', 
            'tornei_min_partecipanti', 'tornei_max_partecipanti');

        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);

        $tornei = $this->creaTornei($result);

        return $tornei;
    }
        
    public function caricaIscritti($torneo_id) {
        
        $query = "select 
            utenti.id utenti_id,
            utenti.ruolo utenti_ruolo,
            utenti.username utenti_username,
            utenti.password utenti_password,
            utenti.nome utenti_nome,
            utenti.cognome utenti_cognome,
            utenti.email utenti_email
            
            from utenti 
            join iscrizioni on utenti.id = iscrizioni.partecipante_id 
            where iscrizioni.torneo_id = ?";
        
        $input_bindings = array($torneo_id);
        
        $input_bind_format = 'i';

        $output_bindings = array('utenti_id', 'utenti_ruolo',
            'utenti_username', 'utenti_password',
            'utenti_nome', 'utenti_cognome', 'utenti_email');

        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        $utenti = array();
        foreach ($result as $row) {
            $utente = new Utente();
            $utente->setId($row['utenti_id']);
            $utente->setRuolo($row['utenti_ruolo']);
            $utente->setUsername($row['utenti_username']);
            $utente->setPassword($row['utenti_password']);
            $utente->setNome($row['utenti_nome']);
            $utente->setCognome($row['utenti_cognome']);
            $utente->setEmail($row['utenti_email']);
            
            $utenti[] = $utente;
        }
        
        return $utenti;
    }
    
    public function caricaRisultati($torneo_id) {
        
        return RisultatoFactory::instance()->getRisultatiDaTorneo($torneo_id);
    }
    
    public function salva(Torneo $torneo) {
        
        $query = "update tornei set
            organizzatore_id = ?,
            data_inizio = ?
            nome = ?,
            luogo = ?,
            indirizzo = ?,
            disciplina = ?,
            tipologia = ?,
            min_partecipanti = ?,
            max_partecipanti = ?
            where tornei.id = ?";

        return $this->modificaDB($torneo, $query);
    }
  
    public function nuovo(Torneo $torneo) {
        
        $query = "insert into tornei (organizzatore_id, data_inizio, nome, luogo, 
            indirizzo, disciplina, tipologia, min_partecipanti, max_partecipanti, id)
            values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        return $this->modificaDB($torneo, $query);
    }
    
    public function cancella(Torneo $torneo) {
        
        $query = "delete from tornei where 
            organizzatore_id = ? and
            data_inizio = ? and
            nome = ? and
            luogo = ? and
            indirizzo = ? and
            disciplina = ? and
            tipologia = ? and
            min_partecipanti = ? and
            max_partecipanti = ? and
            id = ?";
        
        return $this->modificaDB($torneo, $query);
    }
    
    private function modificaDB(Torneo $torneo, $query) {

        $input_bindings = array($torneo->getOrganizzatoreId(), $torneo->getDataInizio()->format('Y-m-d'), 
            $torneo->getNome(), $torneo->getLuogo(), $torneo->getIndirizzo(),
            $torneo->getDisciplina(), $torneo->getTipologia(), 
            $torneo->getMinPartecipanti(), $torneo->getMaxPartecipanti(), $torneo->getId());
        
        $input_bind_format = 'issssssiii';
        
        $output_bindings = NULL;
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        return $result;      
    }
    
    public function aggiungiIscrizione(Utente $utente, Torneo $torneo) {
        
        $query = "insert into iscrizioni (partecipante_id, torneo_id) values (?, ?)";
        
        $input_bindings = array($utente->getId(), $torneo->getId());
        
        $input_bind_format = 'ii';
        
        $output_bindings = NULL;
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        return $result;
    }

    public function cancellaIscrizione(Utente $utente, Torneo $torneo) {
        
        $query = "delete from iscrizioni where partecipante_id = ? and torneo_id = ?";
        
        $input_bindings = array($utente->getId(), $torneo->getId());
        
        $input_bind_format = 'ii';
        
        $output_bindings = NULL;
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        return $result;
    }
    
    /**
     * Salva un elenco di tornei sul DB
     * @param ElencoTornei $elenco l'elenco di tornei da inserire
     * @return boolean true se il salvataggio va a buon fine, false altrimenti
     */
    public function salvaElenco(ElencoTornei $elenco) {
        
        $query = "insert into tornei (id, organizzatore_id, data_inizio, nome, luogo, 
            indirizzo, disciplina, tipologia, min_partecipanti, max_partecipanti)
            values (default, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salvaElenco] impossibile inizializzare il database");
            $mysqli->close();
            return false;
        }
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaElenco] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return false;
        }
        
        $organizzatore_id = $elenco->getTemplate()->getOrganizzatoreId();
        $data_inizio = new DateTime();
        $nome = '';
        $luogo = $elenco->getTemplate()->getLuogo();
        $indirizzo = $elenco->getTemplate()->getIndirizzo();
        $disciplina = $elenco->getTemplate()->getDisciplina();
        $tipologia = $elenco->getTemplate()->getTipologia(); 
        $min_partecipanti = $elenco->getTemplate()->getMinPartecipanti();
        $max_partecipanti = $elenco->getTemplate()->getMaxPartecipanti();
        
        if (!$stmt->bind_param('issssssii', $organizzatore_id, $data_inizio,
                $nome, $luogo, $indirizzo, $disciplina, $tipologia,
                $min_partecipanti, $max_partecipanti)) {
            error_log("[salvaElenco] impossibile" .
                    " effettuare il binding in input stmt");
            $mysqli->close();
            return false;
        }
        
        // inizio la transazione
        $mysqli->autocommit(false);

        foreach ($elenco->getTornei() as $torneo) {
            // inserisco un torneo

            $data_inizio = $torneo->getDataInizio()->format('Y-m-d');
            $nome = $torneo->getNome();
            
            if (!$stmt->execute()) {
                error_log("[salvaElenco] impossibile" .
                        " eseguire lo statement");
                $mysqli->rollback();
                $mysqli->close();
                return false;
            }
        }

        // tutto ok, posso rendere persistente il salvataggio
        $mysqli->commit();
        $mysqli->autocommit(true);
        $mysqli->close();

        return true;
    }
    
    public function &ricercaTornei($nome, $disciplina, $tipologia) {
        
        $input_bindings = array();
                      
        $where = "";
        $input_bind_format = "";
                
        if(isset($nome)) {
            $where .= ($where == "") ? ("where ") : (" and ");
            $where .= "lower(tornei.nome) like lower(?)";
            $input_bind_format .= "s";
            $input_bindings[] = "%".$nome."%";
        }
        
        if(isset($disciplina)) {
            $where .= ($where == "") ? ("where ") : (" and ");
            $where .= "lower(tornei.disciplina) like lower(?)";
            $input_bind_format .= "s";
            $input_bindings[] = "%".$disciplina."%";
        }
        
        if(isset($tipologia)) {
            $where .= ($where == "") ? ("where ") : (" and ");
            $where .= "lower(tornei.tipologia) like lower(?)";
            $input_bind_format .= "s";
            $input_bindings[] = "%".$tipologia."%";
        }

        $query = "select 
            tornei.id tornei_id, 
            tornei.organizzatore_id tornei_organizzatore_id, 
            tornei.data_inizio tornei_data_inizio,
            tornei.nome tornei_nome, 
            tornei.luogo tornei_luogo, 
            tornei.indirizzo tornei_indirizzo, 
            tornei.disciplina tornei_disciplina, 
            tornei.tipologia tornei_tipologia,
            tornei.min_partecipanti tornei_min_partecipanti, 
            tornei.max_partecipanti tornei_max_partecipanti
            
            from tornei 
            ".$where;

        $output_bindings = array('tornei_id', 'tornei_organizzatore_id', 
            'tornei_data_inizio', 'tornei_nome', 'tornei_luogo',
            'tornei_indirizzo', 'tornei_disciplina', 'tornei_tipologia', 
            'tornei_min_partecipanti', 'tornei_max_partecipanti');

        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);

        $tornei = $this->creaTornei($result);
        
        return $tornei;
    }
    
    public function creaTornei($result) {
        $tornei = array();
        foreach ($result as $row) {
            $torneo = new Torneo();
            $torneo->setId($row['tornei_id']);
            $torneo->setOrganizzatoreId($row['tornei_organizzatore_id']);
            $torneo->setDataInizio(new DateTime($row['tornei_data_inizio']));
            $torneo->setNome($row['tornei_nome']);
            $torneo->setLuogo($row['tornei_luogo']);
            $torneo->setIndirizzo($row['tornei_indirizzo']);
            $torneo->setDisciplina($row['tornei_disciplina']);
            $torneo->setTipologia($row['tornei_tipologia']);
            $torneo->setMinPartecipanti($row['tornei_min_partecipanti']);
            $torneo->setMaxPartecipanti($row['tornei_max_partecipanti']);
            
            $torneo->setIscritti($this->caricaIscritti($torneo->getId()));
            $torneo->setRisultati($this->caricaRisultati($torneo->getId()));
            
            $tornei[] = $torneo;
        }
        return $tornei;
    }


}

?>
<?php

include_once 'Utente.php';
include_once 'Db.php';


/**
 * Classe per la creazione degli utenti del sistema
 *
 * @author Stefania Grasso
 */
class UtenteFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restiuisce un singleton per creare utenti
     * @return \UtenteFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new UtenteFactory();
        }

        return self::$singleton;
    }
       
    /**
     * Cerca un utente tramite username e password
     * @param string $username
     * @param string $password
     * @return Utente un oggetto Utente nel caso sia stato trovato,
     * NULL altrimenti
     */
    public function getUtente($username, $password) {

        $query = "select
            utenti.id utenti_id,
            utenti.username utenti_username,
            utenti.password utenti_password,
            utenti.nome utenti_nome,
            utenti.cognome utenti_cognome,
            utenti.email utenti_email,
            utenti.ruolo utenti_ruolo
            
            from utenti 
            where utenti.username = ? and utenti.password = ?";

        $input_bindings = array($username, $password);
        
        $input_bind_format = 'ss';
        
        $output_bindings = array('utenti_id', 'utenti_username', 'utenti_password',
                                 'utenti_nome', 'utenti_cognome', 'utenti_email', 'utenti_ruolo');
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        $utente = NULL;
        foreach ($result as $row) { 
            $utente = new Utente();
            $utente->setId($row['utenti_id']);
            $utente->setUsername($row['utenti_username']);
            $utente->setPassword($row['utenti_password']);
            $utente->setNome($row['utenti_nome']);
            $utente->setCognome($row['utenti_cognome']);
            $utente->setEmail($row['utenti_email']);
            $utente->setRuolo($row['utenti_ruolo']);
        }
        return $utente;
    }
    
    /**
     * Cerca un utente tramite il proprio ruolo
     * @param string $ruolo
     * @return Utente un oggetto Utente nel caso sia stato trovato,
     * NULL altrimenti
     */
    public function getUtenteDaRuolo($ruolo) {

        $query = "select
            utenti.id utenti_id,
            utenti.username utenti_username,
            utenti.password utenti_password,
            utenti.nome utenti_nome,
            utenti.cognome utenti_cognome,
            utenti.email utenti_email,
            utenti.ruolo utenti_ruolo
            
            from utenti 
            where utenti.ruolo = ?";

        $input_bindings = array($ruolo);
        
        $input_bind_format = 's';
        
        $output_bindings = array('utenti_id', 'utenti_username', 'utenti_password',
                                 'utenti_nome', 'utenti_cognome', 'utenti_email', 'utenti_ruolo');
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        $utente = NULL;
        foreach ($result as $row) { 
            $utente = new Utente();
            $utente->setId($row['utenti_id']);
            $utente->setUsername($row['utenti_username']);
            $utente->setPassword($row['utenti_password']);
            $utente->setNome($row['utenti_nome']);
            $utente->setCognome($row['utenti_cognome']);
            $utente->setEmail($row['utenti_email']);
            $utente->setRuolo($row['utenti_ruolo']);
        }
        return $utente;
    }
      
    /**
     * Seleziona tutti gli utenti tramite il proprio ruolo
     * @param string $ruolo
     * @return array una lista di utenti (riferimento)
     */
    public function &getUtentiDaRuolo($ruolo) {

        $query = "select
            utenti.id utenti_id,
            utenti.username utenti_username,
            utenti.password utenti_password,
            utenti.nome utenti_nome,
            utenti.cognome utenti_cognome,
            utenti.email utenti_email,
            utenti.ruolo utenti_ruolo
            
            from utenti 
            where utenti.ruolo = ?";

        $input_bindings = array($ruolo);
        
        $input_bind_format = 's';
        
        $output_bindings = array('utenti_id', 'utenti_username', 'utenti_password',
                                 'utenti_nome', 'utenti_cognome', 'utenti_email', 'utenti_ruolo');
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        $utenti = array();
        foreach ($result as $row) { 
            $utente = new Utente();
            $utente->setId($row['utenti_id']);
            $utente->setUsername($row['utenti_username']);
            $utente->setPassword($row['utenti_password']);
            $utente->setNome($row['utenti_nome']);
            $utente->setCognome($row['utenti_cognome']);
            $utente->setEmail($row['utenti_email']);
            $utente->setRuolo($row['utenti_ruolo']);
            
            $utenti[] = $utente;
        }
        return $utenti;
    }

    /**
     * Cerca un utente tramite id
     * @param int $id
     * @return Utente un oggetto Utente nel caso sia stato trovato,
     * NULL altrimenti
     */
    public function getUtenteDaId($id) {

        $query = "select
            utenti.id utenti_id,
            utenti.username utenti_username,
            utenti.password utenti_password,
            utenti.nome utenti_nome,
            utenti.cognome utenti_cognome,
            utenti.email utenti_email,
            utenti.ruolo utenti_ruolo
            
            from utenti 
            where utenti.id = ?";

        $input_bindings = array($id);
        
        $input_bind_format = 'i';
        
        $output_bindings = array('utenti_id', 'utenti_username', 'utenti_password',
                                 'utenti_nome', 'utenti_cognome', 'utenti_email',  'utenti_ruolo');
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        $utente = NULL;
        foreach ($result as $row) {
            $utente = new Utente();
            $utente->setId($row['utenti_id']);
            $utente->setUsername($row['utenti_username']);
            $utente->setPassword($row['utenti_password']);
            $utente->setNome($row['utenti_nome']);
            $utente->setCognome($row['utenti_cognome']);
            $utente->setEmail($row['utenti_email']);
            $utente->setRuolo($row['utenti_ruolo']);
        }
        return $utente;
    }
    
    public function nuovo(Utente $utente){
        $query = "insert into utenti (ruolo, username, password, nome, cognome, email, id)
            values (?, ?, ?, ?, ?, ?, ?)";
        
        return $this->modificaDB($utente, $query);
    }
    
    public function cancella(Utente $utente){
        $query = "delete from utenti where 
            ruolo = ? and
            username = ? and
            password = ? and
            nome = ? and
            cognome = ? and
            email = ? and
            id = ?";
        
        return $this->modificaDB($utente, $query);
    }
     
    private function modificaDB(Utente $utente, $query){

        $input_bindings = array($utente->getRuolo(), $utente->getUsername(), $utente->getPassword(), 
            $torneo->getNome(), $utente->getCognome(), $utente->getEmail(), $utente->getId());
        
        $input_bind_format = 'ssssssi';
        
        $output_bindings = NULL;
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        return $result;      
    }
    
    /**
     * Salva i dati relativi ad un utente sul db
     * @param User $user
     * @return il numero di righe modificate
     */
    public function salva(Utente $user) {
 
        $query = "update utenti set
            username = ?,
            password = ?,
            nome = ?,
            cognome = ?,
            email = ?,
            ruolo = ?
            
            where utenti.id = ?";
        
        $input_bindings = array($user->getUsername(),
            $user->getPassword(), $user->getNome(), $user->getCognome(),
            $user->getEmail(), $user->getRuolo(), $user->getId());
        
        $input_bind_format = 'ssssssi';
        
        $output_bindings = NULL;
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        return $result;
    }

}

?>

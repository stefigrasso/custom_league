<?php

/**
 * Classe che rappresenta un generico utente del sistema
 */
class Utente {
    
    /**
     * Identificatore dell'utente
     * @var int
     */
    private $id;
    
    /**
     * Il ruolo dell'utente nell'applicazione.
     * Utilizzato per implementare il controllo degli accessi
     * @var string
     */
    private $ruolo;
    
    /**
     * Username per l'autenticazione
     * @var string
     */
    private $username;
    
    /**
     * Password per l'autenticazione
     * @var string
     */
    private $password;
    
    /**
     * Nome dell'utente
     * @var string
     */
    private $nome;
    
    /**
     * Cognome dell'utente
     * @var string 
     */
    private $cognome;
    
    /** 
     * Email dell'utente
     * @var string
     */
    private $email;
    
    /**
     * Lista di ruoli di un utente
     * @var array 
     */
    private $ruoli;
    
    
    /**
     * Costruttore
     */
    public function __construct() {
        $this->ruoli = array("amm" => "amministratore", "org" => "organizzatore", "part" => "partecipante");
    }
    
    /**
     * Restituisce un identificatore unico per l'utente
     * @return int
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Imposta un identificatore unico per l'utente
     * @param int $id
     * @return boolean true se il valore e' stato impostato correttamente,
     * false altrimenti
     */
    public function setId($id){
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(isset($intVal)) {
            $this->id = $intVal;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce il ruolo dell'utente
     * @return string
     */
    public function getRuolo() {
        return $this->ruolo;
    }

    /**
     * Imposta un ruolo per un dato utente
     * @param string $ruolo
     * @return boolean true se il valore e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setRuolo($ruolo) {
        
        switch ($ruolo) {
            case 'organizzatore':
            case 'partecipante':
            case 'amministratore':
                $this->ruolo = $ruolo;
                return true;
            default:
                return false;
        }
    }

    /**
     * Restituisce lo username dell'utente
     * @return string
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * Imposta lo username per l'autenticazione dell'utente. 
     * I nomi che si ritengono validi contengono solo lettere maiuscole e minuscole.
     * La lunghezza del nome deve essere superiore a 5
     * @param string $username
     * @return boolean true se lo username e' ammissibile ed e' stato impostato,
     * false altrimenti
     */
    public function setUsername($username) {
        $this->username = $username;
        return true;
    }

    /**
     * Restituisce la password per l'utente corrente
     * @return string
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Imposta la password per l'utente corrente.
     * La password si ritiene valida se è alfanumerica e
     * ha una lunghezza superiore a 4
     * @param string $password
     * @return boolean true se la password e' stata impostata correttamente,
     * false altrimenti
     */
    public function setPassword($password) {
        // utilizza la funzione filter var specificando un'espressione regolare
        // che implementa la validazione personalizzata
        if (filter_var($password, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[a-zA-Z0-9]{4,}/')))) {
            $this->password = $password;
            return true;
        }
        return false;
    }

    /**
     * Restituisce il nome dell'utente
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Imposta il nome dell'utente
     * @param string $nome
     * @return boolean true se il nome e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setNome($nome) {
        $this->nome = $nome;
        return true;
    }

    /**
     * Restituisce il cognome dell'utente
     * @return string
     */
    public function getCognome() {
        return $this->cognome;
    }

    /**
     * Imposta il cognome dell'utente
     * @param string $cognome
     * @return boolean true se il cognome e' stato impostato correttamente,
     * false altrimenti
     */
    public function setCognome($cognome) {
        $this->cognome = $cognome;
        return true;
    }

    /**
     * Restituisce l'email dell'utente
     * @return string
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Imposta l'email dell'utente
     * @param string $email l'email dell'utente
     * @return boolean true se l'email e' valida ed e' stata impostata,
     * false altrimenti
     */
    public function setEmail($email) {
        // utilizza la funzione filter var che implementa la validazione di una email
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->email = $email;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce la lista di ruoli (per riferimento)
     * @return array
     */
    public function &getRuoli() {
        return $this->ruoli;
    }
    
    /**
     * Compara due utenti, verificandone l'uguaglianza logica
     * @param Utente $utente l'utente con cui comparare $this
     * @return boolean true se i due oggetti sono logicamente uguali, 
     * false altrimenti
     */
    public function equals(Utente $utente) {

        return  $this->id == $utente->id;
    }

}
?>
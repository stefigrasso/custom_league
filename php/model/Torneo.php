<?php

include_once 'Utente.php';

/**
 * Classe che rappresenta un torneo
 */
class Torneo {
    
    const MIN_RANGE = 2;

    /**
     * Identificatore del torneo
     * @var int
     */
    private $id;
  
    /**
     * Id dell'organizzatore del torneo
     * @var int
     */
    private $organizzatore_id;
    
    /**
     * La data di inizio del torneo
     * @var DateTime 
     */
    private $data_inizio;
    
    /**
     * Nome del torneo
     * @var string
     */
    private $nome;
    
    /**
     * Il luogo del torneo
     * @var string
     */
    private $luogo;
    
    /**
     * Indirizzo del luogo del torneo
     * @var string
     */
    private $indirizzo;
    
    /**
     * La disciplina di un torneo
     * @var string
     */
    private $disciplina;
    
    /**
     * La tipologia del torneo
     * @var string
     */
    private  $tipologia;
    
    /**
     * Il numero minimo di partecipanti ad un torneo
     * @var int
     */
    private $min_partecipanti;
    
    /**
     * Il numero massimo di partecipanti ad un torneo
     * @var int
     */
    private $max_partecipanti;

    /**
     * Lista degli iscritti
     * @var array 
     */
    private $iscritti;

    /**
     * Lista dei risultati
     * @var array 
     */
    private $risultati;
    
    /**
     * Lista di tipologie del torneo
     * @var array 
     */
    private $tipologie;

    
    /**
     * Costruttore
     */
    public function __construct() {
        $this->iscritti = array();
        $this->risultati = array();
        $this->tipologie = array("girone_it" => "Girone italiano", "elim_diretta" => "Eliminazione diretta");
    }
    
    /**
     * Restituisce un identificatore unico per il torneo
     * @return int
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Imposta un identificatore unico per il torneo
     * @param int $id l'id del torneo
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
     * Restituisce l'id dell'organizzatore del torneo
     * @return int $organizzatore_id
     */
    public function getOrganizzatoreId() {
        return $this->organizzatore_id;
    }

    /**
     * Imposta l'id dell'organizzatore del torneo
     * @param int $organizzatore_id l'id dell'organizzatore
     * @return boolean true se l'id dell'utente e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setOrganizzatoreId($organizzatore_id) {
        $intVal = filter_var($organizzatore_id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(isset($intVal)) {
            $this->organizzatore_id = $intVal;
            return true;
        }
        return false;
    }
        
    /**
     * Restituisce la data di inizio del Torneo
     * @return DateTime
     */
    public function getDataInizio() {
        return $this->data_inizio;
    }

    /**
     * Modifica il valore della data di inizio del torneo
     * @param DateTime $data_inizio il nuovo valore della data
     * @return boolean true se il nuovo valore della data e' stato impostato,
     * false nel caso il valore non sia ammissibile
     */
    public function setDataInizio(DateTime $data_inizio) {        
        $this->data_inizio = $data_inizio;
        return true;
    }
    
    /**
     * Restituisce il nome del torneo
     * @return string
     */
    public function getNome() {
        return $this->nome;
    }

    /**
     * Imposta il nome del torneo
     * @param string $nome
     * @return boolean true se il nome e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setNome($nome) {
        if(isset($nome) && ($nome != '')) {
            $this->nome = $nome;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce il luogo del torneo
     * @return string
     */
    public function getLuogo() {
        return $this->luogo;
    }

    /**
     * Imposta il luogo del torneo
     * @param string $luogo
     * @return boolean true se il luogo e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setLuogo($luogo) {
        if(isset($luogo) && ($luogo != '')) {
            $this->luogo = $luogo;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce l'indirizzo del torneo
     * @return string
     */
    public function getIndirizzo() {
        return $this->indirizzo;
    }

    /**
     * Imposta l'indirizzo del torneo
     * @param string $indirizzo
     * @return boolean true se l'indirizzo e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setIndirizzo($indirizzo) {
        if(isset($indirizzo) && ($indirizzo != '')) {
            $this->indirizzo = $indirizzo;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce la disciplina del torneo
     * @return string
     */
    public function getDisciplina() {
        return $this->disciplina;
    }

    /**
     * Imposta la disciplina del torneo
     * @param string $disciplina
     * @return boolean true se la disciplina e' stato impostata correttamente, 
     * false altrimenti 
     */
    public function setDisciplina($disciplina) {
        if(isset($disciplina) && ($disciplina != '')) {
            $this->disciplina = $disciplina;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce la tipologia del torneo
     * @return string
     */
    public function getTipologia() {
        return $this->tipologia;
    }

    /**
     * Imposta la tipologia del torneo
     * @param string $nome
     * @return boolean true se la tipologia e' stata impostata correttamente, 
     * false altrimenti 
     */
    public function setTipologia($tipologia) {
        foreach ($this->tipologie as $sel_tipologia) {
            if ($tipologia == $sel_tipologia) {
                $this->tipologia = $tipologia;
                return true;
            }
        }
        return false;
    }
    
    /**
     * Restituisce il numero minimo di partecipanti ad un torneo
     * @return int
     */
    public function getMinPartecipanti() {
        return $this->min_partecipanti;
    }

    /**
     * Imposta il numero minimo di partecipanti ad un torneo
     * @param int $min_partecipanti
     * @return boolean true se il valore e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setMinPartecipanti($min_partecipanti) {
        $intVal = filter_var($min_partecipanti, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal) && ($min_partecipanti >= self::MIN_RANGE)) {
            $this->min_partecipanti = $intVal;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce il numero massimo di partecipanti ad un torneo
     * @return int
     */
    public function getMaxPartecipanti() {
        return $this->max_partecipanti;
    }

    /**
     * Imposta il numero massimo di partecipanti ad un torneo
     * @param int $max_partecipanti
     * @return boolean true se il valore e' stato impostato correttamente, 
     * false altrimenti 
     */
    public function setMaxPartecipanti($max_partecipanti) {
        $intVal = filter_var($max_partecipanti, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal) && ($max_partecipanti >= $this->min_partecipanti)) {
            $this->max_partecipanti = $intVal;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce il numero di partecipanti iscritti ad un torneo
     * @return int
     */
    public function getNumIscritti() {
        return count($this->iscritti);
    }
     
    /**
     * Restituisce la lista di iscritti (per riferimento)
     * @return array
     */
    public function &getIscritti() {
        return $this->iscritti;
    }
    
    /**
     * Iscrive una lista di partecipanti al torneo
     * @param array $iscritti lista di partecipanti da iscrivere
     * @return boolean true se l'iscrizione di tutti i partecipanti e' andata a buon fine, 
     * false altrimenti
     */
    public function setIscritti($iscritti) {
        $flag = false;
        if (count($iscritti) > $this->getPostiDisponibili()) {
            return false;
        }
        foreach ($iscritti as $iscritto) {
            if (!($this->iscrivi($iscritto))) {
                return false;
            } else {
                $flag = true;
            }
        }
        return $flag;
    }
    
    /**
     * Iscrive un partecipante al torneo
     * @param Utente $utente il partecipante da iscrivere
     * @return boolean true se l'iscrizione e' andata a buon fine, false altrimenti
     */
    public function iscrivi(Utente $utente) {      
        if (($this->getPostiDisponibili() <= 0) || ($this->isIscritto($utente))) {
            return false;
        }
        $this->iscritti[] = $utente;
        return true;
    }

    /**
     * Verifica se un partecipante sia gia' nella lista di iscritti o meno
     * @param Utente $utente l'utente da ricercare
     * @return boolean true se e' gia' in lista, false altrimenti
     */
    public function isIscritto(Utente $utente) {
        foreach ($this->iscritti as $iscritto) {
            if($iscritto->equals($utente)) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Rimuove l'iscrizione di un partecipante dal torneo.
     * @param Utente $utente l'utente da cancellare
     * @return boolean true se l'iscrizione e' stata cancellata, false altrimenti
     */
    public function cancellaIscrizioneUtente(Utente $utente) {
        if (in_array($utente, $this->iscritti)) {
            unset($this->iscritti[array_search($utente,$this->iscritti)]);
            return true;
        }
        return false;
    }
        
    /**
     * Restituisce il numero di posti disponibili in un torneo
     * @return int
     */
    public function getPostiDisponibili() {
        return ($this->max_partecipanti - $this->getNumIscritti());
    }
    
    /**
     * Restituisce la lista dei risultati (per riferimento)
     * @return array
     */
    public function &getRisultati() {
        return $this->risultati;
    }

    /**
     * Aggiunge una lista di risultati al torneo
     * @param array $risultati lista di risultati da inserire
     * @return boolean true se l'inserimento di tutti i risultati e' andata a buon fine, 
     * false altrimenti
     */
    public function setRisultati($risultati) {
        $flag = false;
        foreach ($risultati as $risultato) {
            if (!($this->aggiungiRisultato($risultato))) {
                return false;
            } else {
                $flag = true;
            }
        }
        return $flag;
    }

    /**
     * Aggiunge un risultato alla lista di tutti i risultati di un torneo
     * @param Risultato $risultato il risultato da aggiungere
     * @return boolean true se il risultato e' stato aggiunto, false altrimenti
     */
    public function aggiungiRisultato(Risultato $risultato) {
        $this->risultati[] = $risultato;
        return true;
    }
    
    /**
     * Restituisce la lista di tipologie (per riferimento)
     * @return array
     */
    public function &getTipologie() {
        return $this->tipologie;
    }

    /**
     * Restituisce la relazione di uguaglianza logica fra due Tornei
     * @param Torneo $other il Torneo con cui confrontare $this
     * @return boolean true se sono logicamente uguali, false altrimenti
     */
    public function equals(Torneo $other) {
        return $other->id == $this->id &&
               $other->nome == $this->nome;
    }
}

?>


<?php

/**
 * Classe che rappresenta il risultato di un torneo
 */
class Risultato {
        
    /**
     * Identificatore del risultato
     * @var int
     */
    private $id;
    
    /**
     * Il numero della giornata
     * @var int
     */
    private $giornata;
      
    /**
     * Identificatore del torneo
     * @var int
     */
    private $torneo_id;
    
    /**
     * Identificatore del primo partecipante del risultato
     * @var int
     */
    private $partecipanteA_id;
    
    /**
     * Identificatore del secondo partecipante del risultato
     * @var int
     */
    private $partecipanteB_id;
    
    /**
     * Punteggio del primo partecipante del risultato
     * @var int
     */
    private $punteggioA;
    
    /**
     * Punteggio del secondo partecipante del risultato
     * @var int
     */
    private $punteggioB;
    
    
    /**
     * Costruttore
     */
    public function __construct() {
    }
    
    /**
     * Restituisce un identificatore unico per il risultato
     * @return int
     */
    public function getId(){
        return $this->id;
    }
    
    /**
     * Imposta un identificatore unico per il risultato
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
     * Restituisce l'id del torneo a cui fa riferimento il risultato
     * @return int $torneo_id
     */
    public function getTorneoId() {
        return $this->torneo_id;
    }

    /**
     * Imposta l'identificatore del torneo a cui fa riferimento il risultato
     * @param int $torneo_id
     * @return boolean true se il valore e' stato impostato correttamente,
     * false altrimenti
     */
    public function setTorneoId($torneo_id){
        $intVal = filter_var($torneo_id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(isset($intVal)) {
            $this->torneo_id = $intVal;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce la giornata del risultato
     * @return int $giornata
     */
    public function getGiornata() {
        return $this->giornata;
    }

    /**
     * Modifica il valore della giornata del risultato
     * @param $giornata il nuovo valore della giornata
     * @return boolean true se il nuovo valore della giornata e' stato impostato,
     * false nel caso il valore non sia ammissibile
     */
    public function setGiornata($giornata) {
        $this->giornata = $giornata;
        return true;
    }
    
    /**
     * Restituisce l'id del primo partecipante del risultato
     * @return int $partecipanteA_id
     */
    public function getPartecipanteAId() {
        return $this->partecipanteA_id;
    }
        
    /**
     * Imposta l'id del primo partecipante del risultato
     * @param int $punteggioA
     * @return boolean true se il valore e' stato impostato correttamente,
     * false altrimenti
     */
    public function setPartecipanteAId($idA){
        $intVal = filter_var($idA, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(isset($intVal)) {
            $this->partecipanteA_id = $intVal;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce l'id del secondo partecipante del risultato
     * @return int $partecipanteB_id
     */
    public function getPartecipanteBId() {
        return $this->partecipanteB_id;
    }
          
    /**
     * Imposta l'id del secondo partecipante del risultato
     * @param int $punteggioB
     * @return boolean true se il valore e' stato impostato correttamente,
     * false altrimenti
     */
    public function setPartecipanteBId($idB){
        $intVal = filter_var($idB, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(isset($intVal)) {
            $this->partecipanteB_id = $intVal;
            return true;
        }
        return false;
    }

    /**
     * Restituisce il punteggio del primo partecipante del risultato
     * @return int $punteggioA
     */
    public function getPunteggioA() {
        return $this->punteggioA;
    }
    
    /**
     * Imposta il punteggio del primo partecipante del risultato
     * @param int $punteggioA
     * @return boolean true se il valore e' stato impostato correttamente,
     * false altrimenti
     */
    public function setPunteggioA($punteggioA){
        $intVal = filter_var($punteggioA, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(isset($intVal)) {
            $this->punteggioA = $intVal;
            return true;
        }
        return false;
    }
    
    /**
     * Restituisce il punteggio del secondo partecipante del risultato
     * @return int $punteggioB
     */
    public function getPunteggioB() {
        return $this->punteggioB;
    }
     
    /**
     * Imposta il punteggio del secondo partecipante del risultato
     * @param int $punteggioB
     * @return boolean true se il valore e' stato impostato correttamente,
     * false altrimenti
     */
    public function setPunteggioB($punteggioB){
        $intVal = filter_var($punteggioB, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(isset($intVal)) {
            $this->punteggioB = $intVal;
            return true;
        }
        return false;
    }
    
}


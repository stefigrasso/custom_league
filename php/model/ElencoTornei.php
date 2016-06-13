<?php

include_once 'Torneo.php';
/**
 * Classe che rappresenta un elenco di tornei da inserire da parte di un Organizzatore
 *
 * @author Stefania Grasso
 */
class ElencoTornei {

    
    /**
     * Un template per la costruzione di tornei da inserire in lista
     * (la lista di tornei e' omogenea, cioe' ha la stesso luogo e indirizzo)
     * @var Torneo
     */
    private $template;
    
    /**
     * La lista dei tornei inseriti
     * @var array
     */
    private $tornei;
    
    /**
     * Costruttore della lista di tornei
     * @var int un identificatore per la lista
     */
    private $id;

    public function __construct($id) {
        $this->id = intval($id);
        $this->template = new Torneo();
        $this->tornei = array();
    }
    
    /**
     * Restituisce il torneo che fa da matrice (luogo, indirizzo)
     * a tutti i tornei inseriti nella lista
     * @return Torneo
     */
    public function getTemplate(){
        return $this->template;
    }
    
    /**
     * Restituisce l'indentificatore unico 
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Aggiunge un torneo alla lista
     * @param Torneo $torneo il torneo da aggiungere
     * @return boolean true se il torneo e' stato aggiunto correttamente,
     * false se era gia' presente in lista e non e' stato aggiunto
     */
    public function aggiungiTorneo(Torneo $torneo) {
        $pos = $this->posizione($torneo);
        if($pos > -1){
            // torneo gia' inserito
            return false;
        }
        $this->tornei[] = $torneo;
        return true;
    }

    
    /**
     * Rimuove un torneo dalla lista
     * @param Torneo $torneo il torneo della lista
     * @return boolean true se il torneo e' stato rimosso, false altrimenti (es. 
     * non era in lista)
     */
    public function rimuoviTorneo(Torneo $torneo) {
        $pos = $this->posizione($torneo);
        echo var_dump($pos);
        if ($pos > -1) {
            array_splice($this->tornei, $pos, 1);
            return true;
        }

        return false;
    }

    
    /**
     * Restituisce la lista di tornei
     * @return array
     */
    public function &getTornei() {
        return $this->tornei;
    }

    /**
     * Trova la posizione di un torneo nella lista
     * @param Torneo $torneo il torneo da trovare
     * @return int la posizione del torneo se presente, false altrimenti
     */
    private function posizione(Torneo $torneo) {
        for ($i = 0; $i < count($this->tornei); $i++) {
            if ($this->tornei[$i]->equals($torneo)) {
                return $i;
            }
        }
        return -1;
    }

}

?>

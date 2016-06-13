<?php

include_once 'Risultato.php';

/**
 * Classe per creare oggetti di tipo Risultato
 *
 * @author Stefania Grasso
 */
class RisultatoFactory {

    private static $singleton;

    private function __constructor() {
        
    }

    /**
     * Restiuisce un singleton per creare risultati
     * @return \RisultatoFactory
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new RisultatoFactory();
        }

        return self::$singleton;
    }
    
    public function nuovo(Risultato $risultato){
        $query = "insert into risultati (giornata, torneo_id, partecipanteA_id, 
            partecipanteB_id, punteggioA, punteggioB, id)
            values (?, ?, ?, ?, ?, ?, ?)";
        
        return $this->modificaDB($risultato, $query);
    }
    
    public function cancella(Risultato $risultato){
        $query = "delete from risultati where 
            giornata = ? and
            torneo_id = ? and
            partecipanteA_id = ? and
            partecipanteB_id = ? and
            punteggioA = ? and
            punteggioB = ? and
            id = ?";
        
        return $this->modificaDB($risultato, $query);
    }
    
        public function modifica(Risultato $risultato){
        $query = "update risultati set
            giornata = ?,
            torneo_id = ?,
            partecipanteA_id = ?,
            partecipanteB_id = ?,
            punteggioA = ?,
            punteggioB = ?
            where risultati.id = ?";

        return $this->modificaDB($risultato, $query);
    }
    
    private function modificaDB(Risultato $risultato, $query){
   
        $input_bindings = array($risultato->getGiornata(), 
            $risultato->getTorneoId(), $risultato->getPartecipanteAId(), $risultato->getPartecipanteBId(),
            $risultato->getPunteggioA(), $risultato->getPunteggioB(), $risultato->getId());
        
        $input_bind_format = 'iiiiiii';
        
        $output_bindings = array();
        
        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);
        
        return $result;      
    }
        
    /**
     * Cerca un risultato tramite id
     * @param int $id
     * @return Risultato un oggetto Risultato nel caso sia stato trovato,
     * NULL altrimenti
     */
    public function getRisultatoDaId($id) {

        $query = "select 
            risultati.id risultati_id, 
            risultati.giornata risultati_giornata,
            risultati.torneo_id risultati_torneo_id, 
            risultati.partecipanteA_id risultati_partecipanteA_id, 
            risultati.partecipanteB_id risultati_partecipanteB_id, 
            risultati.punteggioA risultati_punteggioA,
            risultati.punteggioB risultati_punteggioB
                        
            from risultati 
            where risultati.id = ?";


        $input_bindings = array($id);

        $input_bind_format = 'i';

        $output_bindings = array('risultati_id', 'risultati_giornata', 
            'risultati_torneo_id', 'risultati_partecipanteA_id', 'risultati_partecipanteB_id',
            'risultati_punteggioA', 'risultati_punteggioB');

        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);

        $risultati = array();
        foreach ($result as $row) {
            $risultato = new Risultato();
            $risultato->setId($row['risultati_id']);
            $risultato->setGiornata($row['risultati_giornata']);
            $risultato->setTorneoId($row['risultati_torneo_id']);
            $risultato->setPartecipanteAId($row['risultati_partecipanteA_id']);
            $risultato->setPartecipanteBId($row['risultati_partecipanteB_id']);
            $risultato->setPunteggioA($row['risultati_punteggioA']);
            $risultato->setPunteggioB($row['risultati_punteggioB']);
            
            $risultati[] = $risultato;
        }

        if (count($risultati)>0) {
            return $risultati[0];
        } else {
            return $risultati;
        }
    }

    /**
     * Restituisce tutti i risultati inseriti di un dato torneo
     * @param $torneo_id l'id del torneo per la ricerca
     * @return array una lista di risultati (riferimento)
     */
    public function &getRisultatiDaTorneo($torneo_id) {

        $query = "select
            risultati.id risultati_id, 
            risultati.giornata risultati_giornata,
            risultati.torneo_id risultati_torneo_id, 
            risultati.partecipanteA_id risultati_partecipanteA_id, 
            risultati.partecipanteB_id risultati_partecipanteB_id, 
            risultati.punteggioA risultati_punteggioA,
            risultati.punteggioB risultati_punteggioB
            
            from risultati 
            where risultati.torneo_id = ?";

        $input_bindings = array($torneo_id);

        $input_bind_format = 'i';

        $output_bindings = array('risultati_id', 'risultati_giornata', 
            'risultati_torneo_id', 'risultati_partecipanteA_id', 'risultati_partecipanteB_id',
            'risultati_punteggioA', 'risultati_punteggioB');

        $result = Db::exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, __FUNCTION__);

        $risultati = array();
        foreach ($result as $row) {
            $risultato = new Risultato();
            $risultato->setId($row['risultati_id']);
            $risultato->setGiornata($row['risultati_giornata']);
            $risultato->setTorneoId($row['risultati_torneo_id']);
            $risultato->setPartecipanteAId($row['risultati_partecipanteA_id']);
            $risultato->setPartecipanteBId($row['risultati_partecipanteB_id']);
            $risultato->setPunteggioA($row['risultati_punteggioA']);
            $risultato->setPunteggioB($row['risultati_punteggioB']);
                        
            $risultati[] = $risultato;
        }
        
        return $risultati;
    }

    
}

?>

<?php
include_once basename(__DIR__) . '/../Settings.php';

/**
 * Descrizione del Database
 *
 * @author Stefania Grasso
 */
class Db {
    
    // messaggi di errore
    const E_CONNECT = "[%s] impossibile connettersi al database";
    const E_STMT_INIT = "[%s] impossibile inizializzare il prepared statement";
    const E_STMT_BIND_INPUT = "[%s] impossibile effettuare il binding in input";
    const E_STMT_BIND_OUTPUT = "[%s] impossibile effettuare il binding in output";
    const E_STMT_EXEC = "[%s] impossibile eseguire lo statement";
    
    private function __construct() {
        
    }
    
    private static $singleton;
    /**
     *  Restituisce un singleton per la connessione al Db
     * @return \Db
     */
    public static function getInstance(){
        if(!isset(self::$singleton)){
            self::$singleton = new Db();
        }
        
        return self::$singleton;
    }
    
    /**
     * Restituisce una connessione funzionante al db
     * @return \mysqli una connessione funzionante al db dell'applicazione,
     * null in caso di errore
     */
    public function connectDb(){
        $mysqli = new mysqli();
        $mysqli->connect(Settings::$db_host, Settings::$db_user,
        Settings::$db_password, Settings::$db_name);
        if($mysqli->errno != 0){
            return null;
        }else{
            return $mysqli;
        }
    }
    
    public static function exec_stmt($query, $input_bindings, $input_bind_format, $output_bindings, $caller) {
        
        $mysqli = self::getInstance()->connectDb();
        $result = NULL;
        
        if (!isset($mysqli)) {
            error_log(sprintf(self::E_CONNECT, $caller));
            $mysqli->close();
            return NULL;
        }

        $stmt = $mysqli->stmt_init();

        $stmt->prepare($query);
        
        if (!$stmt) {
            error_log(sprintf(self::E_STMT_INIT, $caller));
            $mysqli->close();
            return NULL;
        }

        // parametri per la funzione stmt->bind_param()
        $temp = array_merge(array(& $input_bind_format), $input_bindings);
        foreach ($temp as $key => $val) {
            $func_param[] = & $temp[$key];
        }

        // 'call_user_func_array' permette di chiamare una funzione con un
        // numero variabile di argomenti utilizzando un array.
        // Per chiamare un metodo di una classe, i parametri sono:
        // (array($OGGETTO, 'NOME_FUNZIONE'), $PARAM_FUNZIONE).
        // Nota: in alcuni casi i parametri della funzione devono essere
        // passati per referenza
        if (count($input_bindings) > 0) {
            if (!call_user_func_array(array($stmt, 'bind_param'), $func_param)) {
                error_log(sprintf(self::E_STMT_BIND_INPUT, $caller));
                $mysqli->close();
                return NULL;
            }
        }

        if (!$stmt->execute()) {
            error_log(sprintf(self::E_STMT_EXEC, $caller));
            $stmt->close();
            $mysqli->close();
            return NULL;
        }
        //strtok è una funzione che estrae da una stringa la prima sottostringa delimitata dal carattere specificato
        //serve per differenziare i tipi di query
        $tipo_query = trim(strtok($query, ' '));
        switch ($tipo_query) {
            case 'update':
            case 'insert':
            case 'delete':
                $result = $stmt->affected_rows;
                break;
            case 'select':
                $row = array();
                $func_param = array();
                foreach ($output_bindings as $key) {
                    $func_param[] = & $row[$key];
                }
                
                $bind = call_user_func_array(array($stmt, 'bind_result'), $func_param);
 
                if (!$bind) {
                    error_log(sprintf(self::E_STMT_BIND_OUTPUT, $caller));
                    $stmt->close();
                    $mysqli->close();
                    return NULL;
                }
                
                // non si può usare row direttamente perché è una referenza
                $result = array();
                while ($stmt->fetch()) {
                    $newrow = array();
                    foreach ($row as $col => $val) {
                        $newrow[$col] = $val;
                    }
                    $result[] = $newrow;

                }
                break;
                
            default:
                break;
        }
        
        $stmt->close();
        $mysqli->close();
        
        return $result;
    }
}

?>

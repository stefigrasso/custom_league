<?php

/**
 * Classe che contiene una lista di variabili di configurazione
 *
 * @author Stefania Grasso
 */
class Settings {

    // variabili di accesso per il database
    public static $db_host = 'localhost';
    public static $db_user = 'grassoStefania';
    public static $db_password = 'pappagallo4121';
    public static $db_name='amm15_grassoStefania';
    
    private static $appPath;
    

    /**
     * Restituisce il path relativo nel server corrente dell'applicazione
     * Si usa perche' la configurazione locale e' diversa da quella pubblica.
     */
    public static function getApplicationPath() {
        if (!isset(self::$appPath)) {
            // restituisce il server corrente
            switch ($_SERVER['HTTP_HOST']) {
                case 'localhost':
                    // configurazione locale
                    self::$appPath = 'http://' . $_SERVER['HTTP_HOST'] . '/~stef/custom_league/';
                    break;
                case 'spano.sc.unica.it':
                    // configurazione pubblica
                    self::$appPath = 'http://' . $_SERVER['HTTP_HOST'] . '/amm2015/grassoStefania/custom_league';
                    break;

                default:
                    self::$appPath = '';
                    break;
            }
        }
        
        return self::$appPath;
    }

}

?>

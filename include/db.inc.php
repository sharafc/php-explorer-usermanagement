<?php
/**
 *	Stellt eine Verbindung zu einer Datenbank mittels PDO her
 *	Die Konfiguration und Zugangsdaten erfolgen über eine externe Konfigurationsdatei
 *
 * @param string $dbname Name der zu verbindenden Datenbank
 * @return object $dbo DB-Verbindungsobjekt
 */
function dbConnect($dbname = DB_NAME)
{
    if (DEBUG_DB) {
        echo "<p class='debugDb'><b>Line " . __LINE__ . ":</b> Versuche mit der DB <b>$dbname</b> zu verbinden... <i>(" . basename(__FILE__) . ")</i></p>\r\n";
    }

    try {
        // $pdo = new PDO("mysql:host=localhost; dbname=market; charset=utf8mb4", "root", "");
        $pdo = new PDO(DB_SYSTEM . ":host=" . DB_HOST . "; dbname=$dbname; charset=utf8mb4", DB_USER, DB_PWD);
    } catch (PDOException $error) {
        if (DEBUG_DB) {
            echo "<p class='error'><b>Line " . __LINE__ . ":</b> <i>FEHLER: " . $error->GetMessage() . " </i> <i>(" . basename(__FILE__) . ")</i></p>\r\n";
        }
        exit;
    }

    if (DEBUG_DB){
        echo "<p class='debugDb ok'><b>Line " . __LINE__ . ":</b> Erfolgreich mit der DB <b>$dbname</b> verbunden. <i>(" . basename(__FILE__) . ")</i></p>\r\n";
    }

    return $pdo;
}

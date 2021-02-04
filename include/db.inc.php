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
    try {
        // $pdo = new PDO("mysql:host=localhost; dbname=market; charset=utf8mb4", "root", "");
        $pdo = new PDO(DB_SYSTEM . ":host=" . DB_HOST . "; dbname=$dbname; charset=utf8mb4", DB_USER, DB_PWD);
    } catch (PDOException $error) {
        logger('PDO Exception', $error->GetMessage());
        exit;
    }
    return $pdo;
}

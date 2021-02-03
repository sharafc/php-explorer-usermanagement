<?php

/**
 * 	Wandelt ein ISO Datums-/Uhrzeitformat in ein europäisches Datums-/Uhrzeitformat um
 *	und separiert Datum von Uhrzeit (ohne Sekunden)
 *
 * 	@param String Das ISO Datum/Uhrzeit
 *
 * 	@return Array (String "date", String "time")		Das EU-Datum plus die Uhrzeit
 */
function isoToEuDateTime($value)
{
    if ($value) {
        // mögliche Übernahmewerte
        // 2018-05-17 14:17:48
        // 2018-05-17

        // gewünschte Ausgabewerte
        // 17.05.2018	// 14:17
        // 17.05.2018

        // Prüfen, ob $value eine Uhrzeit enthält
        if (strpos($value, " ")) {
            // Datum und Uhrzeit auftrennen
            $dateTimeArray = explode(" ", $value);

            $date = $dateTimeArray[0];

            // Datum in Einzelteile (Tag,Monat,Jahr) zerlegen
            $dateArray = explode("-", $date);

            $time = $dateTimeArray[1];
            // Sekunden abschneiden
            $time = substr($time, 0, 5);
        } else {

            // Datum in Einzelteile (Tag,Monat,Jahr) zerlegen
            $dateArray = explode("-", $value);
            $time = NULL;
        }

        // Datum umformatieren
        $euDate = "$dateArray[2].$dateArray[1].$dateArray[0]";
    } else {
        // NULL-Werte in Array-Indizes schreiben
        $euDate = NULL;
        $time = NULL;
    }

    // Datum und Uhrzeit getrennt zurückgeben
    return array("date" => $euDate, "time" => $time);
}

/**
 * 	Wandelt ein EU/US/ISO-Datumsformat in ein ISO-Datumsformat um
 *
 * 	@param String 	Das EU/US/ISO-Datum
 *
 * 	@return String Das ISO-Datum
 */
function toIsoDate($value)
{
    if ($value) {
        // mögliche Übernahmewerte
        // 17.05.2018 | 05/17/2018 | 2018-05-17

        // gewünschte Ausgabewerte
        // 2018-05-17

        // Übergebenes Datumsformat prüfen
        if (stripos($value, ".")) {


            $dateArray = explode(".", $value);
            $day  = $dateArray[0];
            $month = $dateArray[1];
            $year = $dateArray[2];
        } elseif (stripos($value, "/")) {
            $dateArray = explode("/", $value);
            $day = $dateArray[1];
            $month = $dateArray[0];
            $year = $dateArray[2];
        } elseif (stripos($value, "-")) {
            $dateArray = explode("-", $value);
            $day = $dateArray[2];
            $month = $dateArray[1];
            $year = $dateArray[0];
        }
        $isoDate = "$year-$month-$day";
        return $isoDate;
    } else {
        return NULL;
    }
}

/**
 *	Prüft ein übergebenes ISO/US/EU-Datum auf Gültigkeit
 *
 *	@param String 	$value	- Das zu prüfende ISO/US/EU-Datum
 *
 *	@return Boolean 			- false bei falschem Format oder ungültigem Datum; ansonsten true
 */
function validateDate($value)
{
    $day         = NULL;
    $month     = NULL;
    $year     = NULL;

    if ($value) {
        // Datum auseinanderschneiden für checkdate()
        // ISO-Format
        if (stripos($value, "-")) {
            $dateArray = explode("-", $value);

            $day         = $dateArray[2];
            $month     = $dateArray[1];
            $year     = $dateArray[0];

            // EU-Format
        } elseif (stripos($value, ".")) {
            $dateArray = explode(".", $value);

            $day         = $dateArray[0];
            $month     = $dateArray[1];
            $year     = $dateArray[2];

            // US-Format
        } elseif (stripos($value, "/")) {
            $dateArray = explode("/", $value);

            $day         = $dateArray[1];
            $month     = $dateArray[0];
            $year     = $dateArray[2];
        }
    }

    // Datumsbestandteile auf Vollständigkeit prüfen und
    // Datum auf valides gregorianisches Datum prüfen
    if ((!$day or !$month or !$year) or !checkdate($month, $day, $year)) {
        // Fehlerfall
        return false;
    } else {
        // Erfolgsfall
        return true;
    }
}

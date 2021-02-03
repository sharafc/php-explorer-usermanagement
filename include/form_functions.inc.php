<?php
/**
 * Checks if a string is emtpy and is between 2 and 256 chars in length
 *
 * @param string $stringToCheck String to check if emtpy
 * @param integer $minLength (optional) minimum length of input
 * @param integer $maxLength (optional) maximum length of input
 * @return string $errorMessage Errormessage to display in the form
 */
function checkInputString($stringToCheck, $minLength = INPUT_MIN_LENGTH, $maxLength = INPUT_MAX_LENGTH)
{
    if ($stringToCheck === "") {
        $errorMessage = "Mandatory field";
    } elseif (mb_strlen($stringToCheck) <= $minLength) {
        $errorMessage = "Please enter more than 1 character";
    } elseif (mb_strlen($stringToCheck) > $maxLength) {
        $errorMessage = "Too long. Please check your input";
    } else {
        $errorMessage = NULL;
    }

    return $errorMessage;
}

/**
 * Checks for a valid email adress
 *
 * @param string $email the string to check for email validity
 * @return string $errorMessage Errormessage to display in the form
 */
function checkEmail($email)
{
    if ($email === "") {
        $errorMessage = "Mandatory field";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Not a valid email adress";
    } else {
        $errorMessage = NULL;
    }

    return $errorMessage;
}

/**
 * Checks for a valid plz
 *
 * @param string $plz the string to check for plz validity
 * @return string $errorMessage Errormessage to display in the form
 */
function checkPlz($plz)
{
    if ($plz === "") {
        $errorMessage = "Mandatory field";
    } elseif (mb_strlen($plz) != 5) {
        $errorMessage = "A valid PLZ contains of 5 numbers";
    } else {
        $errorMessage = NULL;
    }

    return $errorMessage;
}

/**
 * Check for a valid price
 *
 * @param string $price the string to check for plz validity
 * @return string $errorMessage Errormessage to display in the form
 */
function checkPrice($price)
{
    $pattern = '/^   [0-9]{1,3}   ([\.,]  [0-9]{1,2})?   $/ix';
    if (!preg_match($pattern, $price)) {
        // Fehlerfall
        $errorMessage = "Not a valid price";
    } else {
        $errorMessage = NULL;
    }

    return $errorMessage;
}

/**
 * Escapes and trims a given string
 *
 * @param string $stringToEscape String we want to escape
 * @return string $escapedString The escaped and trimmed string
 */
function cleanString($stringToEscape)
{
    $escapedString = trim(htmlspecialchars($stringToEscape, ENT_QUOTES | ENT_HTML5, "utf-8", false));
    return $escapedString;
}


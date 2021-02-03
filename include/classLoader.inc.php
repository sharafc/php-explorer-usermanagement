<?php

/**
 * Autoloader which loads Classes, Interfaces and Traits
 *
 * Needs the following defined constants to work:
 * TRAITS_PATH  -> Path to the directory containing traits
 * TRAIT_NAMES  -> Whitelist for traits
 * CLASSES_PATH -> Path to the directory containing Classes and Interfaces
 *
 * @see https://www.php.net/manual/en/function.spl-autoload-register.php
 *
 * @param string $name The name of the item to be loaded
 * @return void
 */
function autoloadClasses($name) {
    if (in_array($name, TRAIT_NAMES)){
        $path = TRAITS_PATH . $name . '.trait.php';
    } else {
        $path = CLASSES_PATH . $name . '.class.php';
    }

    if(file_exists($path)) {
        require_once($path);
    } else {
        logger('File in path ' . $path . ' not found');
    }
}

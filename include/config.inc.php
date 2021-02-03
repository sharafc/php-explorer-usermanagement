<?php
/** Form validation/handling */
define('INPUT_MIN_LENGTH', 2);
define('INPUT_MAX_LENGTH', 256);

define('MEDIA_TYPE_BOOK', 1);
define('MEDIA_TYPE_CD', 2);
define('MEDIA_TYPE_DVD', 3);
define('MEDIA_TYPE_BLURAY', 4);
define('MEDIA_TYPE_DIGITAL', 5);

/** Debugging */
define('DEBUG', false);    // Debugging für Hauptdokument ein-/ausschalten
define('DEBUG_F', false);  // Debugging für Funktionen ein-/ausschalten
define('DEBUG_DB', true);  // Debugging für Database
define('DEBUG_C', true);   // Debugging for classes
define('DEBUG_CC', true);  // Debugging for class constructors

/** Database */
define('DB_SYSTEM', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'customer_management');
define('DB_USER', 'root');
define('DB_PWD', '');

/* Errors */
define('LOGGER_FILE_PATH', 'logs' . DIRECTORY_SEPARATOR);
define('LOGGER_INFO', 'INFO');
define('LOGGER_WARNING', 'WARN');
define('LOGGER_ERROR', 'ERROR');

define('LOGGER_TYPE_OFF', 0);
define('LOGGER_TYPE_FILE', 1);
define('LOGGER_TYPE_SCREEN', 2);
define('LOGGER_TYPE_CONSOLE', 4);
define('LOGGER_TYPE_DEFAULT', LOGGER_TYPE_CONSOLE);

/* Preset paths */
define('MEDIA_DOWNLOADS_PATH', 'downloads/media/');

define('CLASSES_PATH', 'Class' . DIRECTORY_SEPARATOR);
define('TRAITS_PATH', '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'Traits' . DIRECTORY_SEPARATOR);
define('TRAIT_NAMES', ['autoConstruct']);

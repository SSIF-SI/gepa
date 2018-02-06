<?php

// COSTANTI
define ( "FRAMEWORK_PATH", "/var/www/common/frameworks/myFramework2.0/" );
define ( "FRAMEWORK_CLASS_PATH", FRAMEWORK_PATH . "class/" );

define ( "DOCUMENT_ROOT", dirname ( __DIR__ ) );
define ( "HTTP_ROOT", "/gepa/" );
define ( "REAL_ROOT", DOCUMENT_ROOT . HTTP_ROOT );
define ( "INCLUDE_PATH", REAL_ROOT . "include/" );
define ( "INCLUDE_HTTP_PATH", HTTP_ROOT . "include/" );
define ( "CLASS_PATH", REAL_ROOT . "class/" );

define ( "SCRIPTS_PATH", HTTP_ROOT . "scripts/" );
define ( "SCRIPTS_RPATH", REAL_ROOT . "scripts/" );
define ( "BUSINESS_PATH", REAL_ROOT . "business/" );
define ( "BUSINESS_HTTP_PATH", HTTP_ROOT . "business/" );
define ( "AJAX_PATH", HTTP_ROOT . "ajax/" );
define ( "AJAX_INCLUDE_PATH", REAL_ROOT . "/ajax/" );
define ( "VIEWS_PATH", REAL_ROOT . "views/" );
define ( "COMMON_PATH", REAL_ROOT . "common/" );

define ( "ADMIN_PATH", REAL_ROOT . "admin/" );
define ( "ADMIN_BUSINESS_PATH", BUSINESS_HTTP_PATH . "admin/" );
define ( "ADMIN_VIEWS_PATH", "admin/" );

define ( "ADMIN_SCRIPTS_PATH", HTTP_ROOT . "scripts/admin/" );
define ( "ADMIN_SCRIPTS_RPATH", REAL_ROOT . "scripts/admin/" );
define ( "LIB_PATH", HTTP_ROOT . "lib/" );

define ( "FILES_PATH", REAL_ROOT . "files/" );
define ( "FILES_HTTP_PATH", HTTP_ROOT . "files/" );

define ( "TEMPLATES_PATH", REAL_ROOT . "templates/" );

define ( "MAIL_FROM", "Gestione Pacchi <web-gestione-pacchi@isti.cnr.it>" );

define ( "HOST", "localhost" );
define ( "DB_ENGINE", "mysql" );
define ( "ROOT_USER", "pacchi" );
define ( "ROOT_PASSWORD", "!_p4cch1_!" );
define ( "ROOT_DATABASE", "gestione_pacchi" );

define ( "PAGE_TITLE_PREFIX", "Gestione Pacchi [TEST]" );
define ( "DB_DATE_FORMAT", "Y-m-d H:i:s" );
define ( "ACCESS_DENIED", "<br><br/><p class='error'>Attenzione!! L'utente non ha i privilegi per accedere a questo contenuto.</p>" );
define ( "INEXISTENT", "<br><br/><p class='error'>Attenzione!! Contenuto inesistente.</p>" );

define ( "FILE_LOG", ADMIN_PATH . "log/" . date ( "Ym" ) . ".log" );

define ( "AUTH_USER", "AUTH_USER" );
define ( "SITE_ONLINE", 1 );

?>

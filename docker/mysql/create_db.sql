CREATE DATABASE IF NOT EXISTS `gestore_documentazione_tecnica` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci` ;
GRANT ALL ON `gestore_documentazione_tecnica`.* TO 'gestore_documentazione_tecnica'@'%' ;

CREATE DATABASE IF NOT EXISTS `gestore_documentazione_tecnica_test` CHARACTER SET `utf8mb4` COLLATE `utf8mb4_unicode_ci` ;
GRANT ALL ON `gestore_documentazione_tecnica_test`.* TO 'gestore_documentazione_tecnica'@'%' ;

FLUSH PRIVILEGES;

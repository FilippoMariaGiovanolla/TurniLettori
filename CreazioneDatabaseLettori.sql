/*per importarlo è necessario accedere al monitor MySql del prompt dei comandi e digitare
 source [percorso file con barre \ + nome_file --> es. C\documenti\creazionedb.sql]*/

CREATE DATABASE lettori;
USE lettori;
CREATE TABLE lettori
(
CodiceSoggetto INTEGER,
Cognome VARCHAR(30),
Nome VARCHAR(20),
Telefono VARCHAR(20),
PreferenzaPrefestiva CHAR,
PreferenzaFestiva CHAR,
PreferenzaVespertina CHAR,
Attivo CHAR,
PRIMARY KEY(CodiceSoggetto)
);
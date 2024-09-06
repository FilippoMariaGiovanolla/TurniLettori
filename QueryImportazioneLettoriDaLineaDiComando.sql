LOAD DATA LOCAL INFILE 'C:/Program Files (x86)/EasyPHP 2.0b1/www/TurniLettori/Lettori.csv'
INTO TABLE lettori
FIELDS TERMINATED BY ';'
LINES TERMINATED BY '\n';
-- Gestione database remoto:
-- http://spano.sc.unica.it/phpmyadmin

drop database amm15_grassoStefania;

create database amm15_grassoStefania;

drop user 'grassoStefania'@'localhost';

create user 'grassoStefania'@'localhost' identified by 'pappagallo4121';

grant all on amm15_grassoStefania.* to 'grassoStefania'@'localhost';

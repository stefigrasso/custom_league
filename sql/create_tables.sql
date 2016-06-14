--
-- Database: amm15_grassoStefania
--

use amm15_grassoStefania;

-- --------------------------------------------------------

--
-- Struttura della tabella utenti
--

create table if not exists utenti (
  id bigint(20) unsigned not null auto_increment,
  ruolo enum('amministratore', 'organizzatore', 'partecipante') not null,
  username varchar(128) not null,
  password varchar(128) not null,
  nome varchar(128) default null,
  cognome varchar(128) default null,
  email varchar(128) default null,
  unique key id (id),
  unique key username (username),
  unique key email (email)
);

-- --------------------------------------------------------

--
-- Struttura della tabella tornei
--

create table if not exists tornei (
  id bigint(20) unsigned not null auto_increment,
  organizzatore_id bigint(20) unsigned not null,
  data_inizio datetime not null,
  nome varchar(128) not null,
  luogo varchar(128) default null,
  indirizzo varchar(128) default null,
  disciplina varchar(128) not null,
  tipologia enum('Girone italiano', 'Eliminazione diretta') not null,
  min_partecipanti int(4) unsigned not null,
  max_partecipanti int(4) unsigned not null,
  unique key id (id),
  key utenti_fk (organizzatore_id)
);

-- --------------------------------------------------------

--
-- Struttura della tabella risultati
--

create table if not exists risultati (
  id bigint(20) unsigned not null auto_increment,
  giornata int(4) unsigned not null,
  torneo_id bigint(20) unsigned default null,
  partecipanteA_id bigint(20) unsigned default null,
  partecipanteB_id bigint(20) unsigned default null,
  punteggioA int(4) unsigned default null,
  punteggioB int(4) unsigned default null,
  unique key id (id),
  key tornei_fk (torneo_id),
  key utenti_fk (partecipanteA_id, partecipanteB_id)
);

-- --------------------------------------------------------

--
-- Struttura della tabella iscrizioni
--

create table if not exists iscrizioni (
  id bigint(20) unsigned not null auto_increment,
  torneo_id bigint(20) unsigned default null,
  partecipante_id bigint(20) unsigned default null,
  unique key id (id),
  primary key (torneo_id, partecipante_id),
  key tornei_fk (torneo_id),
  key utenti_fk (partecipante_id)
);

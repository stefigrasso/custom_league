--
-- Database: amm15_grassoStefania
--

use amm15_grassoStefania;

-- --------------------------------------------------------

--
-- Dump dei dati per la tabella utenti
--

insert into utenti (id, ruolo, username, password, nome, cognome, email) values
(1, 'organizzatore', 'organizzatore', 'grasso', 'organizzatore', 'pinco', 'organizzatore.pinco@customleague.it'),
(2, 'partecipante', 'partecipante', 'grasso', 'partecipante', 'pinco', 'partecipante.pinco@customleague.it'),
(3, 'partecipante', 'part2', 'grasso', 'part2', 'pinco', 'part2.pinco@customleague.it'),
(4, 'partecipante', 'part3', 'grasso', 'part3', 'pinco', 'part3.pinco@customleague.it'),
(5, 'partecipante', 'part4', 'grasso', 'part4', 'pinco', 'part4.pinco@customleague.it'),
(6, 'partecipante', 'part5', 'grasso', 'part5', 'pinco', 'part5.pinco@customleague.it'),
(7, 'partecipante', 'part6', 'grasso', 'part6', 'pinco', 'part6.pinco@customleague.it'),
(8, 'partecipante', 'part7', 'grasso', 'part7', 'pinco', 'part7.pinco@customleague.it'),
(9, 'partecipante', 'part8', 'grasso', 'part8', 'pinco', 'part8.pinco@customleague.it');

-- --------------------------------------------------------

--
-- Dump dei dati per la tabella tornei
--

insert into tornei (id, organizzatore_id, data_inizio, nome, luogo, indirizzo, disciplina, tipologia, min_partecipanti, max_partecipanti) values
(1, 1, '2015-10-23 00:00:00', 'torneo1', 'Don Orione', 'via rosa, Selargius (CA)', 'calcio', 'Girone italiano', 4, 10),
(2, 1, '2015-12-5 00:00:00', 'torneo2', 'CUS', 'via universita, Cagliari', 'calcio', 'Girone italiano', 3, 5),
(3, 1, '2015-08-21 00:00:00', 'torneo3', 'Ferrini', 'via quartu n.30/a Quartucciu (CA)', 'basket', 'Girone italiano', 2, 6),
(4, 1, '2015-11-1 00:00:00', 'torneo4', 'Parchetto', 'via cagliari n.40/b Monserrato', 'ping pong', 'Girone italiano', 6, 8);

-- --------------------------------------------------------

--
-- Dump dei dati per la tabella risultati
--

insert into risultati (id, giornata, torneo_id, partecipanteA_id, partecipanteB_id, punteggioA, punteggioB) values
(1, 1, 1, 2, 4, 4, 3),
(2, 1, 1, 3, 5, 3, 2),
(3, 2, 1, 2, 5, 5, 10),
(4, 2, 1, 4, 3, 7, 3),
(5, 3, 1, 2, 3, 9, 2),
(6, 3, 1, 5, 4, 4, 5),
(7, 4, 1, 4, 2, 3, 6),
(8, 4, 1, 5, 3, 4, 1),
(9, 5, 1, 5, 2, 0, 0),
(10, 5, 1, 3, 4, 2, 2),
(11, 6, 1, 3, 2, 1, 1),
(12, 6, 1, 4, 5, 2, 3);

-- --------------------------------------------------------

--
-- Dump dei dati per la tabella iscrizioni
--

insert into iscrizioni (id, torneo_id, partecipante_id) values
(1, 1, 2),
(2, 1, 3),
(3, 1, 4),
(4, 1, 5),
(5, 2, 6),
(6, 2, 7),
(7, 2, 8),
(8, 3, 9);




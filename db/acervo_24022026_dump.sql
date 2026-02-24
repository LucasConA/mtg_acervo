-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 24/02/2026 às 13:20
-- Versão do servidor: 8.4.7
-- Versão do PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `acervo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `cartas`
--

DROP TABLE IF EXISTS `cartas`;
CREATE TABLE IF NOT EXISTS `cartas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `id_edicao` int DEFAULT NULL,
  `id_raridade` int DEFAULT NULL,
  `id_condicao` int DEFAULT NULL,
  `id_idioma` int DEFAULT NULL,
  `id_tipo` int DEFAULT NULL,
  `foil` tinyint(1) DEFAULT NULL,
  `valor` decimal(10,2) DEFAULT NULL,
  `quantidade` int NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_carta_unica` (`nome`,`id_edicao`,`id_raridade`,`id_condicao`,`id_idioma`,`id_tipo`,`foil`),
  KEY `id_raridade` (`id_raridade`),
  KEY `id_condicao` (`id_condicao`),
  KEY `id_idioma` (`id_idioma`),
  KEY `id_tipo` (`id_tipo`),
  KEY `fk_cartas_edicoes` (`id_edicao`)
) ENGINE=MyISAM AUTO_INCREMENT=366 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `cartas`
--

INSERT INTO `cartas` (`id`, `nome`, `id_edicao`, `id_raridade`, `id_condicao`, `id_idioma`, `id_tipo`, `foil`, `valor`, `quantidade`) VALUES
(2, 'Chandra, Chama da Rebeldia', 75, 4, 2, 1, 6, 0, 15.95, 1),
(3, 'Elspeth, Sun\'s Champion', 65, 4, 2, 1, 6, 0, 15.38, 1),
(57, 'Nykthos, Shrine to Nyx', 69, 3, 2, 2, 7, 0, 105.19, 2),
(35, 'Aprisionamento de Ixalan', 83, 2, NULL, NULL, 3, 0, 2.00, 0),
(55, 'Assentar nos Destroços', NULL, NULL, NULL, NULL, NULL, 0, 19.35, 1),
(52, 'Égide dos Deuses', 0, 0, 0, 0, 0, 0, 7.28, 2),
(53, 'Especialidade de Sram', 0, 0, 0, 0, 0, 0, 1.77, 1),
(54, 'Fumigar', 0, 0, 0, 0, 0, 0, 4.38, 1),
(51, 'Carneiro Velocino-de-Nyx', 0, 0, 0, 0, 0, 0, 2.13, 2),
(56, 'Zetalpa, Aurora Primordial', 0, 0, 0, 0, 0, 0, 15.91, 1),
(58, 'Cascading Cataracts', NULL, NULL, NULL, NULL, NULL, 0, 9.70, 1),
(59, 'Metallic Mimic', 80, 3, 2, 2, 2, 0, 10.00, 1),
(76, 'Metapaisagem', 39, 3, 1, 2, 4, 0, 165.00, 1),
(71, 'Égide dos Deuses', 71, 3, 2, 1, 9, 0, 7.28, 2),
(72, 'Especialidade de Sram', 80, 3, 2, 1, 4, 1, 1.77, 1),
(69, '', 0, 0, 0, 0, 0, 0, 0.00, 2),
(81, 'Carneiro Velocino-de-Nyx', 71, 2, 2, 1, 9, 0, 2.13, 2),
(78, 'Fumigar', 79, 3, 2, 1, 4, 0, 4.38, 1),
(79, 'Assentar nos Destroços', 83, 3, 2, 1, 5, 0, 19.35, 1),
(80, 'Zetalpa, Aurora Primordial', 84, 3, 2, 1, 2, 1, 15.91, 1),
(86, 'Nyktos, Santuário de Nyx', 69, 3, 2, 2, 7, 0, 176.08, 2),
(83, 'Lightform', 39, 1, 1, 1, 1, 1, 2.00, 1),
(87, 'Karn, o Grande Criador', 153, 3, 2, 2, 6, 1, 146.01, 1),
(88, 'Aurelia, the Warleader', 154, 4, 2, 1, 2, 1, 115.74, 1),
(89, 'Olivia Voldaren', 155, 4, 2, 2, 2, 0, 75.69, 1),
(90, 'Santuário Botânico', 79, 3, 2, 2, 7, 0, 73.45, 1),
(91, 'Metapaisagem', 156, 3, 2, 2, 4, 0, 71.91, 1),
(92, 'Platinum Angel', 154, 4, 2, 1, 10, 1, 71.40, 1),
(93, 'Chandra, Chama da Rebeldia', 79, 4, 2, 2, 6, 0, 69.50, 1),
(94, 'Reservatório do Fluxo de Éter', 79, 3, 2, 2, 1, 0, 63.49, 2),
(95, 'Dictate of Erebos', 71, 3, 2, 1, 3, 0, 63.29, 1),
(96, 'Hallowed Fountain', 66, 3, 2, 1, 7, 0, 60.83, 2),
(97, 'Memorial de Akroma', 121, 4, 2, 2, 1, 0, 59.93, 1),
(98, 'Vantagem Inspiradora', 79, 3, 2, 2, 7, 0, 58.42, 1),
(99, 'Sacrário Ateísta', 157, 3, 2, 2, 7, 0, 58.16, 1),
(100, 'Mogis, Deus da Matança', 70, 4, 2, 2, 9, 0, 56.59, 1),
(101, 'Swan Song', 69, 3, 2, 1, 5, 0, 52.27, 1),
(102, 'Catacumba Submersa', 83, 3, 2, 2, 7, 1, 50.68, 1),
(103, 'Auxílio de Sigarda', 158, 3, 2, 2, 3, 0, 49.48, 1),
(104, 'Elspeth, Sun\'s Champion', 159, 4, 2, 1, 6, 1, 47.86, 1),
(105, 'Pela Força', 81, 2, 2, 2, 4, 1, 47.48, 1),
(106, 'Feira dos Inventores', 79, 3, 2, 2, 7, 0, 47.34, 2),
(107, 'Cataratas Cascateantes', 81, 3, 2, 2, 7, 1, 46.93, 1),
(108, 'Knight Exemplar', 160, 3, 5, 1, 2, 0, 45.49, 2),
(109, 'Retiro da Falésia', 85, 3, 2, 2, 7, 1, 44.49, 1),
(110, 'Obsessão Curiosa', 84, 2, 2, 2, 3, 0, 44.16, 1),
(111, 'Mímico Metálico', 80, 3, 2, 2, 10, 0, 42.26, 2),
(112, 'Exalted Angel', 154, 4, 2, 1, 2, 1, 41.98, 1),
(113, 'Atreos, Deus da Passagem', 71, 4, 2, 2, 9, 0, 41.15, 1),
(114, 'Torre da Indústria', 80, 3, 2, 2, 7, 1, 39.28, 1),
(115, 'Mausoleum Wanderer', 158, 3, 2, 1, 2, 0, 39.08, 1),
(116, 'Saqueador Impiedoso', 84, 2, 2, 2, 2, 0, 38.62, 1),
(117, 'Panarmônico', 79, 3, 2, 2, 1, 0, 37.75, 1),
(118, 'Autoridade dos Cônsules', 79, 3, 2, 2, 3, 0, 37.50, 2),
(119, 'Tamiyo, Field Researcher', 158, 4, 2, 1, 6, 0, 36.18, 1),
(120, 'Eterna-Deusa Oketra', 153, 4, 2, 2, 2, 0, 35.44, 1),
(121, 'Baneslayer Angel', 154, 4, 2, 1, 2, 1, 35.29, 1),
(122, 'Capela Isolada', 85, 3, 2, 2, 7, 1, 33.70, 1),
(123, 'Angel of Jubilation', 161, 3, 2, 1, 2, 0, 33.25, 2),
(124, 'Inspiring Statuary', 80, 3, 2, 1, 1, 1, 32.16, 1),
(125, 'Motor do Paradoxo', 80, 4, 2, 2, 1, 0, 31.68, 1),
(126, 'Hanweir Battlements', 158, 3, 2, 1, 7, 1, 30.00, 1),
(127, 'Shaman of Forgotten Ways', 74, 4, 2, 1, 2, 0, 29.66, 1),
(128, 'Akroma, Angel of Wrath', 154, 4, 2, 1, 2, 1, 29.28, 1),
(129, 'Fúria Temerária', 84, 2, 2, 2, 5, 0, 28.98, 1),
(130, 'Iona, Shield of Emeria', 154, 4, 2, 1, 2, 1, 28.97, 1),
(131, 'Cataratas Cascateantes', 81, 3, 2, 2, 7, 0, 28.58, 1),
(132, 'Silêncio', 122, 3, 2, 2, 5, 0, 28.45, 1),
(133, 'Jornada para a Eternidade', 84, 3, 2, 2, 3, 0, 28.10, 1),
(134, 'Mother of Runes', 159, 2, 2, 1, 2, 0, 28.10, 3),
(135, 'Yahenni, Guerrilheiro Imortal', 80, 3, 2, 2, 2, 0, 27.00, 1),
(136, 'Monumento de Bontu', 81, 2, 2, 2, 1, 0, 25.34, 2),
(137, 'Fortaleza Glacial', 121, 3, 2, 2, 7, 0, 25.06, 2),
(138, 'Fortaleza Glacial', 118, 3, 2, 2, 7, 0, 25.03, 1),
(139, 'Maldição da Sangria', 162, 3, 2, 2, 3, 0, 24.73, 1),
(140, 'Pacto de Sangue', 122, 3, 2, 2, 3, 1, 24.59, 1),
(141, 'Sussurrador da Ruína', 86, 4, 2, 2, 2, 0, 24.35, 1),
(142, 'Território dos Necrófagos', 82, 3, 2, 2, 7, 1, 24.02, 1),
(143, 'Desautorizar', 80, 3, 2, 2, 5, 0, 23.98, 1),
(144, 'Memnite', 60, 2, 2, 2, 10, 0, 23.15, 4),
(145, 'Nissa, Voice of Zendikar', 163, 4, 2, 1, 6, 1, 22.93, 2),
(146, 'Fortaleza Glacial', 83, 3, 2, 2, 7, 0, 22.25, 1),
(147, 'Penhasco do Raizame', 83, 3, 2, 2, 7, 0, 22.17, 1),
(148, 'Alchemist\'s Refuge', 161, 3, 2, 1, 7, 0, 22.15, 1),
(149, 'Santuário dos Moldadores', 83, 3, 2, 2, 3, 1, 21.80, 1),
(150, 'Heliod, God of the Sun', 69, 4, 2, 1, 9, 0, 21.62, 1),
(151, 'Jaula do Escavador de Túmulos', 126, 3, 2, 2, 1, 0, 21.20, 1),
(152, 'Animate Dead', 164, 2, 2, 1, 3, 1, 20.61, 1),
(153, 'Encarregada da Essência', 48, 1, 2, 2, 2, 0, 20.46, 1),
(154, 'Gideon Lâmina Negra', 153, 4, 2, 2, 6, 0, 20.00, 2),
(155, 'Portal de Azor', 84, 4, 2, 2, 1, 0, 19.96, 1),
(156, 'Kinsbaile Cavalier', 160, 3, 6, 1, 2, 0, 19.92, 2),
(157, 'Castelo do Vale Arden', 89, 3, 2, 2, 7, 1, 19.90, 1),
(158, 'Inspiring Statuary', 80, 3, 2, 1, 1, 0, 19.89, 3),
(159, 'Ghalta, Fome Primordial', 84, 3, 2, 2, 2, 0, 19.68, 1),
(160, 'Tariel, Reckoner of Souls', 154, 4, 2, 1, 2, 1, 19.68, 1),
(161, 'Final de Eternidade', 153, 4, 2, 2, 4, 1, 19.54, 1),
(162, 'Tezzeret the Schemer', 80, 4, 2, 1, 6, 0, 19.49, 1),
(163, 'Assentar nos Destroços', 83, 3, 2, 2, 5, 0, 19.35, 1),
(164, 'Lagoas Fétidas', 81, 3, 2, 2, 7, 0, 18.85, 1),
(165, 'Ghostly Prison', 165, 2, 2, 1, 3, 0, 18.80, 2),
(166, 'Mago Escarificador de Almas', 81, 3, 2, 2, 2, 0, 18.31, 3),
(167, 'Hanweir Battlements', 158, 3, 2, 1, 7, 0, 18.00, 1),
(168, 'Ashiok, Dissolvedor de Sonhos', 153, 2, 2, 2, 6, 0, 17.14, 1),
(169, 'Capitã Lannery Tormenta', 83, 3, 2, 2, 2, 0, 16.90, 2),
(170, 'Carametra, Deusa da Colheita', 70, 4, 2, 2, 9, 0, 16.69, 1),
(171, 'Crescimento Mutagênico', 62, 1, 2, 2, 5, 0, 16.69, 4),
(172, 'Ryusei, the Falling Star', 166, 3, 2, 1, 2, 1, 16.63, 2),
(173, 'Elbrus, a Lâmina da União', 167, 4, 2, 2, 1, 0, 16.60, 1),
(174, 'Sphere of Safety', 66, 2, 2, 1, 3, 0, 16.51, 1),
(175, 'Pátio Oculto', 79, 3, 2, 2, 7, 0, 16.26, 2),
(176, 'Sage of Hours', 71, 4, 2, 1, 2, 0, 16.23, 1),
(177, 'Ladrão de Noção', 68, 3, 2, 2, 2, 0, 16.21, 1),
(178, 'Zetalpa, Aurora Primordial', 84, 3, 2, 2, 2, 1, 15.91, 1),
(179, 'Aço da Divindade', 52, 1, 2, 2, 3, 0, 15.83, 3),
(180, 'Nissa, Artesã da Natureza', 79, 4, 2, 2, 6, 1, 15.68, 1),
(181, 'Entreat the Angels', 154, 4, 2, 1, 4, 1, 15.64, 1),
(182, 'Manto de Seda Ruflante', 39, 1, 2, 2, 1, 0, 15.58, 1),
(183, 'Akroma, Angel of Fury', 154, 4, 2, 1, 2, 1, 15.45, 1),
(184, 'Talismã de Garra dos Desejos', 89, 3, 2, 2, 1, 0, 15.44, 1),
(185, 'Oketra, a Verdadeira', 81, 4, 2, 2, 2, 0, 15.38, 1),
(186, 'Estrela da Extinção', 83, 4, 2, 2, 4, 0, 15.21, 1),
(187, 'Ponder', 120, 1, 2, 1, 4, 0, 14.41, 2),
(188, 'Serra Angel', 154, 4, 2, 1, 2, 1, 14.40, 1),
(189, 'Curse of Misfortunes', 162, 3, 2, 1, 3, 0, 14.09, 1),
(190, 'Ganso Dourado', 89, 3, 2, 2, 2, 0, 13.77, 1),
(191, 'Olivia, Mobilizada para a Guerra', 168, 4, 2, 2, 2, 0, 13.56, 1),
(192, 'Sorin, Senhor Vampiro Vingativo', 153, 3, 2, 2, 6, 0, 13.32, 1),
(193, 'Chefe-de-Guerra da Legião', 86, 3, 2, 2, 2, 0, 13.19, 1),
(194, 'Atravessar Ulvenwald', 168, 3, 2, 2, 4, 0, 13.09, 1),
(195, 'Huatli, Poetisa Guerreira', 83, 4, 2, 2, 6, 0, 12.60, 1),
(196, 'Hanweir Garrison', 158, 3, 2, 1, 2, 0, 12.47, 1),
(197, 'Temur Sabertooth', 73, 2, 2, 1, 2, 0, 12.28, 1),
(198, 'Vivien, Campeã da Natureza', 153, 3, 2, 2, 6, 0, 12.10, 1),
(199, 'Leechridden Swamp', 163, 2, 2, 1, 7, 0, 11.86, 2),
(200, 'Sol Ring', 144, 2, 2, 1, 1, 0, 11.77, 1),
(201, 'Sol Ring', 145, 2, 2, 1, 1, 0, 11.74, 2),
(202, 'Arvoredo Resguardado', 81, 3, 2, 2, 7, 0, 11.72, 1),
(203, 'Chandra Nalaar', 169, 4, 2, 1, 6, 1, 11.65, 1),
(204, 'Chandra, Pirogênia', 79, 4, 2, 2, 6, 1, 11.65, 1),
(205, 'Kiora, the Crashing Wave', 159, 4, 2, 1, 6, 1, 11.41, 2),
(206, 'Sol Ring', 143, 2, 2, 1, 1, 0, 11.40, 1),
(207, 'Esperança de Ghirapur', 80, 3, 2, 2, 10, 0, 11.38, 1),
(208, 'Combustible Gearhulk', 79, 4, 2, 1, 10, 0, 11.34, 1),
(209, 'Final da Eternidade', 153, 4, 2, 2, 4, 0, 11.24, 1),
(210, 'Day of Judgment', 57, 3, 2, 1, 4, 0, 11.12, 1),
(211, 'Crop Rotation', 163, 1, 2, 1, 5, 0, 11.04, 2),
(212, 'Bruna, a Luz Desvanecente', 158, 3, 2, 2, 2, 0, 10.44, 3),
(213, 'Recompensa de Bronze', 84, 3, 2, 2, 4, 1, 10.44, 1),
(214, 'Jenara, Asura of War', 154, 4, 2, 1, 2, 1, 10.36, 1),
(215, 'Maravilha do Sistema Eteráulico', 79, 4, 2, 2, 1, 0, 10.23, 1),
(216, 'Niv-Mizzet, Parun', 86, 3, 2, 2, 2, 0, 10.10, 1),
(217, 'Floração Estival', 170, 2, 2, 2, 4, 0, 10.01, 1),
(218, 'Ral, Vice-Rei Izzet', 86, 4, 2, 2, 6, 0, 9.61, 1),
(219, 'O Deus Escorpião', 82, 4, 2, 2, 2, 0, 9.56, 1),
(220, 'Serpente Litoespiral', 89, 3, 2, 1, 10, 0, 9.54, 1),
(221, 'Nissa, Guardiã dos Elementos', 81, 4, 2, 2, 6, 0, 9.47, 1),
(222, 'Lança Veloz do Monastério', 171, 2, 2, 2, 2, 0, 9.40, 4),
(223, 'Dwynen, Daen de Folha D\'Ouro', 124, 3, 2, 2, 2, 1, 9.29, 1),
(224, 'Reconquista da Natureza', 157, 2, 2, 2, 3, 0, 9.27, 1),
(225, 'Elvish Archdruid', 119, 3, 2, 1, 2, 0, 9.17, 1),
(226, 'A Errante', 153, 2, 2, 2, 6, 0, 9.09, 1),
(227, 'Ira de Kaya', 157, 3, 2, 2, 4, 1, 8.72, 1),
(228, 'Verdeloth the Ancient', 172, 3, 2, 1, 2, 0, 8.63, 1),
(229, 'Xamã Dracontófilo', 37, 2, 2, 2, 2, 0, 8.55, 1),
(230, 'Chandra Nalaar', 119, 4, 2, 1, 6, 0, 8.48, 1),
(231, 'Chandra, the Firebrand', 121, 4, 2, 1, 6, 0, 8.48, 1),
(232, 'Vraska the Unseen', 173, 4, 2, 1, 6, 1, 8.38, 1),
(233, 'Iridescent Angel', 154, 4, 2, 1, 2, 1, 8.28, 2),
(234, 'Grand Architect', 60, 3, 2, 1, 2, 0, 8.17, 1),
(235, 'Demônio da Oferenda de Sangue', 63, 3, 2, 2, 2, 0, 7.59, 1),
(236, 'Ob Nixilis Reignited', 163, 4, 2, 1, 6, 1, 7.56, 2),
(237, 'Anjo da Restauração', 161, 3, 2, 2, 2, 0, 7.55, 1),
(238, 'Aetherize', 159, 2, 2, 1, 5, 0, 7.55, 1),
(239, 'Atormentar', 157, 3, 2, 2, 5, 0, 7.50, 1),
(240, 'Diabolic Tutor', 165, 2, 2, 1, 4, 0, 7.49, 1),
(241, 'Parasita de Sucata', 79, 3, 2, 2, 10, 1, 7.47, 1),
(242, 'Llanowar Wastes', 124, 3, 2, 1, 7, 0, 7.45, 2),
(243, 'Convergência dos Vormes-da-areia', 81, 3, 2, 2, 3, 0, 7.45, 1),
(244, 'Teneb, o Ceifador', 48, 3, 2, 2, 2, 0, 7.43, 1),
(245, 'Crosis, the Purger', 164, 3, 2, 1, 2, 1, 7.41, 1),
(246, 'Domri, Portador do Caos', 157, 4, 2, 2, 6, 0, 7.31, 1),
(247, 'Égide dos Deuses', 71, 3, 3, 2, 9, 0, 7.28, 2),
(248, 'Fortified Village', 168, 3, 2, 1, 7, 0, 7.09, 2),
(249, 'Akroma, Angel of Fury', 174, 3, 2, 1, 2, 0, 7.08, 2),
(250, 'Chromatic Star', 47, 1, 2, 1, 1, 0, 7.05, 1),
(251, 'Asa-solar de Kinjalli', 83, 3, 2, 2, 2, 0, 6.98, 1),
(252, 'Limpeza Temporal', 153, 3, 2, 2, 4, 1, 6.98, 1),
(253, 'Explosão Ruinosa de Urza', 85, 3, 2, 2, 4, 0, 6.85, 1),
(254, 'Yorvo, Senhor de Pontegaren', 89, 3, 2, 2, 2, 1, 6.79, 1),
(255, 'Angrath, Capitão do Caos', 153, 2, 2, 2, 6, 0, 6.76, 1),
(256, 'Phyrexian Revoker', 123, 3, 2, 1, 10, 0, 6.75, 1),
(257, 'Jace, Architect of Thought', 173, 4, 2, 1, 6, 1, 6.65, 1),
(258, 'Águas de Raiz Profunda', 83, 2, 2, 2, 3, 1, 6.65, 1),
(259, 'Tajic, Fio da Legião', 86, 3, 2, 2, 2, 1, 6.57, 1),
(260, 'Sinete Azorius', 175, 1, 2, 2, 1, 0, 6.53, 2),
(261, 'Cavaleiro da Orquídea Branca', 124, 3, 2, 2, 2, 0, 6.41, 2),
(262, 'Brainstorm', 143, 1, 2, 1, 5, 0, 6.40, 1),
(263, 'Dark Ritual', 176, 1, 2, 1, 5, 0, 6.39, 1),
(264, 'Riacho da Pradaria', 75, 3, 2, 2, 7, 0, 6.30, 1),
(265, 'Pilhagem Infiel', 162, 1, 2, 2, 4, 0, 6.12, 4),
(266, 'Segredos do Mausoléu', 86, 3, 2, 2, 5, 0, 5.62, 2),
(267, 'Knight of Meadowgrain', 160, 2, 2, 1, 2, 0, 5.59, 1),
(268, 'Enviar as Sentinelas', 158, 3, 2, 2, 4, 0, 5.58, 1),
(269, 'Juramento de Teferi', 85, 3, 2, 2, 3, 0, 5.47, 1),
(270, 'Ensoul Artifact', 123, 2, 2, 1, 3, 0, 5.36, 4),
(271, 'Cavaleiro de Campinagrão', 50, 2, 2, 2, 2, 0, 5.35, 1),
(272, 'Demover', 85, 2, 2, 2, 5, 0, 5.30, 1),
(273, 'Declaração em Pedra', 168, 3, 2, 2, 4, 0, 5.26, 3),
(274, 'Flagelo Eterno', 158, 3, 2, 2, 2, 0, 5.23, 1),
(275, 'Quasiduplicata', 86, 3, 2, 2, 4, 1, 5.17, 1),
(276, 'Cromanticora', 70, 4, 2, 1, 9, 0, 5.15, 1),
(277, 'Brainstorm', 177, 1, 2, 1, 5, 0, 5.10, 1),
(278, 'Loxodon Warhammer', 160, 3, 2, 1, 1, 0, 4.96, 2),
(279, 'Hidra Eriçada', 79, 3, 2, 2, 2, 1, 4.94, 1),
(280, 'Burn at the Stake', 161, 3, 2, 1, 4, 0, 4.91, 1),
(281, 'Druida da Incubação', 157, 3, 2, 2, 2, 0, 4.90, 1),
(282, 'Lightning Angel', 154, 4, 2, 1, 2, 1, 4.81, 1),
(283, 'Templo da Epifania', 71, 3, 2, 2, 7, 0, 4.70, 2),
(284, 'Pântano', 178, 1, 2, 2, 7, 0, 4.69, 1),
(285, 'Hanweir Militia Captain', 168, 3, 2, 1, 2, 0, 4.59, 1),
(286, 'Formação Inquebrável', 157, 3, 2, 2, 5, 0, 4.53, 1),
(287, 'Zona de Emergência', 153, 2, 2, 2, 7, 0, 4.46, 2),
(288, 'Explosive Vegetation', 159, 2, 2, 1, 4, 0, 4.41, 1),
(289, 'Fumigar', 79, 3, 2, 2, 4, 0, 4.38, 1),
(290, 'Chandra, Artesã do Fogo', 153, 3, 2, 2, 6, 0, 4.38, 1),
(291, 'Darksteel Citadel', 179, 1, 2, 1, 7, 0, 4.35, 1),
(292, 'Odric, Lunarch Marshal', 168, 3, 2, 1, 2, 0, 4.23, 2),
(293, 'Darksteel Citadel', 39, 1, 2, 1, 7, 0, 4.14, 3),
(294, 'Sigarda, Graça das Garças', 168, 4, 2, 2, 2, 0, 4.12, 1),
(295, 'Capitã de Safra Honrada', 81, 2, 2, 2, 2, 1, 4.04, 1),
(296, 'Massa Infiltradora', 158, 3, 2, 2, 2, 1, 4.03, 1),
(297, 'Mana Tithe', 48, 1, 2, 1, 5, 0, 4.02, 1),
(298, 'Arrastador de Sucata', 80, 3, 2, 2, 10, 0, 3.96, 2),
(299, 'Jhoira de Ghitu', 49, 3, 2, 2, 2, 0, 3.85, 1),
(300, 'Heroína do Primeiro Distrito', 157, 3, 2, 2, 2, 1, 3.80, 1),
(301, 'Planície', 180, 3, 2, 2, 7, 0, 3.80, 1),
(302, 'Módulo de Animação', 79, 3, 2, 2, 1, 0, 3.72, 1),
(303, 'Raptores Andarilhos', 83, 2, 2, 2, 2, 0, 3.70, 1),
(304, 'Ruínas de Ramunap', 82, 2, 2, 2, 7, 0, 3.56, 2),
(305, 'Mecanotitã Verdejante', 79, 4, 2, 2, 10, 0, 3.55, 1),
(306, 'Loxodonte Venerado', 86, 3, 2, 2, 2, 0, 3.46, 1),
(307, 'Matador de Gigantes', 89, 3, 2, 2, 2, 1, 3.45, 1),
(308, 'Pântano', 83, 1, 2, 2, 7, 1, 3.43, 1),
(309, 'Armada Wurm', 66, 4, 2, 2, 2, 0, 3.41, 1),
(310, 'Santuário Místico', 89, 1, 2, 2, 7, 0, 3.40, 2),
(311, 'Colosso de Serralheria', 79, 3, 2, 2, 10, 0, 3.37, 1),
(312, 'Quasiduplicata', 86, 3, 2, 2, 4, 0, 3.34, 1),
(313, 'Glorificadora Sanguínea', 84, 1, 2, 2, 2, 1, 3.34, 1),
(314, 'Arauto de Wirewood', 35, 1, 2, 2, 2, 0, 3.34, 1),
(315, 'Módulo de Fabricação', 79, 2, 2, 2, 1, 1, 3.30, 1),
(316, 'Domador de Tempestades Sireno', 83, 2, 2, 2, 2, 0, 3.25, 2),
(317, 'Ego à Deriva', 86, 3, 2, 2, 4, 0, 3.22, 1),
(318, 'Pântano', 123, 1, 2, 2, 7, 1, 3.19, 2),
(319, 'Gadwick, o Enrugado', 89, 3, 2, 2, 2, 0, 3.16, 2),
(320, 'Sacode-correntes', 168, 3, 2, 2, 2, 0, 3.15, 1),
(321, 'Flagelador de Alma', 73, 3, 2, 2, 2, 0, 3.15, 1),
(322, 'Piromante de Rochaferro', 89, 3, 2, 2, 2, 0, 3.13, 1),
(323, 'Fênix do Rastro Flamejante', 73, 3, 2, 2, 2, 0, 3.12, 1),
(324, 'Portão da Guilda Rakdos', 68, 1, 2, 2, 7, 1, 3.12, 1),
(325, 'Temple of the False God', 159, 2, 2, 1, 7, 0, 3.08, 1),
(326, 'Teysa, Enviada dos Fantasmas', 68, 3, 2, 2, 2, 0, 3.08, 1),
(327, 'Vampire Cutthroat', 158, 2, 2, 1, 2, 0, 3.07, 7),
(328, 'Captain of the Watch', 159, 3, 2, 1, 2, 0, 3.06, 1),
(329, 'Névoa de Sangue', 158, 2, 2, 2, 3, 1, 3.03, 1),
(330, 'Garota-massacre', 153, 3, 2, 2, 2, 0, 3.01, 1),
(331, 'Ornitóptero', 170, 2, 2, 2, 10, 0, 3.00, 1),
(332, 'Golgari Guildgate', 155, 1, 2, 1, 7, 1, 2.97, 1),
(333, 'Fim Glorioso', 81, 4, 2, 2, 5, 0, 2.95, 1),
(334, 'Pântano', 73, 1, 2, 2, 7, 1, 2.95, 1),
(335, 'Avatar do Sol Abrasador', 83, 3, 2, 2, 2, 1, 2.92, 1),
(336, 'Enxaqueca', 24, 1, 2, 2, 3, 0, 2.87, 3),
(337, 'Judith, Diva do Flagelo', 157, 3, 2, 2, 2, 0, 2.85, 1),
(338, 'Adepto Elegante', 41, 2, 2, 2, 2, 0, 2.85, 2),
(339, 'Kopala, Guardião das Ondas', 83, 3, 2, 2, 2, 0, 2.84, 1),
(340, 'Espiar', 32, 1, 2, 2, 5, 0, 2.81, 1),
(341, 'Atarka, Dissolvedora de Mundos', 73, 3, 2, 2, 2, 0, 2.81, 1),
(342, 'Ojutai Exemplars', 74, 4, 2, 1, 2, 0, 2.79, 1),
(343, 'Inspetor de Thraben', 168, 1, 2, 2, 2, 0, 2.77, 1),
(344, 'Floresta  Full Art', 75, 1, 2, 2, 7, 0, 2.75, 6),
(345, 'Lápide Silenciosa', 84, 3, 2, 2, 1, 0, 2.73, 1),
(346, 'Santificador de Almas', 158, 3, 2, 2, 2, 1, 2.70, 1),
(347, 'Halimar Depths', 173, 1, 2, 1, 7, 0, 2.68, 2),
(348, 'Mago Refletor', 76, 2, 2, 2, 2, 0, 2.64, 1),
(349, 'Treetop Village', 181, 2, 2, 1, 7, 0, 2.64, 1),
(350, 'Roca da Tempestade Eterna', 79, 3, 2, 2, 2, 1, 2.62, 1),
(351, 'Esforço Coletivo', 158, 3, 2, 2, 4, 0, 2.58, 1),
(352, 'Plasm Capture', 159, 3, 2, 1, 5, 0, 2.58, 2),
(353, 'Soltar ao Vento', 84, 3, 2, 2, 5, 0, 2.54, 1),
(354, 'Markov Blademaster', 162, 3, 2, 1, 2, 0, 2.54, 2),
(355, 'Whelming Wave', 159, 3, 2, 1, 4, 0, 2.53, 2),
(356, 'Seraph of the Sword', 122, 3, 2, 1, 2, 0, 2.51, 1),
(357, 'Defesa Florescente', 79, 2, 2, 2, 5, 0, 2.50, 2),
(358, 'Pestilence Demon', 163, 3, 2, 1, 2, 0, 2.50, 1),
(359, 'Odric, Master Tactician', 121, 3, 2, 1, 2, 0, 2.49, 1),
(360, 'Treetop Village', 160, 2, 2, 1, 7, 0, 2.47, 1),
(361, 'Vampire Nighthawk', 182, 2, 2, 1, 2, 0, 2.47, 4),
(362, 'Llanowar Reborn', 183, 2, 2, 1, 7, 0, 2.46, 4),
(363, 'Mosswort Bridge', 163, 3, 2, 1, 7, 0, 2.36, 1),
(365, 'A Errante', 153, 2, 2, 2, 6, 1, 9.05, 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `condicao`
--

DROP TABLE IF EXISTS `condicao`;
CREATE TABLE IF NOT EXISTS `condicao` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `codigo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `condicao`
--

INSERT INTO `condicao` (`id`, `nome`, `codigo`) VALUES
(1, 'Mint', 'M'),
(2, 'Near Mint', 'NM'),
(3, 'Slightly Played', 'SP'),
(4, 'Moderately Played', 'MP'),
(5, 'Heavily Played', 'HP'),
(6, 'Damaged', 'D');

-- --------------------------------------------------------

--
-- Estrutura para tabela `edicoes`
--

DROP TABLE IF EXISTS `edicoes`;
CREATE TABLE IF NOT EXISTS `edicoes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome_en` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nome_pt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=196 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `edicoes`
--

INSERT INTO `edicoes` (`id`, `codigo`, `nome_en`, `nome_pt`) VALUES
(1, 'LEA', 'Limited Edition Alpha', 'Edição Limitada Alpha'),
(2, 'LEB', 'Limited Edition Beta', 'Edição Limitada Beta'),
(3, '2ED', 'Unlimited Edition', 'Edição Ilimitada'),
(4, '3ED', 'Revised Edition', 'Edição Revisada'),
(5, '4ED', 'Fourth Edition', 'Quarta Edição'),
(6, '5ED', 'Fifth Edition', 'Quinta Edição'),
(7, '6ED', 'Classic Sixth Edition', 'Sexta Edição'),
(8, '7ED', 'Seventh Edition', 'Sétima Edição'),
(9, '8ED', 'Eighth Edition', 'Oitava Edição'),
(10, '9ED', 'Ninth Edition', 'Nona Edição'),
(11, '10E', 'Tenth Edition', 'Décima Edição'),
(12, 'ARN', 'Arabian Nights', 'Noites Árabes'),
(13, 'ATQ', 'Antiquities', 'Antiguidades'),
(14, 'LEG', 'Legends', 'Lendas'),
(15, 'DRK', 'The Dark', 'A Escuridão'),
(16, 'FEM', 'Fallen Empires', 'Impérios Decaídos'),
(17, 'ICE', 'Ice Age', 'Era Glacial'),
(18, 'ALL', 'Alliances', 'Alianças'),
(19, 'HML', 'Homelands', 'Terras Natais'),
(20, 'MIR', 'Mirage', 'Miragem'),
(21, 'VIS', 'Visions', 'Visões'),
(22, 'WTH', 'Weatherlight', 'Nau Clima-luz'),
(23, 'TMP', 'Tempest', 'Tempestade'),
(24, 'STH', 'Stronghold', 'Fortaleza'),
(25, 'EXO', 'Exodus', 'Êxodo'),
(26, 'USG', 'Urza\'s Saga', 'Saga de Urza'),
(27, 'ULG', 'Urza\'s Legacy', 'Legado de Urza'),
(28, 'UDS', 'Urza\'s Destiny', 'Destino de Urza'),
(29, 'INV', 'Invasion', 'Invasão'),
(30, 'PLS', 'Planeshift', 'Transição de Planos'),
(31, 'APC', 'Apocalypse', 'Apocalipse'),
(32, 'ODY', 'Odyssey', 'Odisseia'),
(33, 'TOR', 'Torment', 'Tormento'),
(34, 'JUD', 'Judgment', 'Julgamento'),
(35, 'ONS', 'Onslaught', 'Investida'),
(36, 'LGN', 'Legions', 'Legiões'),
(37, 'SCG', 'Scourge', 'Flagelo'),
(38, 'MRD', 'Mirrodin', 'Mirrodin'),
(39, 'DST', 'Darksteel', 'Aço Negro'),
(40, '5DN', 'Fifth Dawn', 'Quinta Aurora'),
(41, 'CHK', 'Champions of Kamigawa', 'Campeões de Kamigawa'),
(42, 'BOK', 'Betrayers of Kamigawa', 'Traidores de Kamigawa'),
(43, 'SOK', 'Saviors of Kamigawa', 'Salvadores de Kamigawa'),
(44, 'RAV', 'Ravnica: City of Guilds', 'Ravnica: Cidade das Guildas'),
(45, 'GPT', 'Guildpact', 'Pacto das Guildas'),
(46, 'DIS', 'Dissension', 'Dissensão'),
(47, 'TSP', 'Time Spiral', 'Espiral Temporal'),
(48, 'PLC', 'Planar Chaos', 'Caos Planar'),
(49, 'FUT', 'Future Sight', 'Visão do Futuro'),
(50, 'LRW', 'Lorwyn', 'Lorwyn'),
(51, 'MOR', 'Morningtide', 'Aurora'),
(52, 'SHM', 'Shadowmoor', 'Pântano Sombrio'),
(53, 'EVE', 'Eventide', 'Entardecer'),
(54, 'ALA', 'Shards of Alara', 'Fragmentos de Alara'),
(55, 'CON', 'Conflux', 'Confluxo'),
(56, 'ARB', 'Alara Reborn', 'Alara Renascida'),
(57, 'ZEN', 'Zendikar', 'Zendikar'),
(58, 'WWK', 'Worldwake', 'Despertar do Mundo'),
(59, 'ROE', 'Rise of the Eldrazi', 'Ascensão dos Eldrazi'),
(60, 'SOM', 'Scars of Mirrodin', 'Cicatrizes de Mirrodin'),
(61, 'MBS', 'Mirrodin Besieged', 'Mirrodin Sitiada'),
(62, 'NPH', 'New Phyrexia', 'Nova Phyrexia'),
(63, 'ISD', 'Innistrad', 'Innistrad'),
(64, 'DKA', 'Dark Ascension', 'Ascensão Sombria'),
(65, 'AVR', 'Avacyn Restored', 'Avacyn Restaurada'),
(66, 'RTR', 'Return to Ravnica', 'Retorno a Ravnica'),
(67, 'GTC', 'Gatecrash', 'Portões Violados'),
(68, 'DGM', 'Dragon\'s Maze', 'Labirinto do Dragão'),
(69, 'THS', 'Theros', 'Theros'),
(70, 'BNG', 'Born of the Gods', 'Nascidos dos Deuses'),
(71, 'JOU', 'Journey into Nyx', 'Viagem para Nyx'),
(72, 'KTK', 'Khans of Tarkir', 'Cãs de Tarkir'),
(73, 'FRF', 'Fate Reforged', 'Destino Reescrito'),
(74, 'DTK', 'Dragons of Tarkir', 'Dragões de Tarkir'),
(75, 'BFZ', 'Battle for Zendikar', 'Batalha por Zendikar'),
(76, 'OGW', 'Oath of the Gatewatch', 'Juramento das Sentinelas'),
(77, 'SOI', 'Shadows over Innistrad', 'Sombras sobre Innistrad'),
(78, 'EMN', 'Eldritch Moon', 'Lua Eldritch'),
(79, 'KLD', 'Kaladesh', 'Kaladesh'),
(80, 'AER', 'Aether Revolt', 'Revolta do Éter'),
(81, 'AKH', 'Amonkhet', 'Amonkhet'),
(82, 'HOU', 'Hour of Devastation', 'Hora da Devastação'),
(83, 'XLN', 'Ixalan', 'Ixalan'),
(84, 'RIX', 'Rivals of Ixalan', 'Rivais de Ixalan'),
(85, 'DOM', 'Dominaria', 'Dominária'),
(86, 'GRN', 'Guilds of Ravnica', 'Guildas de Ravnica'),
(87, 'RNA', 'Ravnica Allegiance', 'Aliança de Ravnica'),
(88, 'WAR', 'War of the Spark', 'Guerra da Centelha'),
(89, 'ELD', 'Throne of Eldraine', 'Trono de Eldraine'),
(90, 'THB', 'Theros Beyond Death', 'Theros: Além da Morte'),
(91, 'IKO', 'Ikoria: Lair of Behemoths', 'Ikoria: Covil das Feras'),
(92, 'ZNR', 'Zendikar Rising', 'Ascensão de Zendikar'),
(93, 'KHM', 'Kaldheim', 'Kaldheim'),
(94, 'STX', 'Strixhaven: School of Mages', 'Strixhaven: Escola de Magos'),
(95, 'MID', 'Innistrad: Midnight Hunt', 'Innistrad: Caçada da Meia-Noite'),
(96, 'VOW', 'Innistrad: Crimson Vow', 'Innistrad: Voto Carmesim'),
(97, 'NEO', 'Kamigawa: Neon Dynasty', 'Kamigawa: Dinastia Neon'),
(98, 'SNC', 'Streets of New Capenna', 'Ruas de Nova Capenna'),
(99, 'DMU', 'Dominaria United', 'Dominária Unida'),
(100, 'BRO', 'The Brothers\' War', 'A Guerra dos Irmãos'),
(101, 'ONE', 'Phyrexia: All Will Be One', 'Phyrexia: Tudo Será Um'),
(102, 'MOM', 'March of the Machine', 'Marcha das Máquinas'),
(103, 'WOE', 'Wilds of Eldraine', 'Ermos de Eldraine'),
(104, 'LCI', 'The Lost Caverns of Ixalan', 'As Cavernas Perdidas de Ixalan'),
(105, 'MKM', 'Murders at Karlov Manor', 'Assassinatos na Mansão Karlov'),
(106, 'OTJ', 'Outlaws of Thunder Junction', 'Foras da Lei de Thunder Junction'),
(107, 'DD1', 'Duel Decks: Elves vs Goblins', 'Duel Decks: Elfos vs Goblins'),
(108, 'DD2', 'Duel Decks: Jace vs Chandra', 'Duel Decks: Jace vs Chandra'),
(109, 'DD3', 'Duel Decks: Divine vs Demonic', 'Duel Decks: Divino vs Demoníaco'),
(110, 'DD4', 'Duel Decks: Garruk vs Liliana', 'Duel Decks: Garruk vs Liliana'),
(111, 'DD5', 'Duel Decks: Phyrexia vs the Coalition', 'Duel Decks: Phyrexia vs Coalizão'),
(112, 'DD6', 'Duel Decks: Elspeth vs Tezzeret', 'Duel Decks: Elspeth vs Tezzeret'),
(113, 'DD7', 'Duel Decks: Knights vs Dragons', 'Duel Decks: Cavaleiros vs Dragões'),
(114, 'DD8', 'Duel Decks: Ajani vs Nicol Bolas', 'Duel Decks: Ajani vs Nicol Bolas'),
(115, 'FND', 'Foundations', 'Fundamentos'),
(116, 'BLB', 'Magic: Bloomburrow', 'Magic: Bloomburrow'),
(117, 'DSA', 'Duskmourn: Aftermath', 'Duskmourn: Consequências'),
(118, 'M10', 'Magic 2010', 'Magic 2010'),
(119, 'M11', 'Magic 2011', 'Magic 2011'),
(120, 'M12', 'Magic 2012', 'Magic 2012'),
(121, 'M13', 'Magic 2013', 'Magic 2013'),
(122, 'M14', 'Magic 2014', 'Magic 2014'),
(123, 'M15', 'Magic 2015', 'Magic 2015'),
(124, 'ORI', 'Magic Origins', 'Magic Origens'),
(125, 'M19', 'Core Set 2019', 'Coleção Básica 2019'),
(126, 'M20', 'Core Set 2020', 'Coleção Básica 2020'),
(127, 'M21', 'Core Set 2021', 'Coleção Básica 2021'),
(128, 'DD9', 'Duel Decks: Venser vs Koth', 'Duel Decks: Venser vs Koth'),
(129, 'DDA', 'Duel Decks: Izzet vs Golgari', 'Duel Decks: Izzet vs Golgari'),
(130, 'DDB', 'Duel Decks: Sorin vs Tibalt', 'Duel Decks: Sorin vs Tibalt'),
(131, 'DDC', 'Duel Decks: Heroes vs Monsters', 'Duel Decks: Heróis vs Monstros'),
(132, 'DDD', 'Duel Decks: Jace vs Vraska', 'Duel Decks: Jace vs Vraska'),
(133, 'DDE', 'Duel Decks: Speed vs Cunning', 'Duel Decks: Velocidade vs Astúcia'),
(134, 'DDF', 'Duel Decks: Elspeth vs Kiora', 'Duel Decks: Elspeth vs Kiora'),
(135, 'DDG', 'Duel Decks: Zendikar vs Eldrazi', 'Duel Decks: Zendikar vs Eldrazi'),
(136, 'DDH', 'Duel Decks: Nissa vs Ob Nixilis', 'Duel Decks: Nissa vs Ob Nixilis'),
(137, 'DDI', 'Duel Decks: Merfolk vs Goblins', 'Duel Decks: Tritões vs Goblins'),
(138, 'DDJ', 'Duel Decks: Mind vs Might', 'Duel Decks: Mente vs Força'),
(139, 'DDK', 'Duel Decks: Elves vs Inventors', 'Duel Decks: Elfos vs Inventores'),
(140, 'CMD', 'Commander', 'Commander'),
(141, 'C13', 'Commander 2013', 'Commander 2013'),
(142, 'C14', 'Commander 2014', 'Commander 2014'),
(143, 'C15', 'Commander 2015', 'Commander 2015'),
(144, 'C16', 'Commander 2016', 'Commander 2016'),
(145, 'C17', 'Commander 2017', 'Commander 2017'),
(146, 'C18', 'Commander 2018', 'Commander 2018'),
(147, 'C19', 'Commander 2019', 'Commander 2019'),
(148, 'C20', 'Commander 2020', 'Commander 2020'),
(149, 'C21', 'Commander 2021', 'Commander 2021'),
(150, 'C22', 'Commander 2022', 'Commander 2022'),
(151, 'C23', 'Commander 2023', 'Commander 2023'),
(152, 'C24', 'Commander 2024', 'Commander 2024'),
(153, NULL, NULL, 'A Guerra da Centelha'),
(154, NULL, NULL, 'From the Vault: Angels'),
(155, NULL, NULL, 'Modern Masters 2017'),
(156, NULL, NULL, 'Alvorecer'),
(157, NULL, NULL, 'Lealdade em Ravnica'),
(158, NULL, NULL, 'Lua Arcana'),
(159, NULL, NULL, 'Duel Decks: Kiora vs. Elspeth'),
(160, NULL, NULL, 'Duel Decks: Knights vs. Dragons'),
(161, NULL, NULL, 'Retorno de Avacyn'),
(162, NULL, NULL, 'Ascensão das Trevas'),
(163, NULL, NULL, 'Duel Decks: Nissa vs. Ob Nixilis'),
(164, NULL, NULL, 'Premium Deck Series: Graveborn'),
(165, NULL, NULL, 'Conspiracy: Take the Crown'),
(166, NULL, NULL, 'Campeões de Kamigawa (PRE)'),
(167, NULL, NULL, 'From the Vault: Transform'),
(168, NULL, NULL, 'Sombras em Innistrad'),
(169, NULL, NULL, 'Duel Decks Anthology: Jace vs. Chandra'),
(170, NULL, NULL, 'Nona Edição - Kit Básico'),
(171, NULL, NULL, 'Khans de Tarkir'),
(172, NULL, NULL, 'Modern Masters'),
(173, NULL, NULL, 'Duel Decks: Jace vs. Vraska'),
(174, NULL, NULL, 'Commander Anthology'),
(175, NULL, NULL, 'Insurreição'),
(176, NULL, NULL, 'Duel Decks: Divine vs. Demonic'),
(177, NULL, NULL, 'Duel Decks: Izzet vs. Golgari'),
(178, NULL, NULL, 'Revised Edition (L: 1994)'),
(179, NULL, NULL, 'Modern Masters 2015'),
(180, NULL, NULL, 'Promo Pack (M20)'),
(181, NULL, NULL, 'Duel Decks: Garruk vs. Liliana'),
(182, NULL, NULL, 'Explorers of Ixalan'),
(183, NULL, NULL, 'Duel Decks: Heroes vs. Monsters'),
(184, NULL, NULL, 'Friday Night Magic'),
(185, NULL, NULL, 'Duels of the Planeswalkers'),
(186, NULL, NULL, 'Duel Decks: Blessed vs. Cursed'),
(187, NULL, NULL, 'Duel Decks: Elves vs. Goblins'),
(188, NULL, NULL, 'Welcome Deck 2016'),
(189, NULL, NULL, 'Duel Decks: Speed vs. Cunning'),
(190, NULL, NULL, 'Clash Pack'),
(191, NULL, NULL, 'Magic: The Gathering Launch Parties'),
(192, NULL, NULL, 'Trono de Eldraine (Variantes)'),
(193, NULL, NULL, 'Oitava Edição - Kit Básico'),
(194, NULL, NULL, 'Amonketh'),
(195, NULL, NULL, 'Transguild Promenade');

-- --------------------------------------------------------

--
-- Estrutura para tabela `edicoes_backup`
--

DROP TABLE IF EXISTS `edicoes_backup`;
CREATE TABLE IF NOT EXISTS `edicoes_backup` (
  `id` int NOT NULL DEFAULT '0',
  `codigo` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nome` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `edicoes_backup`
--

INSERT INTO `edicoes_backup` (`id`, `codigo`, `nome`) VALUES
(1, 'LEA', 'Limited Edition Alpha'),
(2, 'LEB', 'Limited Edition Beta'),
(3, '2ED', 'Unlimited Edition'),
(4, '3ED', 'Revised Edition'),
(5, '4ED', 'Fourth Edition'),
(6, '5ED', 'Fifth Edition'),
(7, '6ED', 'Classic Sixth Edition'),
(8, 'ARN', 'Arabian Nights'),
(9, 'ATQ', 'Antiquities'),
(10, 'LEG', 'Legends'),
(11, 'DRK', 'The Dark'),
(12, 'FEM', 'Fallen Empires'),
(13, 'ICE', 'Ice Age'),
(14, 'ALL', 'Alliances'),
(15, 'HML', 'Homelands'),
(16, 'MIR', 'Mirage'),
(17, 'VIS', 'Visions'),
(18, 'WTH', 'Weatherlight'),
(19, 'TMP', 'Tempest'),
(20, 'STH', 'Stronghold'),
(21, 'EXO', 'Exodus'),
(22, 'USG', 'Urza’s Saga'),
(23, 'ULG', 'Urza’s Legacy'),
(24, 'UDS', 'Urza’s Destiny'),
(25, 'INV', 'Invasion'),
(26, 'PLS', 'Planeshift'),
(27, 'APC', 'Apocalypse'),
(28, 'ODY', 'Odyssey'),
(29, 'TOR', 'Torment'),
(30, 'JUD', 'Judgment'),
(31, 'ONS', 'Onslaught'),
(32, 'LGN', 'Legions'),
(33, 'SCG', 'Scourge'),
(34, 'MRD', 'Mirrodin'),
(35, 'DST', 'Darksteel'),
(36, '5DN', 'Fifth Dawn'),
(37, 'CHK', 'Champions of Kamigawa'),
(38, 'BOK', 'Betrayers of Kamigawa'),
(39, 'SOK', 'Saviors of Kamigawa'),
(40, 'RAV', 'Ravnica: City of Guilds'),
(41, 'GPT', 'Guildpact'),
(42, 'DIS', 'Dissension'),
(43, 'TSP', 'Time Spiral'),
(44, 'PLC', 'Planar Chaos'),
(45, 'FUT', 'Future Sight'),
(46, 'LRW', 'Lorwyn'),
(47, 'MOR', 'Morningtide'),
(48, 'SHM', 'Shadowmoor'),
(49, 'EVE', 'Eventide'),
(50, 'ALA', 'Shards of Alara'),
(51, 'CFX', 'Conflux'),
(52, 'ARB', 'Alara Reborn'),
(53, 'ZEN', 'Zendikar'),
(54, 'WWK', 'Worldwake'),
(55, 'ROE', 'Rise of the Eldrazi'),
(56, 'SOM', 'Scars of Mirrodin'),
(57, 'MBS', 'Mirrodin Besieged'),
(58, 'NPH', 'New Phyrexia'),
(59, 'ISD', 'Innistrad'),
(60, 'DKA', 'Dark Ascension'),
(61, 'AVR', 'Avacyn Restored'),
(62, 'RTR', 'Return to Ravnica'),
(63, 'GTC', 'Gatecrash'),
(64, 'DGM', 'Dragon’s Maze'),
(65, 'THS', 'Theros'),
(66, 'BNG', 'Born of the Gods'),
(67, 'JOU', 'Journey into Nyx'),
(68, 'KTK', 'Khans of Tarkir'),
(69, 'FRF', 'Fate Reforged'),
(70, 'DTK', 'Dragons of Tarkir'),
(71, 'BFZ', 'Battle for Zendikar'),
(72, 'OGW', 'Oath of the Gatewatch'),
(73, 'SOI', 'Shadows Over Innistrad'),
(74, 'EMN', 'Eldritch Moon'),
(75, 'KLD', 'Kaladesh'),
(76, 'AER', 'Aether Revolt'),
(77, 'AKH', 'Amonkhet'),
(78, 'HOU', 'Hour of Devastation'),
(79, 'XLN', 'Ixalan'),
(80, 'RIX', 'Rivals of Ixalan'),
(81, 'DOM', 'Dominaria'),
(82, 'GRN', 'Guilds of Ravnica'),
(83, 'RNA', 'Ravnica Allegiance'),
(84, 'WAR', 'War of the Spark'),
(85, 'ELD', 'Throne of Eldraine'),
(86, 'THB', 'Theros Beyond Death'),
(87, 'IKO', 'Ikoria: Lair of Behemoths'),
(88, 'M21', 'Core Set 2021'),
(89, 'ZNR', 'Zendikar Rising'),
(90, 'KHM', 'Kaldheim'),
(91, 'STX', 'Strixhaven: School of Mages'),
(92, 'MID', 'Innistrad: Midnight Hunt'),
(93, 'VOW', 'Innistrad: Crimson Vow'),
(94, 'NEO', 'Kamigawa: Neon Dynasty'),
(95, 'SNC', 'Streets of New Capenna'),
(96, 'DMU', 'Dominaria United'),
(97, 'BRO', 'The Brothers’ War'),
(98, 'ONE', 'Phyrexia: All Will Be One'),
(99, 'MOM', 'March of the Machine'),
(100, 'WOE', 'Wilds of Eldraine'),
(101, 'LCI', 'The Lost Caverns of Ixalan'),
(102, 'MKM', 'Murders at Karlov Manor'),
(103, 'OTJ', 'Outlaws of Thunder Junction'),
(104, 'DSK', 'Duskmourn: House of Horror'),
(105, 'FAL', 'Foundations'),
(106, 'MBR', 'Magic: Bloomburrow'),
(107, 'DSV', 'Duskmourn: Aftermath');

-- --------------------------------------------------------

--
-- Estrutura para tabela `idiomas`
--

DROP TABLE IF EXISTS `idiomas`;
CREATE TABLE IF NOT EXISTS `idiomas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `idiomas`
--

INSERT INTO `idiomas` (`id`, `nome`) VALUES
(1, 'Inglês'),
(2, 'Português'),
(3, 'Espanhol'),
(4, 'Francês'),
(5, 'Alemão'),
(6, 'Italiano'),
(7, 'Japonês'),
(8, 'Coreano'),
(9, 'Chinês Simplificado'),
(10, 'Chinês Tradicional'),
(11, 'Russo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `raridades`
--

DROP TABLE IF EXISTS `raridades`;
CREATE TABLE IF NOT EXISTS `raridades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `raridades`
--

INSERT INTO `raridades` (`id`, `nome`) VALUES
(1, 'Comum'),
(2, 'Incomum'),
(3, 'Raro'),
(4, 'Mítico Raro');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipos`
--

DROP TABLE IF EXISTS `tipos`;
CREATE TABLE IF NOT EXISTS `tipos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `tipos`
--

INSERT INTO `tipos` (`id`, `nome`) VALUES
(1, 'Artefato'),
(2, 'Criatura'),
(3, 'Encantamento'),
(4, 'Feitiço'),
(5, 'Instantânea'),
(6, 'Planeswalker'),
(7, 'Terreno'),
(8, 'Tribal'),
(9, 'Criatura-encantamento'),
(10, 'Criatura-artefato');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `senha_hash` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha_hash`, `criado_em`) VALUES
(1, 'Lucas', 'lucscontin@gmail.com', '$2y$10$jd66W9JLSxUmYR.62rr/D.LLhIJbM8ZQRtCp1WMaRF1VTiwi6bsFW', '2026-02-09 13:21:34');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

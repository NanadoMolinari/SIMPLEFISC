-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 24-Set-2024 às 16:52
-- Versão do servidor: 10.4.27-MariaDB
-- versão do PHP: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `isssimples`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin_desc_cargo`
--

CREATE TABLE `admin_desc_cargo` (
  `cod_cargo` int(10) UNSIGNED NOT NULL,
  `desc_cargo` varchar(255) DEFAULT NULL,
  `flg_tipo_cargo` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `admin_desc_cargo`
--

INSERT INTO `admin_desc_cargo` (`cod_cargo`, `desc_cargo`, `flg_tipo_cargo`) VALUES
(1, 'Usuário', '1'),
(2, 'Administrador', '2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `admin_usuarios`
--

CREATE TABLE `admin_usuarios` (
  `cod_usuario` int(10) UNSIGNED NOT NULL,
  `cod_cargo` int(10) UNSIGNED NOT NULL,
  `login_usuario` varchar(50) DEFAULT NULL,
  `nome` varchar(255) DEFAULT NULL,
  `senha` varchar(100) DEFAULT NULL,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `admin_usuarios`
--

INSERT INTO `admin_usuarios` (`cod_usuario`, `cod_cargo`, `login_usuario`, `nome`, `senha`, `email`) VALUES
(1, 2, 'admin', 'Administrador', 'admin', ''),
(2, 1, 'leonardo', 'Leonardo Molinari', 'leonardo', 'leonardo.galdino@pirai.rj.gov.br');

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_aliquota`
--

CREATE TABLE `simples_aliquota` (
  `cod_aliquota` int(10) UNSIGNED NOT NULL,
  `anexo` varchar(10) NOT NULL,
  `limite_minimo` double NOT NULL,
  `limite_maximo` double NOT NULL,
  `aliquota` double NOT NULL,
  `aliquota_iss` double NOT NULL,
  `valor_deduzir` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `simples_aliquota`
--

INSERT INTO `simples_aliquota` (`cod_aliquota`, `anexo`, `limite_minimo`, `limite_maximo`, `aliquota`, `aliquota_iss`, `valor_deduzir`) VALUES
(1, 'III', 0, 180000, 6, 33.5, 0),
(2, 'III', 180000.01, 360000, 11.2, 32, 9360),
(3, 'III', 360000.01, 720000, 13.5, 32.5, 17640),
(4, 'III', 720000.01, 1800000, 16, 32.5, 35640),
(5, 'III', 1800000.01, 3600000, 21, 33.5, 125640),
(6, 'III', 3600000.01, 4800000, 33, 50, 648000),
(7, 'IV', 0, 180000, 4.5, 44.5, 0),
(8, 'IV', 180000.01, 360000, 9, 40, 8100),
(9, 'IV', 360000.01, 720000, 10.2, 40, 12420),
(10, 'IV', 720000.01, 1800000, 14, 40, 39780),
(11, 'IV', 1800000.01, 3600000, 22, 40, 183780),
(12, 'IV', 3600000.01, 4800000, 33, 50, 828000),
(13, 'V', 0, 180000, 15.5, 14, 0),
(14, 'V', 180000.01, 360000, 18, 17, 4500),
(15, 'V', 360000.01, 720000, 19.5, 19, 9900),
(16, 'V', 720000.01, 1800000, 20.5, 21, 17100),
(17, 'V', 1800000.01, 3600000, 23, 23.5, 62100),
(18, 'V', 3600000.01, 4800000, 30.5, 50, 540000);

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_auditor_fiscal`
--

CREATE TABLE `simples_auditor_fiscal` (
  `cod_auditor` int(10) UNSIGNED NOT NULL,
  `nome_auditor` varchar(100) DEFAULT NULL,
  `matricula` varchar(20) DEFAULT NULL,
  `data_cadastro` date DEFAULT NULL,
  `flg_ativo` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_auto_infracao`
--

CREATE TABLE `simples_auto_infracao` (
  `cod_auto_infracao` int(10) UNSIGNED NOT NULL,
  `data_lavratura` date DEFAULT NULL,
  `data_aceite` date DEFAULT NULL,
  `desc_relato` varchar(1000) DEFAULT NULL,
  `desc_sancao_legal` varchar(1000) DEFAULT NULL,
  `desc_infrigencia_legal` varchar(1000) DEFAULT NULL,
  `cod_verificacao_fiscal` int(10) UNSIGNED DEFAULT NULL,
  `vr_total_auto` decimal(17,2) NOT NULL,
  `perc_reducao` int(11) NOT NULL,
  `vr_total_com_reducao` decimal(17,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_contribuinte`
--

CREATE TABLE `simples_contribuinte` (
  `cod_contribuinte` int(10) UNSIGNED NOT NULL,
  `razao_social` varchar(255) DEFAULT NULL,
  `CNPJ` bigint(14) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `simples_contribuinte`
--

INSERT INTO `simples_contribuinte` (`cod_contribuinte`, `razao_social`, `CNPJ`) VALUES
(1, 'Município de Pirai', 29141322000132),
(2, 'Pirai teste', 123456),
(3, 'Empresa teste', 4294967295);

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_endereco`
--

CREATE TABLE `simples_endereco` (
  `cod_endereco` int(10) UNSIGNED NOT NULL,
  `cod_contribuinte` int(10) UNSIGNED NOT NULL,
  `desc_endereco` varchar(100) DEFAULT NULL,
  `numero` varchar(10) DEFAULT NULL,
  `complemento` varchar(100) DEFAULT NULL,
  `cep` varchar(10) DEFAULT NULL,
  `bairro` varchar(100) DEFAULT NULL,
  `cidade` varchar(100) DEFAULT NULL,
  `uf` varchar(2) DEFAULT NULL,
  `telefone` varchar(15) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_item_auto_infracao`
--

CREATE TABLE `simples_item_auto_infracao` (
  `cod_item_auto_infracao` int(10) UNSIGNED NOT NULL,
  `cod_auto_infracao` int(10) UNSIGNED NOT NULL,
  `periodo_apuracao` date DEFAULT NULL,
  `cod_tributo` int(11) DEFAULT NULL,
  `cod_encargo` int(11) DEFAULT NULL,
  `valor_auto` float(17,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_item_verificacao_fiscal`
--

CREATE TABLE `simples_item_verificacao_fiscal` (
  `cod_item_verificacao_fiscal` int(10) UNSIGNED NOT NULL,
  `cod_verificacao_fiscal` int(10) UNSIGNED NOT NULL,
  `periodo_apuracao` date DEFAULT NULL,
  `data_vencomento` date DEFAULT NULL,
  `item_lista` varchar(5) DEFAULT NULL,
  `anexo` varchar(5) DEFAULT NULL,
  `tipo_infracao` varchar(3) DEFAULT NULL,
  `vr_receita_b12_declarada` decimal(17,2) DEFAULT NULL,
  `vr_base_calculo_declarada` decimal(17,2) DEFAULT NULL,
  `aliquota_declarada` decimal(5,2) DEFAULT NULL,
  `vr_recolhido` decimal(17,2) DEFAULT NULL,
  `vr_receita_b12_apurada` decimal(17,2) DEFAULT NULL,
  `vr_base_calculo_apudada` decimal(17,2) DEFAULT NULL,
  `aliquota_efetiva` decimal(5,2) DEFAULT NULL,
  `vr_apurado` decimal(17,2) DEFAULT NULL,
  `vr_original` decimal(17,2) DEFAULT NULL,
  `vr_juros_mora` decimal(17,2) DEFAULT NULL,
  `perc_juros_mora` decimal(17,2) DEFAULT NULL,
  `vr_multa_mora` decimal(17,2) DEFAULT NULL,
  `perc_multa_mora` decimal(17,2) DEFAULT NULL,
  `vr_multa_punitiva` decimal(17,2) DEFAULT NULL,
  `perc_multa_punitiva` decimal(17,2) DEFAULT NULL,
  `vr_atualizado` decimal(17,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_selic`
--

CREATE TABLE `simples_selic` (
  `cod_selic` int(10) UNSIGNED NOT NULL,
  `data_selic` date DEFAULT NULL,
  `valor_selic` double(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `simples_selic`
--

INSERT INTO `simples_selic` (`cod_selic`, `data_selic`, `valor_selic`) VALUES
(1, '2019-05-01', 0.54),
(2, '2019-06-01', 0.47),
(3, '2019-07-01', 0.57),
(4, '2019-08-01', 0.50),
(5, '2019-09-01', 0.46),
(6, '2019-10-01', 0.48),
(7, '2019-11-01', 0.38),
(8, '2019-12-01', 0.37),
(9, '2020-01-01', 0.38),
(10, '2020-02-01', 0.29),
(11, '2020-03-01', 0.34),
(12, '2020-04-01', 0.28),
(13, '2020-05-01', 0.24),
(14, '2020-06-01', 0.21),
(15, '2020-07-01', 0.19),
(16, '2020-08-01', 0.16),
(17, '2020-09-01', 0.16),
(18, '2020-10-01', 0.16),
(19, '2020-11-01', 0.15),
(20, '2020-12-01', 0.16),
(21, '2021-01-01', 0.15),
(22, '2021-02-01', 0.13),
(23, '2021-03-01', 0.20),
(24, '2021-04-01', 0.21),
(25, '2021-05-01', 0.27),
(26, '2021-06-01', 0.31),
(27, '2021-07-01', 0.36),
(28, '2021-08-01', 0.43),
(29, '2021-09-01', 0.44),
(30, '2021-10-01', 0.49),
(31, '2021-11-01', 0.59),
(32, '2021-12-01', 0.77),
(33, '2022-01-01', 0.73),
(34, '2022-02-01', 0.76),
(35, '2022-03-01', 0.93),
(36, '2022-04-01', 0.83),
(37, '2022-05-01', 1.03),
(38, '2022-06-01', 1.02),
(39, '2022-07-01', 1.03),
(40, '2022-08-01', 1.17),
(41, '2022-09-01', 1.07),
(42, '2022-10-01', 1.02),
(43, '2022-11-01', 1.02),
(44, '2022-12-01', 1.12),
(45, '2023-01-01', 1.12),
(46, '2023-02-01', 0.92),
(47, '2023-03-01', 1.17),
(48, '2023-04-01', 0.92),
(49, '2023-05-01', 1.12),
(50, '2023-06-01', 1.07),
(51, '2023-07-01', 1.07),
(52, '2023-08-01', 1.14),
(53, '2023-09-01', 0.97),
(54, '2023-10-01', 1.00),
(55, '2023-11-01', 0.92),
(56, '2023-12-01', 0.89),
(57, '2024-01-01', 0.97),
(58, '2024-02-01', 0.80),
(59, '2024-03-01', 0.83),
(60, '2024-04-01', 0.89),
(63, '2024-08-01', 1.12),
(65, '2024-07-01', 0.91),
(66, '2024-06-01', 0.79),
(67, '2024-05-01', 0.83);

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_situacao`
--

CREATE TABLE `simples_situacao` (
  `cod_situacao` int(10) UNSIGNED NOT NULL,
  `desc_situacao` varchar(50) DEFAULT NULL,
  `icone_situacao` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `simples_situacao`
--

INSERT INTO `simples_situacao` (`cod_situacao`, `desc_situacao`, `icone_situacao`) VALUES
(1, 'Ativo', '<i class=\"fa-solid fa-hourglass\" style=\"color: #FFD43B;\"></i>'),
(2, 'Lançado', '<i class=\"fa-solid fa-check\" style=\"color: #04bd9b;\"></i>');

-- --------------------------------------------------------

--
-- Estrutura da tabela `simples_verificacao_fiscal`
--

CREATE TABLE `simples_verificacao_fiscal` (
  `cod_verificacao_fiscal` int(10) UNSIGNED NOT NULL,
  `ano_exercicio` year(4) DEFAULT NULL,
  `data_verificacao` date DEFAULT NULL,
  `desc_verificacao` varchar(200) DEFAULT NULL,
  `cod_contribuinte` int(11) DEFAULT NULL,
  `cod_auditor` int(11) DEFAULT NULL,
  `mun_processo_adm` varchar(13) DEFAULT NULL,
  `flg_situacao_verificacao` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `admin_desc_cargo`
--
ALTER TABLE `admin_desc_cargo`
  ADD PRIMARY KEY (`cod_cargo`);

--
-- Índices para tabela `admin_usuarios`
--
ALTER TABLE `admin_usuarios`
  ADD PRIMARY KEY (`cod_usuario`),
  ADD KEY `admim_usuarios_FKIndex1` (`cod_cargo`);

--
-- Índices para tabela `simples_aliquota`
--
ALTER TABLE `simples_aliquota`
  ADD PRIMARY KEY (`cod_aliquota`);

--
-- Índices para tabela `simples_auditor_fiscal`
--
ALTER TABLE `simples_auditor_fiscal`
  ADD PRIMARY KEY (`cod_auditor`);

--
-- Índices para tabela `simples_auto_infracao`
--
ALTER TABLE `simples_auto_infracao`
  ADD PRIMARY KEY (`cod_auto_infracao`);

--
-- Índices para tabela `simples_contribuinte`
--
ALTER TABLE `simples_contribuinte`
  ADD PRIMARY KEY (`cod_contribuinte`);

--
-- Índices para tabela `simples_endereco`
--
ALTER TABLE `simples_endereco`
  ADD PRIMARY KEY (`cod_endereco`),
  ADD KEY `simples_endereco_FKIndex1` (`cod_contribuinte`);

--
-- Índices para tabela `simples_item_auto_infracao`
--
ALTER TABLE `simples_item_auto_infracao`
  ADD PRIMARY KEY (`cod_item_auto_infracao`),
  ADD KEY `simples_item_auto_infracao_FKIndex1` (`cod_auto_infracao`);

--
-- Índices para tabela `simples_item_verificacao_fiscal`
--
ALTER TABLE `simples_item_verificacao_fiscal`
  ADD PRIMARY KEY (`cod_item_verificacao_fiscal`),
  ADD KEY `simples_item_verificacao_fiscal_FKIndex1` (`cod_verificacao_fiscal`);

--
-- Índices para tabela `simples_selic`
--
ALTER TABLE `simples_selic`
  ADD PRIMARY KEY (`cod_selic`);

--
-- Índices para tabela `simples_situacao`
--
ALTER TABLE `simples_situacao`
  ADD PRIMARY KEY (`cod_situacao`);

--
-- Índices para tabela `simples_verificacao_fiscal`
--
ALTER TABLE `simples_verificacao_fiscal`
  ADD PRIMARY KEY (`cod_verificacao_fiscal`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `admin_desc_cargo`
--
ALTER TABLE `admin_desc_cargo`
  MODIFY `cod_cargo` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `admin_usuarios`
--
ALTER TABLE `admin_usuarios`
  MODIFY `cod_usuario` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `simples_aliquota`
--
ALTER TABLE `simples_aliquota`
  MODIFY `cod_aliquota` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `simples_auditor_fiscal`
--
ALTER TABLE `simples_auditor_fiscal`
  MODIFY `cod_auditor` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `simples_auto_infracao`
--
ALTER TABLE `simples_auto_infracao`
  MODIFY `cod_auto_infracao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de tabela `simples_contribuinte`
--
ALTER TABLE `simples_contribuinte`
  MODIFY `cod_contribuinte` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `simples_endereco`
--
ALTER TABLE `simples_endereco`
  MODIFY `cod_endereco` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `simples_item_auto_infracao`
--
ALTER TABLE `simples_item_auto_infracao`
  MODIFY `cod_item_auto_infracao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `simples_item_verificacao_fiscal`
--
ALTER TABLE `simples_item_verificacao_fiscal`
  MODIFY `cod_item_verificacao_fiscal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de tabela `simples_selic`
--
ALTER TABLE `simples_selic`
  MODIFY `cod_selic` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de tabela `simples_situacao`
--
ALTER TABLE `simples_situacao`
  MODIFY `cod_situacao` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `simples_verificacao_fiscal`
--
ALTER TABLE `simples_verificacao_fiscal`
  MODIFY `cod_verificacao_fiscal` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `admin_usuarios`
--
ALTER TABLE `admin_usuarios`
  ADD CONSTRAINT `admin_usuarios_ibfk_1` FOREIGN KEY (`cod_cargo`) REFERENCES `admin_desc_cargo` (`cod_cargo`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `simples_endereco`
--
ALTER TABLE `simples_endereco`
  ADD CONSTRAINT `simples_endereco_ibfk_1` FOREIGN KEY (`cod_contribuinte`) REFERENCES `simples_contribuinte` (`cod_contribuinte`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `simples_item_auto_infracao`
--
ALTER TABLE `simples_item_auto_infracao`
  ADD CONSTRAINT `simples_item_auto_infracao_ibfk_1` FOREIGN KEY (`cod_auto_infracao`) REFERENCES `simples_auto_infracao` (`cod_auto_infracao`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `simples_item_verificacao_fiscal`
--
ALTER TABLE `simples_item_verificacao_fiscal`
  ADD CONSTRAINT `simples_item_verificacao_fiscal_ibfk_1` FOREIGN KEY (`cod_verificacao_fiscal`) REFERENCES `simples_verificacao_fiscal` (`cod_verificacao_fiscal`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

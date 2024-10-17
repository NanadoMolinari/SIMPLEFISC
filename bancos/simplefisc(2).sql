-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 16-Set-2024 às 13:13
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
-- Banco de dados: `simplefisc`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `auto_infracao`
--

CREATE TABLE `auto_infracao` (
  `cod_auto_infracao` bigint(20) UNSIGNED NOT NULL,
  `cod_verificacao_fiscal` int(11) NOT NULL,
  `data_lavratura` date DEFAULT NULL,
  `data_aceita` date DEFAULT NULL,
  `desc_auto` varchar(500) DEFAULT NULL,
  `valor_principal` float DEFAULT NULL,
  `ano_exercicio` date DEFAULT NULL,
  `data_vencimento` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `item_verificacao_fiscal`
--

CREATE TABLE `item_verificacao_fiscal` (
  `cod_item_verificacao_fiscal` bigint(20) UNSIGNED NOT NULL,
  `cod_verificacao_fiscal` int(11) NOT NULL,
  `periodo_apuracao` date DEFAULT NULL,
  `item_lista` varchar(5) DEFAULT NULL,
  `anexo` varchar(5) DEFAULT NULL,
  `infracao` varchar(3) DEFAULT NULL,
  `receita_bruta_12_declarada` float DEFAULT NULL,
  `base_calculo_declarada` float DEFAULT NULL,
  `aliquota_declarada` float DEFAULT NULL,
  `valor_recolhido` float DEFAULT NULL,
  `receita_bruta_12_apurada` float DEFAULT NULL,
  `base_calculo_apurada` float DEFAULT NULL,
  `aliquota_efetiva` float DEFAULT NULL,
  `valor_apurado` float DEFAULT NULL,
  `valor_principal` float DEFAULT NULL,
  `multa_punitiva` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `item_verificacao_fiscal`
--

INSERT INTO `item_verificacao_fiscal` (`cod_item_verificacao_fiscal`, `cod_verificacao_fiscal`, `periodo_apuracao`, `item_lista`, `anexo`, `infracao`, `receita_bruta_12_declarada`, `base_calculo_declarada`, `aliquota_declarada`, `valor_recolhido`, `receita_bruta_12_apurada`, `base_calculo_apurada`, `aliquota_efetiva`, `valor_apurado`, `valor_principal`, `multa_punitiva`) VALUES
(51, 2, '2022-03-01', '4.01', 'V', 'IA', 12000, 10000, 2.17, 217, 90000, 50000, 2.17, 1085, 868, 100),
(56, 1, '2024-01-01', '4.01', 'III', 'DBC', 1000000, 1000000, 4.04, 40400, 1100000, 1100000, 4.15, 45650, 5250, 75),
(58, 2, '2024-02-01', '11.02', 'III', 'DBC', 100000, 10000, 2.01, 201, 110000, 1100000, 2.01, 22110, 21909, 100);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb.aliquota`
--

CREATE TABLE `tb.aliquota` (
  `id_aliquota` int(11) NOT NULL,
  `anexo` varchar(10) NOT NULL,
  `lim_minimo` double NOT NULL,
  `lim_maximo` double NOT NULL,
  `aliquota` double NOT NULL,
  `aliquota_iss` double NOT NULL,
  `vr_deduzir` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb.aliquota`
--

INSERT INTO `tb.aliquota` (`id_aliquota`, `anexo`, `lim_minimo`, `lim_maximo`, `aliquota`, `aliquota_iss`, `vr_deduzir`) VALUES
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
-- Estrutura da tabela `tb.contribuinte`
--

CREATE TABLE `tb.contribuinte` (
  `cod_pessoa` int(11) NOT NULL,
  `cnpj` bigint(14) NOT NULL,
  `desc_contrinuinte` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb.contribuinte`
--

INSERT INTO `tb.contribuinte` (`cod_pessoa`, `cnpj`, `desc_contrinuinte`) VALUES
(1, 29141322000132, 'Município de Pirai'),
(2, 123456, 'Pirai teste'),
(3, 29333123000155, 'Empresa teste');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin.desc_cargo`
--

CREATE TABLE `tb_admin.desc_cargo` (
  `id_cargo` int(11) NOT NULL,
  `desc_cargo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_admin.desc_cargo`
--

INSERT INTO `tb_admin.desc_cargo` (`id_cargo`, `desc_cargo`) VALUES
(1, 'Usuário'),
(2, 'Administrador');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_admin_usuarios`
--

CREATE TABLE `tb_admin_usuarios` (
  `cod_usuario` int(11) NOT NULL,
  `login_usuario` varchar(255) NOT NULL,
  `nome_usuario` varchar(255) NOT NULL,
  `senha_usuario` varchar(255) NOT NULL,
  `email_usuario` varchar(255) NOT NULL,
  `id_cargo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_admin_usuarios`
--

INSERT INTO `tb_admin_usuarios` (`cod_usuario`, `login_usuario`, `nome_usuario`, `senha_usuario`, `email_usuario`, `id_cargo`) VALUES
(1, 'admin', 'Administrador', 'admin', 'leonardo.molinari@yahoo.com.br', 2),
(2, 'leonardom', 'Leonardo Molinari', 'leonardo', 'teste@teste.com', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_seclic`
--

CREATE TABLE `tb_seclic` (
  `cod_selic` int(11) NOT NULL,
  `dt_selic` date NOT NULL,
  `vr_selic` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Extraindo dados da tabela `tb_seclic`
--

INSERT INTO `tb_seclic` (`cod_selic`, `dt_selic`, `vr_selic`) VALUES
(1, '2019-05-01', '0.54'),
(2, '2019-06-01', '0.47'),
(3, '2019-07-01', '0.57'),
(4, '2019-08-01', '0.50'),
(5, '2019-09-01', '0.46'),
(6, '2019-10-01', '0.48'),
(7, '2019-11-01', '0.38'),
(8, '2019-12-01', '0.37'),
(9, '2020-01-01', '0.38'),
(10, '2020-02-01', '0.29'),
(11, '2020-03-01', '0.34'),
(12, '2020-04-01', '0.28'),
(13, '2020-05-01', '0.24'),
(14, '2020-06-01', '0.21'),
(15, '2020-07-01', '0.19'),
(16, '2020-08-01', '0.16'),
(17, '2020-09-01', '0.16'),
(18, '2020-10-01', '0.16'),
(19, '2020-11-01', '0.15'),
(20, '2020-12-01', '0.16'),
(21, '2021-01-01', '0.15'),
(22, '2021-02-01', '0.13'),
(23, '2021-03-01', '0.20'),
(24, '2021-04-01', '0.21'),
(25, '2021-05-01', '0.27'),
(26, '2021-06-01', '0.31'),
(27, '2021-07-01', '0.36'),
(28, '2021-08-01', '0.43'),
(29, '2021-09-01', '0.44'),
(30, '2021-10-01', '0.49'),
(31, '2021-11-01', '0.59'),
(32, '2021-12-01', '0.77'),
(33, '2022-01-01', '0.73'),
(34, '2022-02-01', '0.76'),
(35, '2022-03-01', '0.93'),
(36, '2022-04-01', '0.83'),
(37, '2022-05-01', '1.03'),
(38, '2022-06-01', '1.02'),
(39, '2022-07-01', '1.03'),
(40, '2022-08-01', '1.17'),
(41, '2022-09-01', '1.07'),
(42, '2022-10-01', '1.02'),
(43, '2022-11-01', '1.02'),
(44, '2022-12-01', '1.12'),
(45, '2023-01-01', '1.12'),
(46, '2023-02-01', '0.92'),
(47, '2023-03-01', '1.17'),
(48, '2023-04-01', '0.92'),
(49, '2023-05-01', '1.12'),
(50, '2023-06-01', '1.07'),
(51, '2023-07-01', '1.07'),
(52, '2023-08-01', '1.14'),
(53, '2023-09-01', '0.97'),
(54, '2023-10-01', '1.00'),
(55, '2023-11-01', '0.92'),
(56, '2023-12-01', '0.89'),
(57, '2024-01-01', '0.97'),
(58, '2024-02-01', '0.80'),
(59, '2024-03-01', '0.83'),
(60, '2024-04-01', '0.89'),
(63, '2024-08-01', '1.12'),
(65, '2024-07-01', '0.91'),
(66, '2024-06-01', '0.79'),
(67, '2024-05-01', '0.83');

-- --------------------------------------------------------

--
-- Estrutura da tabela `verificacao_fiscal`
--

CREATE TABLE `verificacao_fiscal` (
  `cod_verificacao_fiscal` bigint(20) UNSIGNED NOT NULL,
  `data_verificacao` date DEFAULT NULL,
  `desc_verificacao` varchar(500) DEFAULT NULL,
  `cod_pessoa` int(11) DEFAULT NULL,
  `mun_processo_adm` varchar(13) DEFAULT NULL,
  `flg_situacao_verificacao` int(11) DEFAULT NULL,
  `ano_exercicio` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `auto_infracao`
--
ALTER TABLE `auto_infracao`
  ADD PRIMARY KEY (`cod_auto_infracao`),
  ADD UNIQUE KEY `cod_auto_infracao` (`cod_auto_infracao`);

--
-- Índices para tabela `item_verificacao_fiscal`
--
ALTER TABLE `item_verificacao_fiscal`
  ADD PRIMARY KEY (`cod_item_verificacao_fiscal`),
  ADD UNIQUE KEY `cod_item_verificacao_fiscal` (`cod_item_verificacao_fiscal`);

--
-- Índices para tabela `tb.aliquota`
--
ALTER TABLE `tb.aliquota`
  ADD PRIMARY KEY (`id_aliquota`);

--
-- Índices para tabela `tb.contribuinte`
--
ALTER TABLE `tb.contribuinte`
  ADD PRIMARY KEY (`cod_pessoa`);

--
-- Índices para tabela `tb_admin.desc_cargo`
--
ALTER TABLE `tb_admin.desc_cargo`
  ADD PRIMARY KEY (`id_cargo`);

--
-- Índices para tabela `tb_admin_usuarios`
--
ALTER TABLE `tb_admin_usuarios`
  ADD PRIMARY KEY (`cod_usuario`);

--
-- Índices para tabela `tb_seclic`
--
ALTER TABLE `tb_seclic`
  ADD PRIMARY KEY (`cod_selic`);

--
-- Índices para tabela `verificacao_fiscal`
--
ALTER TABLE `verificacao_fiscal`
  ADD PRIMARY KEY (`cod_verificacao_fiscal`),
  ADD UNIQUE KEY `cod_verificacao_fiscal` (`cod_verificacao_fiscal`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `auto_infracao`
--
ALTER TABLE `auto_infracao`
  MODIFY `cod_auto_infracao` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `item_verificacao_fiscal`
--
ALTER TABLE `item_verificacao_fiscal`
  MODIFY `cod_item_verificacao_fiscal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT de tabela `tb.aliquota`
--
ALTER TABLE `tb.aliquota`
  MODIFY `id_aliquota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `tb.contribuinte`
--
ALTER TABLE `tb.contribuinte`
  MODIFY `cod_pessoa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de tabela `tb_admin.desc_cargo`
--
ALTER TABLE `tb_admin.desc_cargo`
  MODIFY `id_cargo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_admin_usuarios`
--
ALTER TABLE `tb_admin_usuarios`
  MODIFY `cod_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `tb_seclic`
--
ALTER TABLE `tb_seclic`
  MODIFY `cod_selic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT de tabela `verificacao_fiscal`
--
ALTER TABLE `verificacao_fiscal`
  MODIFY `cod_verificacao_fiscal` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

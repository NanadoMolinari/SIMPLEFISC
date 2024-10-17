<?php
require_once '../config.php';
function conectarBanco() {
    // Usa as constantes definidas no arquivo de configuração
    $conexao = new mysqli(HOST, USER, PASSWORD, DATABASE);

    if ($conexao->connect_error) {
        die("Erro na conexão: " . $conexao->connect_error);
    }
    return $conexao;
}

function buscarAliquota($conexao, $valor, $anexo)
{
    $sql = "SELECT aliquota, valor_deduzir, aliquota_iss FROM `simples_aliquota` WHERE limite_minimo <= ? AND limite_maximo >= ? AND anexo = ?";
    //$result = $conexao->prepare($sql);
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('dds', $valor, $valor, $anexo);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $aliquota = $row["aliquota"];
        $vr_deduzir = $row['valor_deduzir'];
        $aliquota_iss = $row['aliquota_iss'];

        $resultado = ((($valor * ($aliquota /100)) - $vr_deduzir) / $valor) * 100;
        $resultado = $resultado * ($aliquota_iss / 100);
        if($resultado > 5){
            $resultado = 5;
        }
        if($resultado < 2){
            $resultado = 2;
        }
        $resultado = number_format($resultado, 2, '.', '');
        return $resultado;
    } else {
        return "Nenhuma alíquota encontrada para o valor e anexo especificados.";
    }
}

function buscarSomaSelic($conexao, $mesAno) {
  
    // Divide a string $mesAno em mês e ano
    list($ano, $mes) = explode('/', $mesAno);
    
    // Ajusta o mês e o ano para garantir que estão no formato correto
    $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
    $ano = str_pad($ano, 4, '0', STR_PAD_LEFT);

    // Calcula a data de início e a data de fim
    $dataInicio = date('Y-m-01', strtotime("$ano-$mes"));
    $dataInicio = date('Y-m-d', strtotime($dataInicio . ' +2 month')); 
    $dataFim = date('Y-m-d', strtotime('first day of -1 month'));
    
    $sql = "SELECT SUM(valor_selic) AS total_selic FROM simples_selic WHERE data_selic BETWEEN ? AND ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param('ss', $dataInicio, $dataFim);
    $stmt->execute();
    $result = $stmt->get_result();
   
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $selic = $row["total_selic"] + 1;
        return $selic;
    } else {
        return "nenhum valor de Selic";
    }
}

// Conectar ao banco de dados
$conexao = conectarBanco();
if ($conexao->connect_error) {
    die("Erro na conexão: " . $conexao->connect_error);
}


$rbt12Declarado = $_GET['RBT12declarado'];
$rbt12Apurado = $_GET['RBT12Apurado'];
$anexo = $_GET['anexo'];
$data = $_GET['data'];

$aliquota = buscarAliquota($conexao, $rbt12Declarado, $anexo);
$mesAno = date('Y-m', strtotime($data));
$somaSelic = buscarSomaSelic($conexao, $data);
$aliquotaApurada = buscarAliquota($conexao, $rbt12Apurado, $anexo);

echo $aliquota . '|' . $somaSelic . '|' . $aliquotaApurada;

$conexao->close();
?>
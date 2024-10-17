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
function buscarSomaSelic($conexao, $mesAno) {
  
    // Divide a string $mesAno em mês e ano
    list($ano, $mes) = explode('/', $mesAno);
    
    // Ajusta o mês e o ano para garantir que estão no formato correto
    $mes = str_pad($mes, 2, '0', STR_PAD_LEFT);
    $ano = str_pad($ano, 4, '0', STR_PAD_LEFT);

    // Calcula a data de início e a data de fim
    $dataInicio = date('Y-m-01', strtotime("$ano-$mes"));
    $dataInicio = date('Y-m-d', strtotime($dataInicio . ' +1 month')); 
    $dataFim = date('Y-m-d', strtotime('first day of -1 month'));

    // Adiciona logging para verificação
    error_log("Data Início: " . $dataInicio);
    error_log("Data Fim: " . $dataFim);
    
    $sql = "SELECT SUM(vr_selic) AS total_selic FROM tb_seclic WHERE dt_selic BETWEEN ? AND ?";
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


$data = $_GET['data'];

$somaSelic = buscarSomaSelic($conexao, $data);

echo $somaSelic;
?>

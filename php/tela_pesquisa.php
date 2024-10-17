<?php
// Conexão com o banco de dados
require '../config.php';
require '../classes/Painel.php';

// Verifica se os parâmetros foram recebidos via POST
$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';
$nome = isset($_POST['nome']) ? $_POST['nome'] : '';
$cnpj = isset($_POST['cnpj']) ? $_POST['cnpj'] : '';

// Prepara a consulta SQL com base nos valores recebidos

if ($codigo == '' && $nome == '' && $cnpj == '') {
    // Se nenhum parâmetro for passado, busca todos os registros
    $sql = MySql::conectar()->prepare("SELECT * FROM `simples_contribuinte`");
} else {
$sql = MySql::conectar()->prepare("SELECT * FROM `simples_contribuinte` WHERE 
    (cod_contribuinte LIKE ? OR ? = '') AND 
    (razao_social LIKE ? OR ? = '') AND 
    (CNPJ LIKE ? OR ? = '')");

// Preenche os parâmetros na consulta
$sql->execute([
    '%' . $codigo . '%', $codigo,
    '%' . $nome . '%', $nome,
    '%' . $cnpj . '%', $cnpj
]);
}
$numLinhas = $sql->rowCount();
echo "Número de registros encontrados: " . $numLinhas;

$sql->execute();
// Exibe os resultados
if ($sql->rowCount() > 0) {
    $resultados = $sql->fetchAll();
    foreach ($resultados as $resultado) {
        echo '<tr class="clickable-row" data-codigo="' . $resultado['cod_contribuinte'] . '" data-nome="' . $resultado['razao_social'] . '" data-cnpj="' . $resultado['CNPJ'] . '">';
        echo '<td>' . $resultado['cod_contribuinte'] . '</td>';
        echo '<td>' . $resultado['razao_social'] . '</td>';
        echo '<td>' . $resultado['CNPJ'] . '</td>';
        echo '</tr>';
    }
}  else {
    echo '<tr><td colspan="3">Nenhum resultado encontrado.</td></tr>';
}
?>

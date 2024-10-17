<?php
require '../config.php';

if (isset($_POST['cod_verificacao_fiscal'])) {
    $codVerificacaoFiscal = $_POST['cod_verificacao_fiscal'];
    $sql1 = MySql::conectar()->prepare("DELETE FROM simples_item_verificacao_fiscal WHERE cod_verificacao_fiscal = ?");
    $sql1->execute([$codVerificacaoFiscal]);
    // Prepara a consulta para excluir o registro
    $sql = MySql::conectar()->prepare("DELETE FROM simples_verificacao_fiscal WHERE cod_verificacao_fiscal = ?");
    if ($sql->execute([$codVerificacaoFiscal])) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
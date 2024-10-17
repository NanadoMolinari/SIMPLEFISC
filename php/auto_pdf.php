<?php
require_once '../config.php';
require '../vendor/autoload.php';  

if (isset($_GET['cod_verificacao_fiscal'])) {
    $cod_verificacao_fiscal = $_GET['cod_verificacao_fiscal'];
} else {
    die("Erro: Código de verificação fiscal não definido.");
}

use Dompdf\Dompdf;
use Dompdf\Options;

// Configurações para a geração do PDF
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);

// Instanciando o Dompdf com as opções
$dompdf = new Dompdf($options);

// Buscando os dados do banco de dados
$cod_verificacao_fiscal = $_GET['cod_verificacao_fiscal'];  
$sql = MySql::conectar()->prepare("SELECT ai.cod_auto_infracao, ctb.razao_social, ctb.CNPJ, ai.desc_relato, ai.desc_infrigencia_legal, ai.vr_total_auto 
                                    FROM simples_auto_infracao ai
                                    INNER JOIN simples_verificacao_fiscal vf ON ai.cod_verificacao_fiscal = vf.cod_verificacao_fiscal
                                    INNER JOIN simples_contribuinte ctb ON ctb.cod_contribuinte = vf.cod_contribuinte
                                    
                                    WHERE vf.cod_verificacao_fiscal = ?");
$sql->execute([$cod_verificacao_fiscal]);
$auto = $sql->fetch();

// HTML do conteúdo do Auto de Infração
$html = '
<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .clear {clear: both;}
        .header { align-items: center; margin-bottom: 20px; padding: 10px; } 
        .logo {
                float: left; 
                height: 80px; 
                width: 200px;
                position:absolute;
                top: 2px;
                margin-left: 5px;
                background-image: url("http://localhost/SIMPLEFISC/images/logo.png");
                background-size: cover;
                background-size: contain; 
                background-repeat: no-repeat; 
                background-position: center; 
                /*border: 1px solid black;*/
            } 
        .cabecalho { text-align: center;  padding: 10px;  border: 1px solid black; } 
        .cabecalho h1, .cabecalho h2 { margin: 0; } 
        .cabecalho h1{font-size: 20px;}
        .cabecalho h2{font-size: 15px;}
        .info { margin-top: 20px; }
        .info div { margin-bottom: 10px; }
        .valores { margin-top: 20px; }
        .valores table { width: 100%; border-collapse: collapse; }
        .valores th, .valores td { border: 1px solid #000; padding: 8px; text-align: center; }
        .assinatura { margin-top: 40px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            
        </div>
        <div class="cabecalho">
            <h1>AUTO DE INFRAÇÃO - SIMPLES NACIONAL</h1>
            <h2>Auto de Infração Nº ' . $auto['cod_auto_infracao'] . '</h2>
        </div> 
    </div> <div class="clear"></div>
   
    
    <div class="info">
        <div><strong>Autuado:</strong> ' . $auto['razao_social'] . '</div>
        <div><strong>CPF/CNPJ:</strong> ' . $auto['CNPJ'] . '</div>
        <div><strong>Relato:</strong> ' . $auto['desc_relato'] . '</div>
        <div><strong>Fundamentação Legal:</strong> ' . $auto['desc_infrigencia_legal'] . '</div>
    </div>

    <div class="valores">
        <table>
            <thead>
                <tr>
                    <th>Encargo</th>
                    <th>Valor (R$)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Valor Principal</td>
                    <td>' . $auto['vr_total_auto'] . '</td>
                </tr>
                <tr>
                    <td>Multa</td>
                    <td>' . $auto['vr_total_auto'] . '</td>
                </tr>
                <tr>
                    <td>Juros</td>
                    <td>' . $auto['vr_total_auto'] . '</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>' . $auto['vr_total_auto'] . '</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="assinatura">
        <p>________________________</p>
        <p>Assinatura do Auditor</p>
    </div>
</body>
</html>
';

// Carregar o HTML no DOMPDF
$dompdf->loadHtml($html);

// Definir o tamanho do papel e a orientação
$dompdf->setPaper('A4', 'portrait');

// Renderizar o PDF
$dompdf->render();
$dompdf->stream("auto.pdf", ["Attachment" => true]);
?>

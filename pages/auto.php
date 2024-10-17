<?php
    // COLOCAR UM LEFT JOIN PARA PEGAR O COD DO AUTO;
     $sql = MySql::conectar()->prepare("SELECT DISTINCT vf.cod_verificacao_fiscal, ctb.razao_social, ctb.cnpj, sit.icone_situacao, sit.cod_situacao, ai.data_vencimento, vf.flg_situacao_verificacao
      FROM simples_verificacao_fiscal vf
       LEFT JOIN simples_auto_infracao ai ON ai.cod_verificacao_fiscal = vf.cod_verificacao_fiscal
      INNER JOIN `simples_contribuinte` ctb ON vf.cod_contribuinte = ctb.cod_contribuinte
      INNER JOIN simples_situacao sit on sit.cod_situacao = vf.flg_situacao_verificacao
      ORDER BY vf.cod_verificacao_fiscal ASC");
    $sql->execute();
    $Autos=$sql->fetchAll();

    $sql->execute();
    $Autos = $sql->fetchAll();
    
    // Verificar se a data de vencimento é maior que a data atual e atualizar a situação
    $houveAtualizacao = false;
    $dataAtual = new DateTime(); // Mantém como objeto DateTime para fazer a comparação
    
    foreach ($Autos as $auto) {
        if (!empty($auto['data_vencimento'])) {
            $dataVencimento = new DateTime($auto['data_vencimento']); // Converte data_vencimento em objeto DateTime
            
            // Comparar ambos como objetos DateTime
            if ($dataVencimento < $dataAtual && $auto['flg_situacao_verificacao'] != 5) {
                // Atualizar a situação para 5 (vencido)
                $sqlUpdate = MySql::conectar()->prepare("
                    UPDATE simples_verificacao_fiscal 
                    SET flg_situacao_verificacao = 5 
                    WHERE cod_verificacao_fiscal = ?
                ");
                $sqlUpdate->execute([$auto['cod_verificacao_fiscal']]);
                $houveAtualizacao = true; // Marca que houve uma atualização
            }
        }
    }

    // Se houve atualização, redireciona
    if ($houveAtualizacao) {
        header("Location: auto");
        exit;
    }
    



    $sql = MySql::conectar()->prepare("SELECT * FROM simples_situacao");
    $sql->execute();
    $situacao=$sql->fetchAll();

?>


<section class="topo">
    <div class="container">
        <div class="banner">
            <h2>Autos de Infração</h2>
        </div><!--banner-->
    </div><!--container-->
</section><!--topo-->

<section class="corpo">
    <div class="container">
        <div class="box">
            <div class="auto">
                <a href="create_auto">+ Novo Auto</a>
            </div><!--auto-->
        </div><!--box-->
    </div><!--container-->
</section><!--corpo-->
<div class="clear"></div>     
<section class="list"><!--era list-->
    <div class="container">
        <div class="box">

            <div class="resultados-busca-auto">
                
                <table id="resultado-auto">
                    <thead>
                        <tr>
                            <th>Situação</th>
                            <th>ID</th>
                            <th>Razão Social</th>
                            <th>CNPJ</th>
                            <th class="azul centro-tabela">Editar</th>
                            <th class="vermelho centro-tabela">Excluir</th>
                        </tr>
                    </thead>
                    <tbody id="resultadoAuto">
                        <?php foreach ($Autos as $resultado) {
                                echo '<tr>';
                                echo '<td>' .$resultado['icone_situacao']. '</td>';
                                echo '<td>' . $resultado['cod_verificacao_fiscal'] . '</td>';
                                echo '<td>' . $resultado['razao_social'] . '</td>';
                                echo '<td>' . $resultado['cnpj'] . '</td>';
                                echo '<td class="centro-tabela"><a class="editar-auto" data-cod="' . $resultado['cod_verificacao_fiscal'] . '" data-situacao="' . $resultado['cod_situacao'] . '"><i class="fa-solid fa-pen-to-square azul"></i></a></td>';
                                echo '<td class="centro-tabela"><a class="excluir-auto" data-cod="' . $resultado['cod_verificacao_fiscal'] . '"><i class="fa-solid fa-trash-can lixo"></i></a></td>';
                            }
                        ?>
                    </tbody>
                </table>
            </div><!--resultado-busca-->
            <div>
    <br><table style="border-collapse: collapse; text-align:center;">
        <tr>
            <th colspan="<?php echo count($situacao); ?>" style="text-align:center;" class="legenda">Legenda</th>
        </tr>
        <tr>
            <?php 
                foreach ($situacao as $dados){
                    echo '<td style="text-align:center; padding: 5px;">' . $dados['icone_situacao'] . $dados['desc_situacao'] . ' | </td>';
                }
            ?>
        </tr>
    </table>
</div>
        </div><!--box-->
    </div><!--container-->
</section><!--corpo-->

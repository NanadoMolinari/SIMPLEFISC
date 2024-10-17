<?php

if (isset($_GET['cod_verificacao_fiscal'])) {
    $codVerificacaoFiscal = $_GET['cod_verificacao_fiscal'];

    
    $sql = MySql::conectar()->prepare("SELECT *
                                       FROM simples_verificacao_fiscal vf 
                                     
                                       INNER JOIN `simples_contribuinte` ctb ON vf.cod_contribuinte = ctb.cod_contribuinte
                                       INNER JOIN simples_auto_infracao ai on ai.cod_verificacao_fiscal = vf.cod_verificacao_fiscal 
                                       WHERE vf.cod_verificacao_fiscal = ?");
    $sql->execute([$codVerificacaoFiscal]);
    $auto = $sql->fetch();

    $sql1 = MySql::conectar()->prepare("SELECT *
                                        FROM simples_item_verificacao_fiscal
                                        WHERE cod_verificacao_fiscal = ?
                                        ORDER BY periodo_apuracao ASC
    ");
    $sql1->execute([$codVerificacaoFiscal]);
    $itensAuto = $sql1->fetchAll();

    $dataAtual = date('Y/m/d');
    $dataAtual = new DateTime();
     $dataAtual->modify('last day of this month');
    $limiteMaximo = $dataAtual->format('Y-m-d');

    if (isset($_POST['finalizarAuto'])) {
        
   
        $dadosAuto = [
            'vencimento' => $_POST['vencimento'],
            'aceite' => $_POST['aceite'],
            'totalAuto' => $_POST['totalAuto'],
            'valorAutoDesconto' => $_POST['valor_total'],
            'reducaoAuto' => $_POST['descontoMultaP'],
            'codVerificacao' => $codVerificacaoFiscal,
            'relato' => $_POST['relato'],
            'infrigencia' => $_POST['infrigencia']
        ];
        Painel::finalizarAutoInfracao($dadosAuto);
        header("Location: auto_infracao?cod_verificacao_fiscal=" . $codVerificacaoFiscal);
        exit;
    }


}


?>

<section class="topo">
    <div class="container">
        <div class="banner">
            <h2>Autos de Infração</h2>
        </div><!--banner-->
        </div><!--container-->
</section><!--topo-->
<form method="post">

    <div class="list">
        <div class="box">
            <div class="container">
                <div class="list-content w20">
                    <label for="cod_pessoa">Código</label>
                    <input class="readonly" type="text" name="codigo" value="<?php echo $auto['cod_contribuinte']; ?>" readonly>
                <!-- <input type="submit" id="busca_pessoa" name="busca_pessoa" value="Buscar">-->
                </div>
                <div class="list-content direita w50">
                    <label for="cnpj">CNPJ</label>
                    <input class="readonly" type="text" name="cnpj" value="<?php echo $auto['CNPJ']; ?>" readonky>
                </div>
                <div class="clear"></div>
                <div class="w100">
                <label for="razao_social">Razão Social</label>
                <input class="w100 readonly" type="text" name="razao_social" value="<?php echo $auto['razao_social']; ?>" radonly /></div>
            </div><!--container-->
                
        </div><!--box-->       
    </div><!--list-->


<div class="create">
    <div class="box">
        <div class="container desc-auto">
            <label for="relato">Relato</label><br>
            <textarea id="relato" name="relato"> <?php echo $auto['desc_relato']; ?></textarea>
        </div>
        <div class="container desc-auto">
            <label for="infrigencia" >Fundamentação Legal</label><br>
            <textarea id="infrigencia" name="infrigencia"> <?php echo $auto['desc_infrigencia_legal']; ?></textarea>
        </div>
        <div class="container resultados-busca-auto">
            <table class="titulo">
                <thead>
                    <tr>
                        <th>PA</th>
                        <th>VENCIMENTO</th>
                        <!--<th>RECEITA (A)</th>-->
                        <th>VALOR ORIGINAL</th>
                        <th>JUROS DE MORA</th>
                        <th>MULTA DE MORA</th>
                        <th>MULTA PUNITIVA</th>
                        <th>VALOR ATUALIZADO</th>
                        
                    </tr>
                </thead>
                <tbody class='tbody'>
                    
                <?php 
                 $totalOriginal = 0;
                 $totalJurosMora = 0;
                 $totalMultaMora = 0;
                 $totalMultaPunitiva = 0;
                 $totalAtualizado = 0;
                 $i=1;
                 

                foreach ($itensAuto as $resultado) {
                    echo '<tr>';
                    echo '<td>' . date('m/Y', strtotime($resultado['periodo_apuracao'])) . '</td>';
                    echo '<td>' . date('d/m/Y', strtotime($resultado['data_vencomento'])) . '</td>';
                   // echo '<td>' . $resultado['vr_base_calculo_apudada'] . '</td>';
                    echo '<td>' . $resultado['vr_original'] . '</td>';
                    echo '<td>' . $resultado['vr_juros_mora'] . '</td>';
                    echo '<td>' . $resultado['vr_multa_mora'] . '</td>';
                    echo '<td>' . $resultado['vr_multa_punitiva'] . '</td>';
                    echo '<td>' . $resultado['vr_atualizado'] . '</td>';
                     // Somando valores
                     //$totalRBT12 += $resultado['vr_receita_b12_apurada'];
                     //$totalReceita += $resultado['vr_base_calculo_apudada'];
                     $totalOriginal += $resultado['vr_original'];
                     $totalJurosMora += $resultado['vr_juros_mora'];
                     $totalMultaMora += $resultado['vr_multa_mora'];
                     $totalMultaPunitiva += $resultado['vr_multa_punitiva'];
                     $totalAtualizado += $resultado['vr_atualizado'];
                 }
                 ?>
                 </tbody>
                 <tfoot>
                     <tr>
                         <td><strong>Total:</td>
                         <td><strong>--</strong></td>
                        <!-- <td><strong><?php echo $totalReceita; ?></strong></td>-->
                         <td><strong><?php echo $totalOriginal; ?></strong></td>
                         <td><strong><?php echo $totalJurosMora; ?></strong></td>
                         <td><strong><?php echo $totalMultaMora; ?></strong></td>
                         <td><strong><?php echo $totalMultaPunitiva; ?></strong></td>
                         <td><strong> <?php echo $totalAtualizado;?> </td>
                     </tr>
                 </tfoot>
                    
            </table>
         
                <div class="list datas">
                    <div class="wrap-datas">
                        <label for="aceite">Data do Aceite</label> 
                        <input type="date" id="aceite" name="aceite" onchange="atualizarVencimento()" value="<?php echo $auto['data_vencimento'] ?>">
                    </div>
                    <div class="wrap-datas">
                        <label for="vencimento">Data do Vencimento</label> 
                        <input type="date" id="vencimento" name="vencimento" value="<?php echo $auto['data_vencimento'] ?>" class="readonly" readonly>
                        <p style="width: 900px; margin-top: 10px;">* Data do vencimento até o último dia do mês atual</p>
                    </div>
                </div>
                 <div class="list lanc-auto">
                    <label for="descontoMultaP">Redução da Multa Punitiva</label>
                    <select id= "descontoMultaP" name="descontoMultaP">
                        <option value="0" <?php echo ($auto['perc_reducao'] == '0') ? 'selected' : ''; ?>>Sem Redução</option>
                        <option value="30" <?php echo ($auto['perc_reducao'] == '30') ? 'selected' : ''; ?>>30%</option>
                        <option value="50" <?php echo ($auto['perc_reducao'] == '50') ? 'selected' : ''; ?>>50%</option>
                    </select>
                </div>

         
           <div class="totalizar">
                    <div>
                        <button id="calculoAuto">Calcular</button>
                    </div>
                    <div class="tot_auto">
                        <div class="total-container">
                            <label for="total_valor" class="titulo">Total:</label>
                            <input type="hidden" id="totalAuto" name="totalAuto" value="<?php echo $auto['vr_total_auto']; ?>">
                            <input type="text" id="valor_total" name="valor_total" class="total" value="<?php 
                                                                                                            if ($i=1){
                                                                                                                echo $auto['vr_total_com_reducao'];
                                                                                                                $i=0;
                                                                                                            }else {echo $totalAtualizado;}
                                                                                                        ?>" readonly>
                        </div>  
                    </div>
                   
                </div><!--totalizar-->
              
            <div class="botao-salvar direita">
               <!-- <button id="" name="btnAtualizar" type="submit">Salvar</button>-->
               <button id="vinalizarAuto" name="finalizarAuto" type="submit">Recalcular Auto</button>
               <a href="php\auto_pdf.php?cod_verificacao_fiscal=<?php echo $resultado['cod_verificacao_fiscal']; ?>">Imprimir</a>
            </div>
            <br><br><br>
        </div>
    </div>
</div> 
</form> 
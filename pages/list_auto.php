<!--input hidem com o cod_item_verificacao_fiscal para verificar o que foi excluido, incluiro ou alterado para salvar no banco-->
<?php
if(isset($_SESSION['sucesso'])){
    Painel::alert('sucesso', $_SESSION['sucesso']);
    unset($_SESSION['sucesso']);
}

if (isset($_GET['cod_verificacao_fiscal'])) {
    $cod_verificacao_fiscal = $_GET['cod_verificacao_fiscal'];
    $sql = MySql::conectar()->prepare("SELECT * FROM `simples_verificacao_fiscal` vf 
                                        INNER JOIN `simples_item_verificacao_fiscal` ivf ON vf.cod_verificacao_fiscal = ivf.cod_verificacao_fiscal 
                                        WHERE vf.cod_verificacao_fiscal = ?");
    $sql->execute(array($cod_verificacao_fiscal));
    $items = $sql->fetchAll();

   foreach ($items as $item) {
        $sql = MySql::conectar()->prepare("SELECT * FROM `simples_contribuinte` WHERE cod_contribuinte = ?");
        $sql->execute(array($item['cod_contribuinte']));
        $dadosPessoa = $sql->fetch();

    }
}
if (isset($_POST['lancarAuto'])){
    header("Location: lanc_auto?cod_verificacao_fiscal=" . $cod_verificacao_fiscal);
}
if (isset($_POST['btnAtualizar'])) {
    $codigosAtuais = [];
    $alterar = [];
    $excluir = [];
    $incluir = [];

    // Armazena todos os dados do formulário em $codigosAtuais
    foreach ($_POST as $key => $value) {
        $codigosAtuais[$key] = $value;
    }

    // Itera sobre os itens existentes no banco de dados
    foreach ($items as $item) {
        $encontrado = false;

        // Verifica se o item existe no formulário
        foreach ($codigosAtuais as $key => $value) {
            if (strpos($key, 'codVerificacao_') === 0) {
                $index = str_replace('codVerificacao_', '', $key);

                if ($value == $item['cod_item_verificacao_fiscal']) {
                    $encontrado = true; // Item encontrado no formulário
                    $alterarLinha = [
                        'cod_verificacao' => $codigosAtuais['codVerificacao_' . $index],
                        'periodoApuracao' => converterPAParaDate($codigosAtuais['pa_' . $index]),
                        'iLista' => $codigosAtuais['iLista_' . $index],
                        'anexo' => $codigosAtuais['anexo_' . $index],
                        'infracao' => $codigosAtuais['infracao_'. $index],
                        'rbt12d' => $codigosAtuais['rbt12d_' . $index ],
                        //'rbt12d' => str_replace('.', '', str_replace(',', '.', $_POST['rbt12d_' . ($i + 1)])),
                        'recd' => $codigosAtuais['recd_' . $index],
                        'alqd' => $codigosAtuais['alqd_' . $index],
                        'ISSPg' => $codigosAtuais['ISSPg_' . $index],
                        'rbt12a' => $codigosAtuais['rbt12a_' . $index],
                        'reca' => $codigosAtuais['reca_' . $index],
                        'aliquota' => $codigosAtuais['alquota_' . $index],
                        'vrapr' => $codigosAtuais['vrapr_' . $index],
                        'vrpincipal' => $codigosAtuais['vrprincipal_' . $index],
                        'vrselic' => $codigosAtuais['vrselic_'. $index],
                        'pselic' => $codigosAtuais['pselic_' . $index],
                        'MultaP' => $codigosAtuais['MultaP_' . $index],
                        'vrMultap' => $codigosAtuais['vrmultap_' . $index],
                        'vrAtualizado' => $codigosAtuais['vrcredito_' . $index]
                    ];
                    $alterar[] = $alterarLinha; // Marcar para atualização
                    break;
                }
            }
        }

        // Se não encontrado, adicionar ao array de exclusão
        if (!$encontrado) {
            $excluir[] = $item['cod_item_verificacao_fiscal'];
        }
    }

    // Executa atualizações e exclusões
    if (!empty($alterar)) {
        Painel::alterarItemAuto($alterar);
    }

    if (!empty($excluir)) {
        Painel::excluirItenAuto($excluir);
    }

    // Verifica inclusões
    foreach ($codigosAtuais as $key => $value) {
        if (strpos($key, 'codVerificacao_') === 0 && empty($value)) {
            $index = str_replace('codVerificacao_', '', $key);
            $incluirLinha = [
                'cod_verificacao_fiscal' => $_GET['cod_verificacao_fiscal'],
                'cod_pessoa' => $codigosAtuais['codigo'],
                'cod_verificacao' => $codigosAtuais['codVerificacao_' . $index],
                'pa' => isset($codigosAtuais['pa_' . $index]) ? converterPAParaDate($codigosAtuais['pa_' . $index]) : '',
                'vencimento' => '2024-01-01',
                'iLista' => $codigosAtuais['iLista_' . $index],
                'anexo' => $codigosAtuais['anexo_' . $index],
                'infracao' => $codigosAtuais['infracao_'. $index],
                'rbt12d' => $codigosAtuais['rbt12d_' . $index],
                'recd' => $codigosAtuais['recd_' . $index],
                'alqd' => $codigosAtuais['alqd_' . $index],
                'ISSPg' => $codigosAtuais['ISSPg_' . $index],
                'rbt12a' => $codigosAtuais['rbt12a_' . $index],
                'reca' => $codigosAtuais['reca_' . $index],
                'aliquota' => $codigosAtuais['alquota_' . $index],
                'vrapr' => $codigosAtuais['vrapr_' . $index],
                'vrpincipal' => $codigosAtuais['vrprincipal_' . $index],
                'vrselic' => $codigosAtuais['vrselic_' .$index],
                'pselic' => $codigosAtuais['pselic_' . $index],
                'vrMultap' => $codigosAtuais['vrmultap_' . $index],
                'MultaP' => $codigosAtuais['MultaP_' . $index],
                'vrAtualizado' => $codigosAtuais['vrcredito_' . $index]

            ];
            $incluir[] = $incluirLinha;
        }
    }

    // Executa inclusões
    if (!empty($incluir)) {
        Painel::incluirDadosAuto($incluir);
    }

    // Redirecionar após todas as operações
    $_SESSION['sucesso'] = "Dados alterados com sucesso";
    header("Location: list_auto?cod_verificacao_fiscal=" . $cod_verificacao_fiscal);
    exit();
}

   

?>


<section class="topo">
    <div class="container">
        <div class="banner">
            <h2>Autos de Infração - Edição</h2>
        </div>
    </div>
</section>

<form method="post">

    <div class="list">
        <div class="box">
            <div class="container">
                <div class="list-content w20">
                    <label for="cod_pessoa">Código</label>
                    <input class="readonly" type="text" name="codigo" value="<?php echo $dadosPessoa['cod_contribuinte']; ?>" readonly>
                   <!-- <input type="submit" id="busca_pessoa" name="busca_pessoa" value="Buscar">-->
                </div>
                <div class="list-content direita w50">
                    <label for="cnpj">CNPJ</label>
                    <input class="readonly" type="text" name="cnpj" value="<?php echo $dadosPessoa['CNPJ']; ?>" readonky>
                </div>
                <div class="clear"></div>
                <div class="w100">
                <label for="razao_social">Razão Social</label>
                <input class="w100 readonly" type="text" name="razao_social" value="<?php echo $dadosPessoa['razao_social']; ?>" radonly /></div>
            </div><!--container-->
                
        </div><!--box-->       
    </div><!--list-->
        
    <div class="create">
        <div class="box">
            <div class="container">
                <table class="titulo">
                    <tbody class='tbody'><?php $totalCredito = 0.00; ?>
                        <?php foreach($items as $key => $item): ?>
                        <tr class='tr_input' id='linha_<?php echo $key + 1; ?>'>
                            <td class="row-table">
                                <div class="linha-tabela">
                                    <input type="hidden" id="codVerificacao_<?php echo $key + 1; ?>" name="codVerificacao_<?php echo $key +1; ?>" value="<?php echo $item['cod_item_verificacao_fiscal']; ?>" />
                                    <div><label>PA <i class="fa-regular fa-circle-question"></i></label></div>
                                    <div><input type="text" id='pa_<?php echo $key + 1; ?>' name='pa_<?php echo $key + 1; ?>' value="<?php echo date('m/Y', strtotime($item['periodo_apuracao'])); ?>" placeholder="XX/XXXX"/></div>
                                    <div><label>Item Lista</label></div>
                                    <div><input type="text" id='iLista_<?php echo $key + 1; ?>' name="iLista_<?php echo $key + 1; ?>" value="<?php echo $item['item_lista']; ?>" /></div>
                                    <div><label>Anexo <i class="fa-regular fa-circle-question"></i></label></div>
                                    <div>
                                        <select id='anexo_<?php echo $key + 1; ?>' name='anexo_<?php echo $key + 1; ?>'>
                                            <option value="0">Selecione</option>
                                            <option value="III" <?php echo ($item['anexo'] == 'III') ? 'selected' : ''; ?>>III</option>
                                            <option value="IV" <?php echo ($item['anexo'] == 'IV') ? 'selected' : ''; ?>>IV</option>
                                            <option value="V" <?php echo ($item['anexo'] == 'V') ? 'selected' : ''; ?>>V</option>
                                        </select>
                                    </div>
                                    <div><label>Infração <i class="fa-regular fa-circle-question"></i></label></div>
                                    <div>
                                        <select id='infracao_<?php echo $key + 1; ?>' name='infracao_<?php echo $key + 1; ?>'>
                                            <option value="0">Selecione</option>
                                            <option value="DBC" <?php echo ($item['tipo_infracao'] == 'DBC') ? 'selected' : ''; ?>>DBC</option>
                                            <option value="IA" <?php echo ($item['tipo_infracao'] == 'IA') ? 'selected' : ''; ?>>IA</option>
                                            <option value="OMR" <?php echo ($item['tipo_infracao'] == 'OMR') ? 'selected' : ''; ?>>OMR</option>
                                            <option value="SIR" <?php echo ($item['tipo_infracao'] == 'SIR') ? 'selected' : ''; ?>>SIR</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="linha-tabela">
                                    <div><label>RBT12 - D <i class="fa-regular fa-circle-question"></i><i id="add_rec_D" class="fa-solid fa-circle-plus direita add-rec"></i></label></div>
                                    <div><input type="text" id='rbt12d_<?php echo $key + 1; ?>' name="rbt12d_<?php echo $key + 1; ?>" value="<?php echo $item['vr_receita_b12_declarada']; ?>" onchange="formatarValorDecimal(this)"/></div>
                                    <div><label>Receita Declarada <i class="fa-regular fa-circle-question"></i></label></div>
                                    <div><input type="text" id='recd_<?php echo $key + 1; ?>' name='recd_<?php echo $key + 1;?>' value="<?php echo $item['vr_base_calculo_declarada']; ?>" onchange="formatarValorDecimal(this)"/></div>
                                    <div><label>Alíquota Declarada <i class="fa-regular fa-circle-question"></i></label></div>
                                    <div><input type="text" id="alqd_<?php echo $key + 1; ?>" name="alqd_<?php echo $key + 1;?>" value="<?php echo $item['aliquota_declarada']; ?>" readonly/></div>
                                    <div><label>ISS Pago <i class="fa-regular fa-circle-question"></i></label></div>
                                    <div><input type="text" id="ISSPg_<?php echo $key + 1; ?>" name="ISSPg_<?php echo $key + 1; ?>" value="<?php echo $item['vr_recolhido']; ?>" onchange="formatarValorDecimal(this)" /></div>
                                </div>
                                <div class="linha-tabela">
                                    <div><label>RBT12 - A <i class="fa-regular fa-circle-question"></i><i class="fa-solid fa-circle-plus direita add-rec"></i></label></div>
                                    <div><input type="text" id="rbt12a_<?php echo $key + 1; ?>" name="rbt12a_<?php echo $key + 1; ?>" value="<?php echo $item['vr_receita_b12_apurada']; ?>" onchange="formatarValorDecimal(this)"/></div>
                                    <div><label>Receita Apurada <i class="fa-regular fa-circle-question"></i></label></div>
                                    <div><input type="text" id='reca_<?php echo $key + 1; ?>' name="reca_<?php echo $key + 1; ?>" value=" <?php echo $item['vr_base_calculo_apudada']; ?>" onchange="formatarValorDecimal(this)"/></div>
                                    <div><label>Alíquota Efetiva <i class="fa-regular fa-circle-question"></i></label></div>
                                    <div><input type="text" id="alquota_<?php echo $key + 1; ?>" name="alquota_<?php echo $key + 1; ?>" value="<?php echo $item['aliquota_efetiva']; ?>" readonly/></div>
                                    <div><label>Valor Apurado <i class="fa-regular fa-circle-question"></i></label></div>
                                    <div><input type="text" id="vrapr_<?php echo $key + 1; ?>" name="vrapr_<?php echo $key +1; ?>" value="<?php echo $item['vr_apurado']; ?>" readonly/></div>
                                </div>
                                <div class="linha-tabela">
                                            <div><label>Valor Principal <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="vrpincipal_<?php echo $key + 1; ?>" name="vrprincipal_<?php echo $key + 1; ?>" value="<?php echo $item['vr_original']; ?>" readonly/></div>
                                            <div><label>SELIC (%) <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="pselic_<?php echo $key + 1; ?>" name="pselic_<?php echo $key + 1;?>" value="<?php echo $item['perc_juros_mora']; ?>"  readonly/></div>
                                            <div><label>SELIC (R$) <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="vrselic_<?php echo $key + 1; ?>" name="vrselic_<?php echo $key +1 ;?>" value="<?php echo $item['vr_juros_mora']; ?>" readonly/></div>
                                            <div><label>Multa Punitiva (%) <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div>
                                                <select id= "MultaP_<?php echo $key + 1;?>" name="MultaP_<?php echo $key +1; ?>">
                                                    <option value="0">Selecione</option>
                                                    <option value="75" <?php echo ($item['perc_multa_punitiva'] == '75') ? 'selected' : ''; ?>>75,00%</option>
                                                    <option value="100"<?php echo ($item['perc_multa_punitiva'] == '100') ? 'selected' : ''; ?>>100,00%</option>
                                                    <option value="112.5" <?php echo ($item['perc_multa_punitiva'] == '112.5') ? 'selected' : ''; ?>>112,50%</option>
                                                    <option value="150" <?php echo ($item['perc_multa_punitiva'] == '150') ? 'selected' : ''; ?>>150,00%</option>
                                                    <option value="225" <?php echo ($item['perc_multa_punitiva'] == '225') ? 'selected' : ''; ?>>225,00%</option>
                                                </select>
                                            </div>
                                        </div><!--linha-tabela-->
                                        <div class="linha-tabela">
                                            <div><label>Multa Punitiva (R$) <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="vrmultap_<?php echo $key + 1; ?>" name="vrmultap_<?php echo $key + 1;?>" value="<?php echo $item['vr_multa_punitiva']; ?>" readonly/></div>
                                            <div><label>Valor do Crédito <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="vrcredito_<?php echo $key + 1;?>" name="vrcredito_<?php echo $key +1;?>" value="<?php echo $item['vr_atualizado']; $totalCredito = $totalCredito + $item['vr_atualizado'];?>" readonly/></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div><!--linha-tabela-->
                            </td>
                            <td class='row-table'><a><i class='fa-solid fa-trash-can lixo'></i></a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <div class="clear"></div>
                <div class="totalizar">
                    <div>
                        <a href="#" id="botao">+ Adicionar item</a>
                        <button id="calcular">Calcular</button>
                    </div>
                    <div class="tot_auto">
                        <div class="total-container">
                            <label for="total_valor" class="titulo">Total:</label>
                            <input type="text" id="valor_total" class="total" value="<?php echo $totalCredito ?>" readonly>
                        </div>
                    </div>
                   
                    
                </div>
                <div class="botao-salvar direita">
               
                    <button id="btnAtualizar" name="btnAtualizar" type="submit">Salvar</button>
                    <button id="lancarAuto" name="lancarAuto" type="submit">Lançar Auto</button>
                    <a href="#" id="botao">Imprimir</a>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</form>


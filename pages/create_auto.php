   <!--alterar layout colocando um botao no label somente do primeiro periodo a ser verificado do RBT12 a fim de cadastar as 12 receitas declaradas / apuradas a fim de calcular automaticamente o rbt12,
   quanto aos demais pediodos serão calculados automaticamente de acordo com a evolução da fiscalização-->
   
<?php
    if(isset($_POST['busca_pessoa'])){
        $cod_pessoa = $_POST['codigo'];
        $sql = MySql::conectar()->prepare("SELECT * FROM `simples_contribuinte` WHERE cod_contribuinte = ?");
        $sql->execute(array($cod_pessoa));
        if($sql->rowCount() > 0) {
            
            $contribuinte = $sql->fetch();
        } else {
            Painel::alert('erro', 'Contribuinte não localizado');
            $contribuinte = "";
            $cod_pessoa = "";
        }
    }

    if (isset($_POST['btnSalvar'])) {
        $numeroDeLinhas = 0;
        while (isset($_POST["pa_" . ($numeroDeLinhas + 1)])) {
            $numeroDeLinhas++;
        }
        
        

        $salvarComSucesso = true;
        $cod_verificacao_fiscal = null; // Adicione esta variável
        
        $dadosVerificacaoFiscal = [
        'cod_pessoa' => $_POST['codigo'],

        ];

        $cod_verificacao_fiscal = Painel::salvarDadosVerificacao($dadosVerificacaoFiscal);
        if ($cod_verificacao_fiscal) {
        for ($i = 0; $i < $numeroDeLinhas; $i++) {
            // Monta os dados para a linha atual
            $dadosTabelaPrincipal = [
                'cod_verificacao_fiscal' => $cod_verificacao_fiscal,
                'pa' => isset($_POST['pa_' . ($i + 1)]) ? converterPAParaDate($_POST['pa_' . ($i + 1)]) : '',
                'iLista' => $_POST['iLista_' . ($i + 1)],
                'anexo' => $_POST['anexo_' . ($i + 1)],
                'infracao' => $_POST['infracao_'. ($i + 1)],
                'rbt12d' => $_POST['rbt12d_' . ($i + 1)],
                //'rbt12d' => str_replace('.', '', str_replace(',', '.', $_POST['rbt12d_' . ($i + 1)])),
                'recd' => $_POST['recd_' . ($i + 1)],
                'alqd' => $_POST['alqd_' . ($i + 1)],
                'ISSPg' => $_POST['ISSPg_' . ($i + 1)],
                'rbt12a' => $_POST['rbt12a_' . ($i + 1)],
                'reca' => $_POST['reca_' . ($i + 1)],
                'aliquota' => $_POST['alquota_' . ($i + 1)],
                'vrapr' => $_POST['vrapr_' . ($i + 1)],
                'vrpincipal' => $_POST['vrprincipal_' . ($i + 1)],
                'vrselic' => $_POST['vrselic_'. ($i + 1)],
                'pselic' => $_POST['pselic_' .($i + 1 )],
                'MultaP' => $_POST['MultaP_' . ($i + 1)],
                'vrMultap' => $_POST['vrmultap_' . ($i + 1)],
                'vrAtualizado' => $_POST['vrcredito_' . ($i + 1)]
            ];
        
            // Verifica se todos os campos estão preenchidos
            foreach ($dadosTabelaPrincipal as $valor) {
                if (empty($valor)) {
                    $salvarComSucesso = false;
                    break; // Sai do loop se encontrar um campo vazio
                }
            }
           
            // Se todos os campos estiverem preenchidos, salva os dados
            if ($salvarComSucesso) {
                $cod_verificacao_fiscal = Painel::salvarDadosItensVerificacao($dadosTabelaPrincipal);
               
            } else {
                // Se algum campo estiver vazio, exibe uma mensagem de erro
                Painel::alert('erro', "Preencha todos os campos.");
                break; // Sai do loop se houver um erro
            }
        }}
       // $cod_verificacao_fiscal = $dadosTabelaPrincipal['cod_pessoa'];
        if ($cod_verificacao_fiscal) {
            $_SESSION['sucesso'] = "Dados Cadastrados com sucesso";
             header("Location: list_auto?cod_verificacao_fiscal=" . $cod_verificacao_fiscal);
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
    <form method="post" action="">
      
        <div class="list">
            <div class="box">
            
                <div class="container"> 
                <input type="button" class="verde" id="pesquisar_pessoa" value="Critérios de Pesquisa"><br>

                    <!-- Modal -->
                    <div id="modalPessoa" class="modal" style="display: none;">
                        <div class="modal-content">
                            <span class="close-modal">&times;</span>
                            <div id="modal-body-pessoa">
                            </div>
                        </div>
                    </div><!--modal-->
                    <div class="list-content w20">
                        <label for="cod_pessoa">Código</label>
                        <input type="text" name="codigo" id="codigo" value="<?php echo isset($contribuinte['cod_contribuinte']) ? $contribuinte['cod_contribuinte'] : ''; ?>">
                        <input type="submit" id="busca_pessoa" name="busca_pessoa" value="Buscar">
                    </div>
                    <div class="list-content direita w50">
                        <label for="cnpj">CNPJ</label>
                        <input class="readonly" type="text" name="cnpj" id="cnpj" value="<?php echo isset($contribuinte['CNPJ']) ? $contribuinte['CNPJ'] : ''; ?>" readonly>
                    </div>
                    <div class="clear"></div>
                    <div class="w100">
                        <label for="razao_social">Razão Social</label>
                        <input class="w100 readonly" type="text" name="razao_social" id="razao_social" value="<?php echo isset($contribuinte['razao_social']) ? $contribuinte['razao_social'] : ''; ?>" readonly />
                    </div>

                </div><!--container-->
                            
            </div><!--box-->       
        </div><!--list-->
        
        <div class="create">
            <div class="box">
                <div class="container">
                <div class="list-content-add w20">
                   <!-- <input type="submit" id="add_receitas" name="add_receitas" value="Adicionar Receitas"> -->
                </div>
                <div class="clear"></div>
 
                        <table class="titulo">
                                                    
                            <tbody class='tbody'>
                                 <tr class='tr_input' id='linha_1'>
                                    <td class="row-table">
                                        <div class="linha-tabela">
                                            <div><label>PA <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="pa_1" name="pa_1"  placeholder="XX/XXXX"/></div>
                                            <div><label>Item Lista <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="iLista_1" name="iLista_1"/></div>
                                            <div><label>Anexo <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div>
                                                <select id= "anexo_1" name="anexo_1">
                                                <option value="0">Selecione</option>
                                                <option value="III">III</option>
                                                <option value="IV">IV</option>
                                                <option value="V">V</option>
                                                </select>
                                            </div>
                                            <div><label>Infração * <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div>
                                                <select id= "infracao_1" name="infracao_1">
                                                <option value="0">Selecione</option>
                                                <option value="DBC">DBC</option>
                                                <option value="IA">IA</option>
                                                <option value="OMR">OMR</option>
                                                <option value="SIR">SIR</option>
                                                </select>
                                            </div>
                                        </div><!--linha-tabela-->
                                        
                                        <div class="linha-tabela">
                                            <div><label>RBT12 - D <i class="fa-regular fa-circle-question"></i><i id="add_rec_D" class="fa-solid fa-circle-plus direita add-rec"></i></label></div>
                                            <div><input type="text" id="rbt12d_1" name="rbt12d_1" placeholder="R$" onchange="formatarValorDecimal(this)"/></div>
                                            <div><label>Receita Declarada <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="recd_1" name="recd_1" placeholder="R$" onchange="formatarValorDecimal(this)"/></div>
                                            <div><label>Alíquota Declarada <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="alqd_1" name="alqd_1" readonly/></div>
                                            <div><label>ISS Pago <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="ISSPg_1" name="ISSPg_1" onchange="formatarValorDecimal(this)" /></div>
                                        </div><!--linha-tabela-->
                                        
                                        <div class="linha-tabela">
                                            <div><label>RBT12 - A <i class="fa-regular fa-circle-question"></i><i class="fa-solid fa-circle-plus direita add-rec"></i></label></div>
                                            <div><input type="text" id="rbt12a_1" name="rbt12a_1" placeholder="R$" onchange="formatarValorDecimal(this)"/></div>
                                            <div><label>Receita Apurada <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="reca_1" name="reca_1" placeholder="R$" onchange="formatarValorDecimal(this)"/></div>
                                            <div><label>Alíquota Efetiva <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="alquota_1" name="alquota_1" readonly/></div>
                                            <div><label>Valor Apurado <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="vrapr_1" name="vrapr_1" readonly/></div>
                                        </div><!--linha-tabela-->
                                        
                                        <div class="linha-tabela">
                                            <div><label>Valor Principal <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="vrpincipal_1" name="vrprincipal_1" readonly/></div>
                                            <div><label>SELIC (%) <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="pselic_1" name="pselic_1" readonly/></div>
                                            <div><label>SELIC (R$) <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="vrselic_1" name="vrselic_1" readonly/></div>
                                            <div><label>Multa Punitiva (%) <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div>
                                                <select id= "MultaP_1" name="MultaP_1">
                                                    <option value="0">Selecione</option>
                                                    <option value="75">75,00%</option>
                                                    <option value="100">100,00%</option>
                                                    <option value="112.5">112,50%</option>
                                                    <option value="150">150,00%</option>
                                                    <option value="225">225,00%</option>
                                                </select>
                                            </div>
                                        </div><!--linha-tabela-->
                                        
                                        <div class="linha-tabela">
                                            <div><label>Multa Punitiva (R$) <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="vrmultap_1" name="vrmultap_1" readonly/></div>
                                            <div><label>Valor do Crédito <i class="fa-regular fa-circle-question"></i></label></div>
                                            <div><input type="text" id="vrcredito_1" name="vrcredito_1" readonly/></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div><!--linha-tabela-->
                                        
                                    </td>
                                    <td class="row-table"></td>
                                  </tr>
                            </tbody>
                        </table>
                        
            
                <div class="clear"></div>   
                <div class="totalizar">
                    <div>
                        <a href="#" id="botao">+ Adicionar item</a>
                        <button id="calcular">Calcular</button>
                    </div>
                    <div class="tot_auto"><div class="total-container">
                        <label for="total_valor" class="titulo">Total:</label>
                        <input type="text" id="valor_total" class="total" readonly>
                        </div>  
                    
                    </div>
                    
                </div><!--totalizar-->
                <div class="botao-salvar direita">
                <button id="btnSalvar" name="btnSalvar" type="submit">Salvar</button>
                    <a href="#" id="botao">Imprimir</a>
                </div>
            </div><!--container-->
            <div class="clear"></div>
        </div><!--box-->
      </div><!--create-->    
    </form>   

function formatarValorDecimal(input) {
  if (input.value.trim() === '') {
    input.value = '0.00';
    return;
  }
  input.value = input.value.replace(/,/g, '.');
  if (input.value.indexOf('.') === -1) {
    input.value += '.00';
  } else {
    let partes = input.value.split('.');
      if (partes[1].length === 1) {
      input.value += '0';
    }
  }
}



//adaptar o codigo para essa função pois ela formata corretamente
/*function formatarValorDecimal(input) {
  // Obtém o valor do input
  var valor = parseFloat(input.value.replace('.', '').replace(',', '.'));
  
  // Verifica se o valor é um número
  if (!isNaN(valor)) {
      // Formata o valor para duas casas decimais
      var valorFormatado = valor.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      input.value = valorFormatado;
  } else {
      input.value = ''; // Ou você pode definir um valor padrão
  }
}*/


$(document).ready(function() {

  //ir para a tela de editar auto ao clicar no icome editar em auto.php
  $(document).on('click', '.editar-auto', function() {
    // Obtém o código de verificação fiscal
    var codVerificacaoFiscal = $(this).data('cod');
    // Obtém o código da situação
    var codSituacao = $(this).data('situacao');
    
    // Verifica o valor de cod_situacao e redireciona para a página correspondente
    if (codVerificacaoFiscal) {
        if (codSituacao == 1) {
            // Redireciona para list_auto
            window.location.href = 'list_auto?cod_verificacao_fiscal=' + codVerificacaoFiscal;
        } else {
            // Redireciona para auto-infracao
            window.location.href = 'auto_infracao?cod_verificacao_fiscal=' + codVerificacaoFiscal;
        }
    }
});

  //excluir auto na tela auto.php
  $(document).on('click', '.excluir-auto', function() {
    var codVerificacaoFiscal = $(this).data('cod');
    
    // Confirmação antes de excluir
    if (confirm('Tem certeza que deseja excluir este registro?')) {
        // Faz a requisição AJAX para excluir o registro
        $.ajax({
            url: '/SIMPLEFISC/php/excluir_auto.php', // arquivo responsável por realizar a exclusão
            type: 'POST',
            data: { cod_verificacao_fiscal: codVerificacaoFiscal },
            success: function(response) {
                if (response == 'success') {
                    alert('Registro excluído com sucesso!');
                    // Remove a linha da tabela após a exclusão
                    $('a[data-cod="' + codVerificacaoFiscal + '"]').closest('tr').remove();
                } else {
                    alert('Erro ao excluir o registro.');
                }
            },
            error: function() {
                alert('Erro ao realizar a exclusão.');
            }
        });
    }
  });

  //requisição para buscar os contribuintes na tela de pesquisa
  $(document).on('click', '#buscar-pessoas', function(event) {
    event.preventDefault();

    const codigo = $('#codigo-busca').val();
    const nome = $('#nome-busca').val();
    const cnpj = $('#cnpj-busca').val();
    
    $.ajax({
      url: '/SIMPLEFISC/php/tela_pesquisa.php',
      method: 'POST',
      data: {
        codigo: codigo,
        nome: nome,
        cnpj: cnpj
      },
      success: function (response){
        $('#resultadoTabela').html(response);
      },
      error: function(xlr, status, error){
        console.error('Erro na busca: ', error);
      }
    })
  });

 
  //fechar mensagem de notificação
  $('.close').click(function() {
    $(this).parent('.box-alert').fadeOut(); 
  });

  
  //calcular o Desconto no lanc-auto
  var totalCreditoOriginal = parseFloat($('#totalAuto').val());
  
  $('#calculoAuto').click(function(event){
  event.preventDefault();
  var totalCredito = totalCreditoOriginal;
  console.log(totalCredito);
  var desconto = parseFloat($('#descontoMultaP').val());
  console.log(desconto);
  var desconto = (desconto/100) * totalCredito;
  var creditoAtualizado = totalCredito - desconto;
  console.log(creditoAtualizado);
  $('#valor_total').val(creditoAtualizado.toFixed(2));
 });

  // Adicionar nova linha ao clicar no botão "+ Adicionar item"
  $('#calcular').click(function(event) {
    event.preventDefault();

    var linhas_processadas = 0;
    $(".tr_input").each(function (){
      var linha_id = $(this).attr('id');
      var linha_numero = linha_id.substring(6);
      processarLinha(linha_numero, function(){
        linhas_processadas++;
        
      });
    });
  });

  $("#botao").click(function(event){
    event.preventDefault();
    adicionarLinha();
  });

    // Função para excluir uma linha ao clicar no ícone de lixeira
  $('tbody').on('click', '.lixo', function() {
    $(this).closest('tr').remove();
  });
});

//linhas e serem adicionadas (adicionar periodos de apuração)
function adicionarLinha(){
  var index = $(".tr_input").length + 1;
  var novaLinha = "<tr class='tr_input' id='linha_" + index +"'>\n\
    <td class='row-table'>\n\
      <div class='linha-tabela'>\n\
        <input type='hidden' id='codVerificacao_" + index + "' name='codVerificacao_" + index +"'>\n\
        <div><label>PA <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='pa_" + index + "'name='pa_" + index + "'  placeholder='XX/XXXX'/></div>\n\
        <div><label>Item Lista <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='iLista_" + index + "' name='iLista_" + index + "'/></div>\n\
        <div><label>Anexo <i class='fa-regular fa-circle-question'></i></label></div>\n\
      <div>\n\
        <select id='anexo_" + index + "' name='anexo_" + index + "'>\n\
          <option value='0'>Selecione</option>\n\
          <option value='III'>III</option>\n\
          <option value='IV'>IV</option>\n\
          <option value='V'>V</option>\n\
        </select>\n\
      </div>\n\
      <div><label>Infração * <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div>\n\
          <select id= 'infracao_" + index + "' name='infracao_" + index + "'>\n\
            <option value='0'>Selecione</option>\n\
            <option value='DBC'>DBC</option>\n\
            <option value='IA'>IA</option>\n\
            <option value='OMR'>OMR</option>\n\
            <option value='SIR'>SIR</option>\n\
          </select>\n\
        </div>\n\
      </div><!--linha-tabela-->\n\
      <div class='linha-tabela'>\n\
        <div><label>RBT12 - D <i class='fa-regular fa-circle-question'></i><i id='add_rec_D' class='fa-solid fa-circle-plus direita add-rec'></i></label></div>\n\
        <div><input type='text' id='rbt12d_" + index + "' name='rbt12d_" + index + "' placeholder='R$' onchange='formatarValorDecimal(this)'/></div>\n\
        <div><label>Receita Declarada <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='recd_" + index + "' name='recd_" + index + "' placeholder='R$' onchange='formatarValorDecimal(this)'/></div>\n\
        <div><label>Alíquota Declarada <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='alqd_" + index + "' name='alqd_" + index + "' readonly/></div>\n\
        <div><label>ISS Pago <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='ISSPg_" + index + "' name='ISSPg_" + index + "' onchange='formatarValorDecimal(this)'/></div>\n\
      </div><!--linha-tabela-->\n\
      <div class='linha-tabela'>\n\
        <div><label>RBT12 - A <i class='fa-regular fa-circle-question'></i><i id='add_rec_D' class='fa-solid fa-circle-plus direita add-rec'></i></label></div>\n\
        <div><input type='text' id='rbt12a_" + index + "' name='rbt12a_" + index + "' placeholder='R$' onchange='formatarValorDecimal(this)'/></div>\n\
        <div><label>Receita Apurada <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='reca_" + index + "' name='reca_" + index + "' placeholder='R$' onchange='formatarValorDecimal(this)'/></div>\n\
        <div><label>Alíquota Efetiva <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='alquota_" + index + "' name='alquota_" + index + "' readonly/></div>\n\
        <div><label>Valor Apurado <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='vrapr_" + index + "' name='vrapr_" + index + "' readonly/></div>\n\
      </div><!--linha-tabela-->\n\
      <div class='linha-tabela'>\n\
        <div><label>Valor Principal <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='vrpincipal_" + index + "' name='vrprincipal_" + index + "' readonly/></div>\n\
        <div><label>SELIC (%) <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='pselic_" + index + "' name='pselic_" + index + "' readonly/></div>\n\
        <div><label>SELIC (R$) <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='vrselic_" + index + "' name='vrselic_" + index + "' readonly/></div>\n\
        <div><label>Multa Punitiva (%) <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div>\n\
          <select id= 'MultaP_" + index + "' name='MultaP_" + index + "'>\n\
            <option value='0'>Selecione</option>\n\
            <option value='75'>75,00%</option>\n\
            <option value='100'>100,00%</option>\n\
            <option value='112.5'>112,50%</option>\n\
            <option value='150'>150,00%</option>\n\
            <option value='225'>225,00%</option>\n\
          </select>\n\
        </div>\n\
      </div><!--linha-tabela-->\n\
        <div class='linha-tabela'>\n\
        <div><label>Multa Punitiva (R$) <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='vrmultap_" + index + "' name='vrmultap_" + index + "' readonly/></div>\n\
        <div><label>Valor do Crédito <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='vrcredito_" + index + "' name='vrcredito_" + index + "' readonly/></div>\n\
        <div></div>\n\
        <div></div>\n\
        <div></div>\n\
        <div></div>\n\
      </div><!--linha-tabela-->\n\
    </td>\n\
    <td class='row-table'><a><i class='fa-solid fa-trash-can lixo'></i></a></td>\n\
  </tr>";
  $("table").append(novaLinha);
};

//função para efetuar os calculos de cada periodo, buscando dados das tabelas auxiliares do banco
function processarLinha(numeroLinha, callback){
  var RBT12declarado = parseFloat($("#rbt12d_" + numeroLinha).val()) || 0;
  var RBT12Apurado = parseFloat($("#rbt12a_" + numeroLinha).val()) || 0;
  var anexo = $("#anexo_" + numeroLinha).val();
  var periodo = $("#pa_" + numeroLinha).val();
  var mesAno = periodo.split('/');
  var data = mesAno[1] + '/' + mesAno[0];
  var baseCalculo = parseFloat($("#recd_" + numeroLinha).val()) || 0;
  var baseCalculoApurada = parseFloat($("#reca_" + numeroLinha).val()) || 0;
  var multa_punitiva = parseFloat($("#MultaP_" + numeroLinha).val()) || 0;

  if (mesAno.length === 2 && isValidDate(data)){
    $.ajax({
      url: '/SIMPLEFISC/php/buscar_dados.php',
      type: 'GET',
      data: {RBT12declarado: RBT12declarado, RBT12Apurado: RBT12Apurado, anexo: anexo, data: data},
      success: function (response){
        var resultados = response.split('|');
        var aliquota_declarada = parseFloat(resultados[0]) || 0;
        var soma_selic = parseFloat(resultados[1]) || 0;
        var aliquota_definitiva = parseFloat(resultados[2]) || 0;

        $("#alqd_" + numeroLinha).val(aliquota_declarada.toFixed(2));
        $("#pselic_" + numeroLinha).val(soma_selic.toFixed(2));

        var valor_recolhido = (baseCalculo * (aliquota_declarada / 100)).toFixed(2); 
        $("#ISSPg_" + numeroLinha).val(parseFloat(valor_recolhido).toFixed(2));
        $("#alquota_" + numeroLinha).val(aliquota_definitiva.toFixed(2));

        var iss_apurado = parseFloat((baseCalculoApurada * (aliquota_definitiva / 100))).toFixed(2);
        $("#vrapr_" + numeroLinha).val(parseFloat(iss_apurado).toFixed(2));

        var valor_credito = (parseFloat(iss_apurado) - parseFloat(valor_recolhido)).toFixed(2);
        $("#vrpincipal_" + numeroLinha).val(parseFloat(valor_credito).toFixed(2));

        var valor_selic = ((parseFloat(valor_credito) * soma_selic) / 100).toFixed(2);
        $("#vrselic_" + numeroLinha).val(parseFloat(valor_selic).toFixed(2));

        var valor_atualizado = parseFloat(valor_credito) + parseFloat(valor_selic);
        var valor_multa_punitiva = (valor_atualizado * (parseFloat(multa_punitiva) / 100)).toFixed(2);
        $("#vrmultap_" + numeroLinha).val(parseFloat(valor_multa_punitiva).toFixed(2));

        var valor_cretido_periodo = valor_atualizado + parseFloat(valor_multa_punitiva);
        $("#vrcredito_" + numeroLinha).val(parseFloat(valor_cretido_periodo).toFixed(2));

        calcularTotalCredito();

        callback();
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        callback();
      }
    });
  } else {
    alert('Período no formato inválido, insira o período no formato MM/AAAA.');
    callback();
  }
}

//verifica de o PA esta no formato MM/AAAA
function isValidDate(dateString){
  var regex = /^\d{4}\/\d{2}$/;
  return dateString.match(regex) !== null;
}

  //Função para exibir o alerta referente ao valor da multa
  function exibirAlertaMulta() {
    const multaP = $(this).val(); 
    if ((multaP == "112.5") || (multaP == "150") || (multaP == "225")) {
      const mensagemTexto = 'Apesar de a Resolução CGSN nº 140/2018 prever as multas de 75%, 112,5%, 150% e 225%, o correto é aplicar sempre a multa de 75% sobre o valor de ISS, visto que o STF pacificou que a multa máxima punitiva no campo tributário não pode superar os 100% do tributo devido (AG.REG. NO RECURSO EXTRAORDINÁRIO 833.106/GO).';
      const confirmacao = window.confirm(mensagemTexto + '\n\nDeseja alterar a multa escolhida?\nClique em "Ok" para alterar a multa para 75% ou em "Cancelar" para manter a multa atual.');
      if (confirmacao) {
       
        $(this).val('100'); 
        multaP=100;
      };
    };
    return multaP;
  };

  $('tbody').on('change', 'select[name^="MultaP_"]', exibirAlertaMulta);

 //calcula o totas da verificação
  function calcularTotalCredito() {
    var total = 0;
    
    // Percorre todas as linhas que têm o campo de valor do crédito
    $(".tr_input").each(function() {
      var valorCredito = parseFloat($(this).find('input[name^="vrcredito_"]').val()) || 0;
      total += valorCredito;
    });
  
    // Atualiza o campo de totalização
    $("#valor_total").val(total.toFixed(2));
  }
  



//script para abrir o modal de buscar pessoa
document.getElementById("pesquisar_pessoa").addEventListener("click", function() {
  var modal = document.getElementById("modalPessoa");
 

  // Exibir o modal
  modal.style.display = "block";

  // Carregar o conteúdo da busca_pessoa.php usando AJAX
  $.ajax({
    url: '/SIMPLEFISC/php/buscar_pessoas.php',
    method: 'GET',
    success: function(response) {
        $('#modal-body-pessoa').html(response);
    },
    error: function(xhr, status, error) {
        console.error('Erro na requisição:', error);
    }
});
});

// Fechar o modal quando clicar no 'X'
document.getElementsByClassName("close-modal")[0].addEventListener("click", function() {
  document.getElementById("modalPessoa").style.display = "none";
});

// Fechar o modal se clicar fora da área de conteúdo
window.onclick = function(event) {
  var modal = document.getElementById("modalPessoa");
  if (event.target == modal) {
      modal.style.display = "none";
  }
};


//fim do modal

//ao clicar na linha da tabela retorna os valores para a verificação
$(document).on('click', '.clickable-row', function() {

  
  const codigo = $(this).data('codigo');
  const nome = $(this).data('nome');
  const cnpj = $(this).data('cnpj');

  // Preenchendo os campos do formulário com os valores capturados
  $('#codigo').val(codigo);
  $('#razao_social').val(nome);
  $('#cnpj').val(cnpj);

  //document.getElementById("#codigo").val(codigo);
  document.getElementById("modalPessoa").style.display = "none";


});

//calcular data vencimento 30dias após o aceita
function atualizarVencimento() {
  const aceiteInput = document.getElementById('aceite');
  const vencimentoInput = document.getElementById('vencimento');

  const aceiteDate = new Date(aceiteInput.value);
  
  if (!isNaN(aceiteDate.getTime())) {
      aceiteDate.setDate(aceiteDate.getDate() + 30);
      const dataAtual = new Date();
      const ultimoDiaDoMes = new Date(dataAtual.getFullYear(), dataAtual.getMonth() + 1, 0);
      if (aceiteDate > ultimoDiaDoMes) {
          vencimentoInput.value = ultimoDiaDoMes.toISOString().split('T')[0]; // Define como o último dia do mês atual
      } else {
          vencimentoInput.value = aceiteDate.toISOString().split('T')[0]; // Caso contrário, usa a data calculada
      }
  } else {
      vencimentoInput.value = '';
  }
}
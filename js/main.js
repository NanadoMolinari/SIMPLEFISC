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


//fazer retornar os dados do banco ex:

//campos da tabela:id_aliquota, anexo, lim_minimo, lim_maximo,  aliquota, aliquota_iss, vr_deduzir 

//SELECT aliquota, aliquota_iss, vr_deduzir 
//FROM tb_aliquotas 
//WHERE anexo = $anexo AND lim_minimo < $rbt12 AND lim_maximo >= $rbt12


// Função para obter a alíquota com base no anexo e valor do rbt12
function pegaAliquota(anexo, rbt12) {
 
}

$(document).ready(function() {
  // Adicionar nova linha ao clicar no botão "+ Adicionar item"
  $('#calcular').click(function(event) {
    event.preventDefault();

    var total_linhas = $(".tr_input").length;
    var linhas_processadas = 0;
    $(".tr_input").each(function (){
      var linha_id = $(this).attr('id');
      var linha_numero = linha_id.substring(6);
      processarLinha(linha_numero, function(){
        linhas_processadas++;
        if (linhas_processadas === total_linhas){
          //calcularTotal();
        }
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

function adicionarLinha(){
  var index = $(".tr_input").length + 1;
  var novaLinha = "<tr class='tr_input' id='linha_" + index +"'>\n\
    <td class='row-table'>\n\
      <div class='linha-tabela'>\n\
        <div><label>PA <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='pa_" + index + "'name='pa_" + index + "'  placeholder='XX/XXXX'/></div>\n\
        <div><label>Item Lista <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='iLista_" + index + "' name='iLista_" + index + "'/></div>\n\
        <div><label>Anexo <i class='fa-regular fa-circle-question'></i></label></div>\n\
      <div>\n\
        <select id= 'anexo_" + index + "' name='anexo" + index + "'>\n\
          <option value='0'>Selecione</option>\n\
          <option value='III'>III</option>\n\
          <option value='IV'>IV</option>\n\
          <option value='V'>V</option>\n\
        </select>\n\
      </div>\n\
      <div><label>Infração * <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div>\n\
          <select id= 'infracao_" + index + "' name='ainfracao_" + index + "'>\n\
            <option value='0'>Selecione</option>\n\
            <option value='1'>DBC</option>\n\
            <option value='2'>IA</option>\n\
            <option value='3'>OMR</option>\n\
            <option value='3'>SIR</option>\n\
          </select>\n\
        </div>\n\
      </div><!--linha-tabela-->\n\
      <div class='linha-tabela'>\n\
        <div><label>RBT12 - D <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='rbt12d_" + index + "' name='rbt12d_" + index + "' placeholder='R$' onchange='formatarValorDecimal(this)'/></div>\n\
        <div><label>Receita Declarada <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='recd_" + index + "' name='recd_" + index + "' placeholder='R$' onchange='formatarValorDecimal(this)'/></div>\n\
        <div><label>Alíquota Declarada <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='alqd_" + index + "' name='alqd_" + index + "' readonly/></div>\n\
        <div><label>ISS Pago <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='ISSPg_" + index + "' name='ISSPg_" + index + "' onchange='formatarValorDecimal(this)'/></div>\n\
      </div><!--linha-tabela-->\n\
      <div class='linha-tabela'>\n\
        <div><label>RBT12 - A <i class='fa-regular fa-circle-question'></i></label></div>\n\
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
            <option value='112.5'>112,50%</option>\n\
            <option value='150'>150,00%</option>\n\
            <option value='225'>225,00%</option>\n\
          </select>\n\
        </div>\n\
      </div><!--linha-tabela-->\n\
        <div class='linha-tabela'>\n\
        <div><label>Multa Punitiva (R$) <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='vrmultap_ " + index + "' name='vrmultap_" + index + "' readonly/></div>\n\
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

function processarLinha(numeroLinha, callback){
  var RBT12declarado = $("#rbt12d_" + numeroLinha).val();
  var anexo = $("#anexo_" + numeroLinha).val();
  var periodo = $("#pa_" + numeroLinha).val();
  var mesAno = periodo.split('/');
  var data = mesAno[1] + '/' + mesAno[0];
  if (mesAno.length === 2 && isValidDate(data)){
    $.ajax({
      url: '/SIMPLEFISC/php/buscar_dados.php',
      type: 'GET',
      data: {data: data},
      success: function (response){
        var somaSelic = parseFloat(response);
        if (!isNaN(somaSelic)) {
          $("#pselic_" + numeroLinha).val(somaSelic);
        } else {
          console.error('Resposta inválida: ', response);
          alert('Erro ao buscar dados: Resposta inválida');
        }
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

 
function calcularValorSelicPA(pa) {
 
};
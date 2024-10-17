function formatarValorDecimal(input) {
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
  var aliquota = 0;
  var valorDeduzir = 0;
  var aliquotaEfetiva = 0;
  var aliquotaISS = 0;
  if (anexo === 'III') {
    if (rbt12 <= 180000) {//primeira faixa Anexo III
      aliquota = 0.06;
      aliquotaISS = 0.335;
    } else {
      if (rbt12 > 180000 && rbt12 <= 360000){//segunda faixa anexo III
        valorDeduzir = 9360.00;
        aliquotaISS = 0.32;
        aliquota= 0.112;
      }else{
        if (rbt12 > 360000 && rbt12 <= 720000){//terceita faixa anexo III
          valorDeduzir = 17640.00;
          aliquotaISS = 0.325;
          aliquota = 0.135;
        }else{
          if (rbt12 > 720000 && rbt12 <= 1800000){//quarta faixa anexo III
            valorDeduzir = 35640.00;
            aliquotaISS = 0.325;
            aliquota = 0.16;
          }else{
            if (rbt12 > 1800000 && rbt12 <= 3600000){//quinta faixa anexo III
             valorDeduzir = 125640.00;
              aliquotaISS = 0.335;
             aliquota = 0.21;
            }else{
              valorDeduzir = 648000.00;
             aliquotaISS = 0.335;
             aliquota = 0.33;
           }
         }
        }
      }
    }
  } else if (anexo === 'IV') {
    if (rbt12 <= 180000) {//primeira faixa Anexo IV
      aliquota = 0.045;
      aliquotaISS = 0.445;
      } else {
        if (rbt12 > 180000 && rbt12 <= 360000){//segunda faixa anexo IV
          valorDeduzir = 8100.00;
          aliquotaISS = 0.4;
          aliquota= 0.09;
        }else{
          if (rbt12 > 360000 && rbt12 <= 720000){//terceita faixa anexo IV
            valorDeduzir = 12420;
            aliquotaISS = 0.4;
            aliquota = 0.102;
          }else{
            if (rbt12 > 720000 && rbt12 <= 1800000){//quarta faixa anexo IV
              valorDeduzir = 39780.00;
              aliquotaISS = 0.4;
              aliquota = 0.14;
            }else{
              if (rbt12 > 1800000 && rbt12 <= 3600000){//quinta faixa anexo IV
                valorDeduzir = 183780.00;
                aliquotaISS = 0.4;
                aliquota = 0.22;
              }else{
                valorDeduzir = 828000.00;
                aliquotaISS = 0.4;
                aliquota = 0.33;
              }
            }
          }
        }
      }
    } else if (anexo === 'V') {
      if (rbt12 <= 180000) {//primeira faixa Anexo IV
        aliquota = 0.045;
        aliquotaISS = 0.445;
      } else {
        if (rbt12 > 180000 && rbt12 <= 360000){//segunda faixa anexo IV
          valorDeduzir = 8100.00;
          aliquotaISS = 0.4;
          aliquota= 0.09;
        }else{
          if (rbt12 > 360000 && rbt12 <= 720000){//terceita faixa anexo IV
            valorDeduzir = 12420;
            aliquotaISS = 0.4;
            aliquota = 0.102;
          }else{
            if (rbt12 > 720000 && rbt12 <= 1800000){//quarta faixa anexo IV
              valorDeduzir = 39780.00;
              aliquotaISS = 0.4;
              aliquota = 0.14;
            }else{
              if (rbt12 > 1800000 && rbt12 <= 3600000){//quinta faixa anexo IV
                valorDeduzir = 183780.00;
                aliquotaISS = 0.4;
                aliquota = 0.22;
              }else{
                valorDeduzir = 828000.00;
               aliquotaISS = 0.4;
                aliquota = 0.33;
              }
            }
          }
        } 
      }
    }
  aliquota = ((((rbt12 * aliquota)-valorDeduzir)/rbt12) * 100);//.toFixed(2);
  aliquotaEfetiva = ((aliquota) * aliquotaISS);//.toFixed(2);
  if(aliquotaEfetiva >5){
   aliquotaEfetiva=5;
  }else{
    if(aliquotaEfetiva < 2){
      aliquotaEfetiva=2 ;
    }
  }
  return {
    aliquota: aliquota,
    valorDeduzir: valorDeduzir,
    aliquotaEfetiva: aliquotaEfetiva
  }
}

$(document).ready(function() {
  // Adicionar nova linha ao clicar no botão "+ Adicionar item"
  $('#botao').click(function(event) {
    event.preventDefault();

    // Pega último ID
    var lastname_id = $('.tr_input input[type=text]:nth-child(1)').last().attr('id');
      var split_id = lastname_id.split('_');

    
    var index = Number(split_id[1]) + 1;

    // Criar novas linhas Inputs

    var html = "<tr class='tr_input'>\n\
    <td class='row-table'>\n\
    <div class='linha-tabela'>\n\
        <div><label>PA <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='pa_" + index + "'name='pa_" + index + "'  placeholder='XX/XXXX'/></div>\n\
        <div><label>Item Lista <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div><input type='text' id='iLista_" + index + "' name='iLista" + index + "'/></div>\n\
        <div><label>Anexo <i class='fa-regular fa-circle-question'></i></label></div>\n\
        <div>\n\
            <select id= 'anexo" + index + "' name='anexo" + index + "'>\n\
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


   
    // Append data
    $('tbody').append(html);
  });

  

  $('#calcular').click(function(event) {
    event.preventDefault();
    var valor_total = 0;
  
    $('tr.tr_input').each(function() {



      var Rbt12D = parseFloat($(this).find('input[name^="rbt12d_"]').val());
      var Recd = parseFloat($(this).find('input[name^="recd_"]').val());
      var Anexo = $(this).find('select[name^="anexo_"]').val();
      var Rbt12A = parseFloat($(this).find('input[name^="rbt12a_"]').val());
      var BaseCalculo = parseFloat($(this).find('input[name^="reca_"]').val());
      //var ISSPg = parseFloat($(this).find('input[name^="ISSPg_"]').val());
      var PmultaP = $(this).find('select[name^="MultaP_"]').val();
    
      var resultadoAliquotaD = pegaAliquota(Anexo, Rbt12D);
      var aliquotaEfetiva = resultadoAliquotaD.aliquotaEfetiva;
     
  
      $(this).find('input[name^="alqd_"]').val(aliquotaEfetiva.toFixed(2));
      
  
      if (!isNaN(Rbt12D) && !isNaN(Recd)) {
        var vrISSD = Math.round(Recd * (aliquotaEfetiva / 100) * 100) / 100;
        
       
       var ISSPgInputD = $(this).find('input[name^="ISSPg_"]');
       var ISSPgValue = parseFloat(ISSPgInputD.val());
       if (!isNaN(ISSPgValue)) {
           vrISSD = ISSPgValue;
       } else {
          vrISSD = Math.round(Recd * (aliquotaEfetiva / 100) * 100) / 100;
           ISSPgInputD.val(vrISSD.toFixed(2));
       }
     
       
       var resultadoAliquotaApurada = pegaAliquota(Anexo, Rbt12A);
       var aliquotaEfetivaApurada = resultadoAliquotaApurada.aliquotaEfetiva;
       $(this).find('input[name^="alquota_"]').val(aliquotaEfetivaApurada.toFixed(2));
      
       var ISSBaseCalculo = BaseCalculo * (aliquotaEfetivaApurada / 100);
       $(this).find('input[name^="vrapr_"]').val(ISSBaseCalculo.toFixed(2));

         var difer = ISSBaseCalculo - vrISSD;

         if (Math.abs(difer) <= 0.05) {
          difer = 0;
        }

         $(this).find('input[name^="vrprincipal"]').val(difer.toFixed(2));

  
        var pa = $(this).find('input[name^="pa_"]').val(); 
        var selicPA = calcularValorSelicPA(pa); 
  
        $(this).find('input[name^="pselic_"]').val(selicPA.toFixed(2));
     

        var valorSelic = Math.trunc((difer * (selicPA / 100)) * 100) / 100;
        
        $(this).find('input[name^="vrselic_"]').val(valorSelic.toFixed(2));

       
     
        var vrMultaP = Math.trunc((difer * (PmultaP / 100)) * 100) / 100;
       $(this).find('input[name^="vrmultap_"]').val(vrMultaP.toFixed(2));

       vrCredito = difer + valorSelic + vrMultaP;



$(this).find('input[name^="vrcredito_"]').val(vrCredito.toFixed(2));

        //Calcula o Total
        valor_total += vrCredito;
      } else {
        alert('Favor inserir todos os campos');
      }
    });
    
    $('#valor_total').val(valor_total.toFixed(2));
  });
  // Função para excluir uma linha ao clicar no ícone de lixeira
  $('tbody').on('click', '.lixo', function() {
  $(this).closest('tr').remove();
  });
  

  
  //Função para exibir o alerta referente ao valor da multa
  function exibirAlertaMulta() {
    const multaP = $(this).val(); 
    if ((multaP == "112.5") || (multaP == "150") || (multaP == "225")) {
      const mensagemTexto = 'Apesar de a Resolução CGSN nº 140/2018 prever as multas de 75%, 112,5%, 150% e 225%, o correto é aplicar sempre a multa de 75% sobre o valor de ISS, visto que o STF pacificou que a multa máxima punitiva no campo tributário não pode superar os 100% do tributo devido (AG.REG. NO RECURSO EXTRAORDINÁRIO 833.106/GO).';
      const confirmacao = window.confirm(mensagemTexto + '\n\nDeseja alterar a multa escolhida?\nClique em "Ok" para alterar a multa para 75% ou em "Cancelar" para manter a multa atual.');
      if (confirmacao) {
       
        $(this).val('100'); 
        multaP=100;
      }
    }
    return multaP;
  }
  $('tbody').on('change', 'select[name^="MultaP_"]', exibirAlertaMulta);

 
  
});


//fazer com que essa função seja o retorno da busca no banco ex: 
//SELECT SUM(vr_selic) AS soma_vr_selic 
//FROM `tb_selic` 
//WHERE DATE_FORMAT(dt_selic, '%m/%Y') >= 'pa informado' AND DATE_FORMAT(dt_selic, '%m/%Y') <= 'DATE_FORMAT(CURDATE(), '%m/%Y');



function calcularValorSelicPA(pa) {
  // Verifica se o PA informado está no formato correto xx/xxxx
  const paRegex = /^\d{2}\/\d{4}$/;
  if (!paRegex.test(pa)) {
    console.log('Formato de PA inválido. Utilize o formato mm/aaaa.');
    return;
  }

  
  const dataAtual = new Date();

  
  const mesAtual = dataAtual.getMonth() + 1; 
  const anoAtual = dataAtual.getFullYear();

 
  const [mesPA, anoPA] = pa.split('/');

 
  const mesInicio = parseInt(mesPA, 10);
  const anoInicio = parseInt(anoPA, 10);

  
  if (isNaN(mesInicio) || isNaN(anoInicio)) {
    console.log('PA inválido. Certifique-se de utilizar apenas números para o mês e o ano.');
    return;
  }

  
  if (anoInicio > anoAtual || (anoInicio === anoAtual && mesInicio >= mesAtual)) {
    console.log('PA informado deve ser anterior ao mês/ano atual.');
    return;
  }

  // Valores da Selic mensal por mês/ano e seus respectivos anos depois será buscado diretamente no banco
  const selicMensal = [
    [0.58, 0.47, 0.53, 0.52, 0.52, 0.52, 0.54, 0.57, 0.47, 0.54, 0.49, 0.49], // 2018
    [0.54, 0.49, 0.47, 0.52, 0.54, 0.47, 0.57, 0.50, 0.46, 0.48, 0.38, 0.37], // 2019
    [0.38, 0.29, 0.34, 0.28, 0.24, 0.21, 0.19, 0.16, 0.16, 0.16, 0.15, 0.16], // 2020
    [0.15, 0.13, 0.20, 0.21, 0.27, 0.31, 0.36, 0.43, 0.44, 0.49, 0.59, 0.77], // 2021
    [0.73, 0.76, 0.93, 0.83, 1.03, 1.02, 1.03, 1.17, 1.07, 1.02, 1.02, 1.12], // 2022
    [1.12, 0.92, 1.17, 0.92, 1.12, 1.07, 1.07, 1.14, 0.97, 1.00, 0.92, 0.89], // 2023
    [0.97, 0.80, 0.83, 0.89] // 2024
  ];

  
  let somaSelic = 0;
  let mes = mesInicio +1;
  let ano = anoInicio;

  while (ano < anoAtual || (ano === anoAtual && mes < mesAtual)) {
  
    if (mes <= 12 && mes >= 1 && ano >= 2018 && ano <= 2024) {
      const valorSelicMensal = selicMensal[ano - 2018][mes - 1]; 
      somaSelic += valorSelicMensal;
    }

    
    mes++;
    if (mes > 12) {
      mes = 1;
      ano++;
    }
  }

  // Adiciona 1 ao resultado final referenta ao mês anterior
  somaSelic += 1;

  return Math.trunc(somaSelic * 100 ) / 100;
}
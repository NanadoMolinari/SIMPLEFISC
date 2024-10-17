<?php
    class Painel{
      public static function logado(){
        return isset($_SESSION['login']) ? true : false;
      }

      public static function logout(){
        session_destroy();
          header('location: '.INCLUDE_PATH);
      }

      public static function listarUsuarios(){
        $sql = MySql::conectar()->prepare("SELECT us.cod_usuario, us.nome, dc.desc_cargo FROM `admin_usuarios` us INNER JOIN `admin_desc_cargo` dc ON us.cod_cargo = dc.cod_cargo");
        $sql->execute();
        return $sql->fetchAll();
      }
      
      public static function alert($tipo, $mensagem){
        if($tipo == 'sucesso'){
          echo '<div class="box-alert sucesso"><i class="fa fa-check"></i> '.$mensagem.'<i class="fa fa-times direita close"></i></div>';
        }else if($tipo == 'erro'){
          echo '<div class="box-alert erro"><i class="fa fa-times"></i> '.$mensagem.'<i class="fa fa-times direita close"></i></div>';
        }
      }

      public static function atualizarUsuario($login, $nome, $email, $nivel, $senha, $cod_usuario){
        $sql = MySql::conectar()->prepare("UPDATE `admin_usuarios` set login_usuario = ?, nome = ?, email = ?, cod_cargo = ?, senha = ? WHERE cod_usuario = ?");
        if($sql->execute(array($login, $nome, $email, $nivel, $senha, $cod_usuario))){
          return true;
        }else{
          return false;
        }
      }



      public static function lavrarAutoInfracao($dados){
        $dataAtual = date('Y-m-d'); 
        $sql = MySql::conectar()->prepare(
            "INSERT INTO simples_auto_infracao (
              data_lavratura, data_aceite, data_vencimento, desc_relato, desc_infrigencia_legal, cod_verificacao_fiscal, vr_total_auto, perc_reducao, vr_total_com_reducao)
            VALUES
              (?, ?, ?, ?, ?, ?, ?, ?, ?)"              
        );
        $sql->execute(array(
          $dataAtual, $dataAtual, $dados['vencimento'], $dados['relato'], $dados['infrigencia'], $dados['codVerificacao'], $dados['totalAuto'], $dados['reducaoAuto'], $dados['valorAutoDesconto']
        ));

        $sql1 = MySql::conectar()->prepare(
            "UPDATE simples_verificacao_fiscal SET flg_situacao_verificacao = 2
              WHERE cod_verificacao_fiscal  = ?"          
        );
        $sql1->execute(array($dados['codVerificacao']));


      }

      public static function finalizarAutoInfracao($dados){
        
        $sql = MySql::conectar()->prepare(
            "UPDATE 
              simples_auto_infracao  
            SET
              data_aceite = ?,
              data_vencimento = ?,
              desc_relato = ?,
              desc_infrigencia_legal = ?,
              vr_total_auto = ?,
              perc_reducao = ?,
              vr_total_com_reducao = ?
            WHERE
              cod_verificacao_fiscal = ?"              
        );
        $sql->execute(array(
          $dados['aceite'], $dados['vencimento'], $dados['relato'], $dados['infrigencia'], $dados['totalAuto'], $dados['reducaoAuto'], $dados['valorAutoDesconto'], $dados['codVerificacao']
        ));

        $sql1 = MySql::conectar()->prepare(
            "UPDATE simples_verificacao_fiscal SET flg_situacao_verificacao = 3
              WHERE cod_verificacao_fiscal  = ?"          
        );
        $sql1->execute(array($dados['codVerificacao']));


      }

      public static function salvarDadosVerificacao($dados){
        $conexao = MySql::conectar();
        $anoAtual = date('Y'); 
        $dataAtual = date('Y-m-d'); 
         // Conectar ao banco de dados e preparar a consulta SQL
         $sql = MySql::conectar()->prepare(
          "INSERT INTO simples_verificacao_fiscal (
            ano_exercicio, data_verificacao, desc_verificacao, cod_contribuinte, cod_auditor, mun_processo_adm, flg_situacao_verificacao) 
          VALUES 
            (?, ?, ?, ?, ?, ?, ?)");
          // Executar a consulta com os dados fornecidos
        $sql->execute(array(
          $anoAtual, $dataAtual, 'Incuido via Sistema', $dados['cod_pessoa'], 1, '123/2024', 1
        ));
        $cod_verificacao_fiscal = $conexao->lastInsertId();
        return $cod_verificacao_fiscal;
      }

      public static function salvarDadosItensVerificacao($dados) {
        $periodoApuracao = $dados['pa'];
        $data = new DateTime($periodoApuracao);
        $data->modify('+1 month');
        $data->setDate($data->format('Y'), $data->format('m'), 20);
        $dataVencimento = $data->format('Y-m-d');


        $sql = MySql::conectar()->prepare(
        "INSERT INTO  simples_item_verificacao_fiscal (
          cod_verificacao_fiscal, periodo_apuracao, data_vencomento, item_lista, anexo, tipo_infracao, vr_receita_b12_declarada, vr_base_calculo_declarada,
          aliquota_declarada, vr_recolhido, vr_receita_b12_apurada, vr_base_calculo_apudada, aliquota_efetiva, vr_apurado, vr_original, vr_juros_mora, perc_juros_mora,
          vr_multa_mora, perc_multa_mora, vr_multa_punitiva, perc_multa_punitiva, vr_atualizado)
        VALUES
          (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        $sql->execute([
          $dados['cod_verificacao_fiscal'],
          $dados['pa'],
          $dataVencimento,
          $dados['iLista'],
          $dados['anexo'],
          $dados['infracao'],
          $dados['rbt12d'],
          $dados['recd'],
          $dados['alqd'],
          $dados['ISSPg'],
          $dados['rbt12a'],
          $dados['reca'],
          $dados['aliquota'],
          $dados['vrapr'],
          $dados['vrpincipal'],
          $dados['vrselic'],
          $dados['pselic'],
          1, //ainda falta colocar no formulario a multa de mora
          2, //ainda falta colocar no formulario a multa de mora
          $dados['vrMultap'],
          $dados['MultaP'],
          $dados['vrAtualizado']
        ]);
        return $dados['cod_verificacao_fiscal'];
      }  

      public static function incluirDadosAuto($dadosArray) {
        // Conectar ao banco de dados e preparar a consulta SQL para inclusão
        $conexao = MySql::conectar();
        $sql = $conexao->prepare(
          "INSERT INTO simples_item_verificacao_fiscal (
            cod_verificacao_fiscal, periodo_apuracao, data_vencomento, item_lista, anexo, tipo_infracao, 
            vr_receita_b12_declarada, vr_base_calculo_declarada, aliquota_declarada, 
            vr_recolhido, vr_receita_b12_apurada, vr_base_calculo_apudada, 
            aliquota_efetiva, vr_apurado, vr_original, vr_juros_mora, perc_juros_mora, vr_multa_mora,
            perc_multa_mora, vr_multa_punitiva, perc_multa_punitiva, vr_atualizado 
          ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    
        // Percorrer o array com os dados e executar a inserção para cada item
        foreach ($dadosArray as $dados) {
          $sql->execute(array(
            $dados['cod_verificacao_fiscal'], $dados['pa'], $dados['vencimento'], $dados['iLista'], $dados['anexo'],
            $dados['infracao'], $dados['rbt12d'], $dados['recd'], $dados['alqd'], $dados['ISSPg'],
            $dados['rbt12a'], $dados['reca'], $dados['aliquota'], $dados['vrapr'],
            $dados['vrpincipal'], $dados['vrselic'], $dados['pselic'], 1, 2, $dados['vrMultap'], $dados['MultaP'], $dados['vrAtualizado']
          ));
        }
        $conexao = null;
      }

      public static function excluirItenAuto($dadosArray) {
        $conexao = MySql::conectar();
        $sql = $conexao->prepare(
            "DELETE FROM simples_item_verificacao_fiscal WHERE cod_item_verificacao_fiscal = ?"
        );
        foreach ($dadosArray as $cod_item) {
            $sql->execute(array($cod_item));
        }
        $conexao = null;
    }

    public static function alterarItemAuto($dados) {

       
   
      // Conectar ao banco de dados
      $conexao = MySql::conectar();
      $sql = $conexao->prepare(
          "UPDATE simples_item_verificacao_fiscal 
          SET 
            periodo_apuracao = ?,
            data_vencomento = ?,
            item_lista = ?,
            anexo = ?,
            tipo_infracao = ?,
            vr_receita_b12_declarada = ?,
            vr_base_calculo_declarada = ?,
            aliquota_declarada = ?,
            vr_recolhido = ?,
            vr_receita_b12_apurada = ?,
            vr_base_calculo_apudada = ?,
            aliquota_efetiva = ?,
            vr_apurado = ?,
            vr_original = ?,
            vr_juros_mora = ?,
            perc_juros_mora = ?,
            vr_multa_mora = ?,
            perc_multa_mora = ?,
            vr_multa_punitiva = ?,
            perc_multa_punitiva = ?,
            vr_atualizado = ?
          WHERE cod_item_verificacao_fiscal = ?"
      );
  
      foreach ($dados as $item) {
 
        $periodoApuracao = $item['periodoApuracao'];
        $data = new DateTime($periodoApuracao);
        $data->modify('+1 month');
        $data->setDate($data->format('Y'), $data->format('m'), 20);
        $dataVencimento = $data->format('Y-m-d');

        $sql->execute(array(
          $item['periodoApuracao'], 
        $dataVencimento, 
        $item['iLista'],
        $item['anexo'],
        $item['infracao'],
        $item['rbt12d'],
        $item['recd'],
        $item['alqd'],
        $item['ISSPg'],
        $item['rbt12a'],
        $item['reca'],
        $item['aliquota'],
        $item['vrapr'],
        $item['vrpincipal'],
        $item['vrselic'],
        $item['pselic'],
        1,
        2,
        $item['vrMultap'],
        $item['MultaP'],
        $item['vrAtualizado'],
        $item['cod_verificacao']
          
      ));
    }
    $conexao = null;
  }
  
   
  
    
    } 

function converterPAParaDate($pa) {
  if (isset($pa) && strpos($pa, '/') !== false) {
      $partes = explode('/', $pa);
      $mes = $partes[0];
      $ano = $partes[1];
      return "$ano-$mes-01"; // Formato AAAA-MM-DD
  } else {
      return null; // Ou retorne uma string padrão ou lance um erro, dependendo do que for mais apropriado
  }
}
?>
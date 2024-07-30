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
        $sql = MySql::conectar()->prepare("SELECT us.cod_usuario, us.nome_usuario, dc.desc_cargo FROM `tb_admin_usuarios` us INNER JOIN `tb_admin.desc_cargo` dc ON us.id_cargo = dc.id_cargo");
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
        $sql = MySql::conectar()->prepare("UPDATE `tb_admin_usuarios` set login_usuario = ?, nome_usuario = ?, email_usuario = ?, id_cargo = ?, senha_usuario = ? WHERE cod_usuario = ?");
        if($sql->execute(array($login, $nome, $email, $nivel, $senha, $cod_usuario))){
          return true;
        }else{
          return false;
        }
      }

}
?>
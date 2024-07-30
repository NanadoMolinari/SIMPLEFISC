

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Autenticação - SIMPLEFISC</title>
        <link rel="shortcut icon" type="imagex/png" href="<?php echo INCLUDE_PATH;?>images/ico.png">
        <link rel="stylesheet" href="<?php echo INCLUDE_PATH;?>css/all.min.css">
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='stylesheet' type='text/css' media='screen' href='<?php echo INCLUDE_PATH;?>css/main.css'>
    </head>
    <body>
        <div class="box-login">
            <?php
                if(isset($_POST['acao'])){
                    $user = $_POST['user'];
                    $password = $_POST['password'];
                    $sql = MySql::conectar()->prepare( "SELECT * FROM `tb_admin_usuarios` WHERE login_usuario = ? and senha_usuario = ?");
                    $sql->execute(array($user,$password));
                    if($sql->rowCount() == 1){
                        $info = $sql->fetch();
                        $_SESSION['login'] = true;
                        $_SESSION['user'] = $user;
                        $_SESSION['password'] = $password;
                        $_SESSION['nivel'] = $info['id_cargo'];
                        $_SESSION['nome'] = $info['nome_usuario'];
                        header('Location: '.INCLUDE_PATH);
                        die();
                    }else{
                        //falha login
                        echo '<div class="erro-login"><i class="fa fa-times"></i> Usuário ou senha inválido </div>';
                    }
                }
                
               
            ?>
            <div class="logo-login"></div>
            <form method="post">
                <input type="text" name="user" placeholder="Usuário..." required>
                <input type="password" name="password" placeholder="Senha..." required>
                <input type="submit" name="acao" value="Entrar">
            </form>
        </div><!--box-login-->

    </body>
</html>
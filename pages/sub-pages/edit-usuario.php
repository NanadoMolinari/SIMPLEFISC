
<?php
    if(isset($_GET['cod_usuario'])) {
    $cod_usuario = $_GET['cod_usuario'];
    $sql = MySql::conectar()->prepare("SELECT * from `admin_usuarios` WHERE cod_usuario=?");
    $sql->execute(array($cod_usuario));
    $usuario = $sql->fetch();
}

?>

<div class="content">
    <div class="box-tabela">
        <H2><i class="fa fa-pencil"></i> Editar Usuário</H2>
        <form method="post">
            <?php
                if(isset($_POST['acao'])){
                   
                   
                    $login = $_POST['login'];
                    $nome = $_POST['nome'];
                    $email = $_POST['email'];
                    $nivel = $_POST['nivel'];
                    $senha = $_POST['senha'];
                    $user = Painel::atualizarUsuario($login, $nome, $email, $nivel, $senha, $cod_usuario);
                    if(Painel::atualizarUsuario($login, $nome, $email, $nivel, $senha, $cod_usuario)){
                        header("Location: list-usuarios");
                       // Painel::alert('sucesso','O cadastro foi atualizado com sucesso!');
                    }else{
                        Painel::alert('erro','Erro ao atualizar!');
                    }
                    
                }

            ?>
            <div class="form-group">
            
                <label>Login do Usuário</label>
                <input type="text" name="login" value="<?php echo $usuario['login_usuario'] ?>">
            </div><!--form-group-->
            <div class="form-group">
                <label>Nome do Usuário</label>
                <input type="text" name="nome" value="<?php echo $usuario['nome'] ?>">
            </div><!--form-group-->
            <div class="form-group">
                <label>E-mail do Usuário</label>
                <input type="text" name="email" value="<?php echo $usuario['email'] ?>">
            </div><!--form-group--> 
            <div class="form-group">
                <label>Nível do Usuário</label>
                <input type="text" name="nivel" value="<?php echo $usuario['cod_cargo'] ?>">
            </div><!--form-group-->
            <div class="form-group">
                <label>Senha do Usuário</label>
                <input type="password" name="senha" value="<?php echo $usuario['senha'] ?>">
            </div><!--form-group-->
            <input type="submit" name="acao" value="Salvar" class="botao-salvar">
        </form>
    </div><!--box-tabela-->
</div>
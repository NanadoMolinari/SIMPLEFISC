<?php
     permissaoPagina(2);
    $listUsuarios = Painel::listarUsuarios();

?>
<div class="content">
   
    <div class="box-tabela">
        <H2><i class="fa fa-user"></i> Usuários Cadastrados</H2>
        <div class="table-list">
            <div class="row-list">
                <div class="col-list">
                    <span>Código do Usuário</span>
                </div><!--col-list-->
                <div class="col-list">
                    <span>Nome Usuário</span>
                </div><!--col-list-->
                <div class="col-list">
                    <span>Nível Usuario</span>
                </div><!--col-list-->
                <div class="col-list">
                    <i class="fa-solid fa-pen-to-square azul"></i><span> Editar</span>
                </div>
                <div class="col-list">
                    <i class="fa fa-trash-can"></i><span> Apagar</span>
                </div>
                <div class="clear"></div>
            </div><!--row-list-->

            <?php
               
                foreach($listUsuarios as $key => $value){
               
            ?>
            <div class="row-list">
                <div class="col-list">
                    <span><?php echo $value['cod_usuario'] ?></span>
                </div><!--col-list-->
                <div class="col-list">
                    <span><?php echo $value['nome'] ?></span>
                </div><!--col-list-->
                <div class="col-list">
                    <span><?php echo $value['desc_cargo'] ?></span>
                </div><!--col-list-->
                <div class="col-list">
                    <input type="hidden" name="cod_usuario" value="<?php echo $value['cod_usuario']; ?>">
                    <a href="<?php echo INCLUDE_PATH_TABLE ?>edit-usuario?cod_usuario=<?php echo $value['cod_usuario'] ?>"><i class="fa-solid fa-pen-to-square azul"></i></a>
                </div>
                <div class="col-list">
                    <i class="fa fa-trash-can vermelho"></i>
                </div>
                <div class="clear"></div>
            </div><!--row-list-->
            <?php } ?>
        </div><!--table-list-->
    </div><!--box-tabela-->
  
</div><!--content-->
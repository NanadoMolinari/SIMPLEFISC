<?php

$sql = MySql::conectar()->prepare("SELECT * FROM `simples_selic` order by data_selic desc");
$sql->execute();
$listSELIC = $sql->fetchAll();

  
?>
<div class="content">
   
    <div class="box-tabela">
        <H2><i class="fa-solid fa-dollar-sign"></i> Listagem da SELIC</H2>
        <div class="table-list">
            <div class="row-list">
                <div class="col-list">
                    <span>Data</span>
                </div><!--col-list-->
                <div class="col-list">
                    <span>Valor</span>
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
               
                foreach($listSELIC as $key => $value){
               
            ?>
            <div class="row-list">
                <div class="col-list">
                    <span><?php echo date('m/Y',strtotime($value['data_selic'])) ?></span>
                </div><!--col-list-->
                <div class="col-list">
                    <span><?php echo $value['valor_selic'] ?></span>
                </div><!--col-list-->
                <div class="col-list">
                    <i class="fa-solid fa-pen-to-square azul"></i>
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
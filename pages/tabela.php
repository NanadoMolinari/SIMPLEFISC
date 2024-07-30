        <section class="topo">
            <div class="container">
                <div class="banner">
                    <h2>Tabelas Auxiliares</h2>
                </div><!--banner-->
            </div><!--container-->
        </section><!--topo-->
        <div class="corpo">
            <div class="menu-tabela">
                <div class="itens-menu">
                    <h2>Contribuintes</h2>
                    <a href="<?php echo INCLUDE_PATH_TABLE ?>list-ctb">Listar Contribuintes</a>
                    <a href="<?php echo INCLUDE_PATH_TABLE ?>cad-contribuintes">Cadastrar Contribuintes</a>
                </div><!--itens-menu-->
                <div class="itens-menu">
                    <h2>Alíquotas</h2>
                    <a href="">Listar Alíquotas</a>
                    <a href="">Cadastrar Alíquotas</a>
                </div><!--itens-menu-->
                <div class="itens-menu">
                    <h2>SELIC</h2>
                    <a <?php selecionadoMenu('list-selic')?> href=" <?php echo INCLUDE_PATH_TABLE ?>list-selic">Listar SELIC</a>
                    <a <?php selecionadoMenu('cad-selic')?> href=" <?php echo INCLUDE_PATH_TABLE ?>cad-selic">Cadastrar SELIC</a>
                </div><!--itens-menu-->
                <div class="itens-menu">
                    <h2>Usuários</h2>
                    <a <?php selecionadoMenu('list-usuarios')?><?php permissaoMenu(2)?> href=" <?php echo INCLUDE_PATH_TABLE ?>list-usuarios">Listar Usuários</a>
                    <a href="">Cadastrar Usuários</a>
                </div><!--itens-menu-->
            </div><!--menu-tabela-->
            <div class="header-tabela">
                <div class="menu-btn">
                    <i class="fa-solid fa-angles-left"></i>
                </div><!--menu-btn-->
            </div><!--header-tabela-->
            <div class="container">
                <?php
                    $url2 = isset($_GET['url2']) ? $_GET['url2'] : 'tb-home';
                    if(file_exists('pages/sub-pages/'.$url2.'.php')){
                        include('pages/sub-pages/'.$url2.'.php');
                    }else{
                        include('pages/sub-pages/tb-home.php');
                    }
                ?>
            </div><!--container-->
        </div><!--corpo-->
    <script type="text/javascript" language="javascript" src="<?php echo INCLUDE_PATH;?>js/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="<?php echo INCLUDE_PATH;?>js/menu.js"></script>
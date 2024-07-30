<?php
    if(isset($_GET['logout'])){
        Painel::logout();
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Auto de Infração - Simples Nacional</title>
    <link rel="shortcut icon" type="imagex/png" href="<?php echo INCLUDE_PATH;?>images/ico.png">
    <link rel="stylesheet" href="<?php echo INCLUDE_PATH;?>css/all.min.css">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='<?php echo INCLUDE_PATH;?>css/main.css'>
</head>
<body>


    <header>
        <div class="container ">
           <a href="<?php echo INCLUDE_PATH;?>"> <div class="logo">
                
            </div><!--logo--></a>
            <div class="menu-desktop">
            <nav class="menu">
                <ul>
                    <li>
                        <a href="<?php echo INCLUDE_PATH;?>">Inicio</a>
                        <a href="<?php echo INCLUDE_PATH;?>fundamentacao">Fundamentação</a>
                        <a href="<?php echo INCLUDE_PATH;?>auto">Auto de Infração</a>
                        <a href="<?php echo INCLUDE_PATH;?>tabela">Tabelas</a>
                        <a class="logout" href="<?php echo INCLUDE_PATH ?>?logout"><i class="fa fa-window-close logout"></i> Sair</a>
                    </li>
                </ul>
            </nav>
            </div>
        </div><!--container-->
        <div class="clear"></div>            
    </header>
    <?php
        $url = isset($_GET['url1']) ? $_GET['url1'] : 'home';
        if(file_exists('pages/'.$url.'.php')){
            
            include('pages/'.$url.'.php');
        }else{
            include('pages/p-404.php');
        }
    ?>
    <script type="text/javascript" language="javascript" src="<?php echo INCLUDE_PATH;?>js/jquery-3.6.4.min.js"></script>
    <script type="text/javascript" src="<?php echo INCLUDE_PATH;?>js/main.js"></script>
   
</body>
</html>
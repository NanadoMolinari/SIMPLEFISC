<?php
    
    session_start();
    spl_autoload_register(function ($class) {
        include 'classes/' . $class . '.php';
    });
    
   define('INCLUDE_PATH','http://localhost/SIMPLEFISC/');
   define('INCLUDE_PATH_TABLE',INCLUDE_PATH . 'tabela/');
   
   //coneção com BD
   define('HOST','localhost');
   define('USER','root');
   define('PASSWORD','');
   define('DATABASE','SIMPLEFISC');

   /*Funções Gerais */
   function selecionadoMenu($par){
        $url = $_GET['url2'];
        if($url == $par){
            echo 'class="menu-active"';
        }
   }

   function permissaoMenu($per){
        if($_SESSION['nivel'] >= $per){
            return;
        }else{
            echo 'style="display:none;"';
        }
   }
    
   function permissaoPagina($per){
    if($_SESSION['nivel'] >= $per){
        return;
    }else{
        include('pages/sub-pages/permissao-negada.php');
        die();
    }
   }
?>
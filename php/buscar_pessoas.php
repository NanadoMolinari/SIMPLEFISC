<?php  
    require '../config.php';
    $sql = MySql::conectar()->prepare("SELECT * FROM `simples_contribuinte`");
    $sql->execute();
    $contribuintes = $sql->fetchAll();
?>

<div id="modal-body">
    <div class="busca-pessoas">
        <h1><i class="fa-solid fa-magnifying-glass"></i> Busca de Contribuintes</h1>
        <div class="form-busca">
            <div class="wrap-busca">
                <label for="codigo">Código:</label>
                <input class="w100" type="text" id="codigo-busca" name="codigo" placeholder="Digite o código">
            </div>
            <div class="wrap-busca">
                <label for="nome">Nome:</label>
                <input class="w100" type="text" id="nome-busca" name="nome" placeholder="Digite o nome">
            </div>
            <div class="wrap-busca">
                <label for="cnpj">CNPJ:</label>
                <input class="w100" type="text" id="cnpj-busca" name="cnpj" placeholder="Digite o CNPJ">
            </div>
        </div>
        <div class="btn-direita">
            <button class="verde" id="buscar-pessoas" name="buscar-pessoas" type="button">Buscar</button>
        </div>
       
        <div class="resultados-busca">
        <div id="resultado"></div>
            <table id="resultado-pessoas">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Razão Social</th>
                        <th>CNPJ</th>
                    </tr>
                </thead>
                <tbody id="resultadoTabela">
               <?php foreach ($contribuintes as $resultado) {
                        echo '<tr class="clickable-row" data-codigo="' . $resultado['cod_contribuinte'] . '" data-nome="' . $resultado['razao_social'] . '" data-cnpj="' . $resultado['CNPJ'] . '">';
                        echo '<td>' . $resultado['cod_contribuinte'] . '</td>';
                        echo '<td>' . $resultado['razao_social'] . '</td>';
                        echo '<td>' . $resultado['CNPJ'] . '</td>';
                        echo '</tr>';
                       
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

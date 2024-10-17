<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { display: flex; align-items: center; margin-bottom: 20px;  border: 1px solid black; padding: 10px; } 
        .logo { height: 80px; width: 350px;  padding: 10px; background-image: url("images/logo.png");} 
        .cabecalho { margin-left: 20px; text-align: center;  padding: 10px; flex-grow: 1;} 
        .cabecalho h1, .cabecalho h2 { margin: 0; } 
        .info { margin-top: 20px; }
        .info div { margin-bottom: 10px; }
        .valores { margin-top: 20px; }
        .valores table { width: 100%; border-collapse: collapse; }
        .valores th, .valores td { border: 1px solid #000; padding: 8px; text-align: center; }
        .assinatura { margin-top: 40px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            
        </div>
        <div class="cabecalho">
            <h1>AUTO DE INFRAÇÃO - SIMPLES NACIONAL</h1>
            <h2>Auto de Infração Nº  . 1</h2>
        </div>
    </div>
    
    <div class="info">
        <div><strong>Autuado:</strong> Teste</div>
        <div><strong>CPF/CNPJ:</strong> teste</div>
        <div><strong>Relato:</strong> teste</div>
        <div><strong>Fundamentação Legal:</strong> 'teste</div>
    </div>

    <div class="valores">
        <table>
            <thead>
                <tr>
                    <th>Encargo</th>
                    <th>Valor (R$)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Valor Principal</td>
                    <td>1</td>
                </tr>
                <tr>
                    <td>Multa</td>
                    <td>2</td>
                </tr>
                <tr>
                    <td>Juros</td>
                    <td>3</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td>4'</td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <div class="assinatura">
        <p>________________________</p>
        <p>Assinatura do Auditor</p>
    </div>
</body>
</html>
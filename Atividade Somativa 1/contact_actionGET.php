<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&family=Zain:wght@200;300;400;700;800;900&display=swap" rel="stylesheet">
    
    <link rel="icon" type="image/png" href="img/icon_samurai.png">
    <title>Samurai Hotel - AF1 - さむらい サムライ ホテル</title>
</head>

<body>
    <?php
    $nome = $_GET["nome"];
    $email = $_GET["email"];
    $celular = $_GET["celular"];
    $dataNasc = $_GET["dataNasc"];
    $termo = $_GET["agree-term"];

    list($ano, $mes, $dia) = explode('-', $dataNasc); // Separa ano, mês e dia de $data
    $aniversario = $dia . '/' . $mes . '/' . $ano; // Formata data: dia, mês e ano

    // Cria a data atual
    $hoje = mktime(0, 0 , 0, date('m'), date('d'), date('Y'));
    
    // Descobre a unix timestamp da data de nascimento da pessoa
    $nascimento = mktime( 0, 0, 0, $mes, $dia, $ano);
    $idade = floor((((($hoje - $nascimento) / 60) / 60) / 24) / 365.25);

    ?>

    <div class="header">
        <h1>サムライ ホテル</h1>
    </div>
    
    <div class="top-navbar">
        <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="form.html">Contato</a></li>
            
            <li><a href="about.html">Sobre</a></li>
        </ul>
    </div>

    <table class="tableCSS">
        <tr>
            <th>CAMPO</th>
            <th>VALOR</th>
        </tr>

        <tr>
            <th>Nome</th>
            <td><?php echo $nome; ?></td>
        </tr>

        <tr>
            <th>E-mail</th>
            <td><?php echo $email; ?></td>
        </tr>

        <tr>
            <th>Celular</th>
            <td><?php echo $celular; ?></td>
        </tr>

        <tr>
            <th>Aniversário</th>
            <td><?php echo $aniversario; ?></td>
        </tr>

        <tr>
            <th>Idade</th>
            <td><?php echo $idade; ?></td>
        </tr>

        <tr>
            <th>Concorda Form?</th>
            <td><?php echo $agree; ?></td>
        </tr>

    </table>
    
    
    <div class="footer">
        <p>Atividade Formativa 1 - Fundamentos da Programação Web<br>PUCPR 2025</p>
    </div>

    <script src="/js/script.js"></script>
    
</body>
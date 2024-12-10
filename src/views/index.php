<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de Moedas</title>
    <link rel="stylesheet" href="/public/styles.css">
</head>

<body>
    <div class="container">
        <h1>Conversor de Moedas</h1>
        <form id="currency-converter-form">
            <div class="form-group">
                <label for="from-currency">Moeda de Origem:</label>
                <select id="from-currency" required></select>
            </div>

            <div class="form-group">
                <label for="to-currency">Moeda de Destino:</label>
                <select id="to-currency" required></select>
            </div>

            <div class="form-group" style="display:flex; flex-direction:column;">
                <label for="amount">Valor:</label>
                <input type="text" id="amount" style="width: auto;" placeholder="Digite o valor" required />
            </div>

            <button type="submit">Converter</button>
        </form>
    </div>

    <div id="result-container" class="hidden container">
        <span class="result-title">Resultado</span>
        <div id="result">
            <p></p>
        </div>
    </div>
    <script src="/public/script.js"></script>
</body>

</html>
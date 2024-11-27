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
                <input type="number" id="amount" style="width: auto;" placeholder="Digite o valor" required />
            </div>

            <button type="submit">Converter</button>
        </form>

        <div id="result-container" class="hidden">
            <h2>Resultado:</h2>
            <p id="result"></p>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const fromCurrencySelect = document.getElementById('from-currency');
            const toCurrencySelect = document.getElementById('to-currency');
            const resultContainer = document.getElementById('result-container');
            const resultText = document.getElementById('result');

            // Função para carregar as taxas de câmbio
            async function loadRates() {
                try {
                    const response = await fetch('/index.php?action=list');
                    const data = await response.json();

                    if (!data.success) throw new Error(data.message);

                    populateCurrencySelect(fromCurrencySelect, data.rates);
                    populateCurrencySelect(toCurrencySelect, data.rates);
                } catch (error) {
                    alert('Erro ao carregar taxas de câmbio: ' + error.message);
                }
            }

            function populateCurrencySelect(selectElement, rates) {
                Object.keys(rates).forEach(currency => {
                    const option = document.createElement('option');
                    option.value = currency;
                    option.textContent = currency;
                    selectElement.appendChild(option);
                });
            }

            document.getElementById('currency-converter-form').addEventListener('submit', async (event) => {
                event.preventDefault();

                const fromCurrency = fromCurrencySelect.value;
                const toCurrency = toCurrencySelect.value;
                const amount = parseFloat(document.getElementById('amount').value);

                if (!amount || amount <= 0) {
                    alert('Por favor, insira um valor válido.');
                    return;
                }

                try {
                    const response = await fetch(`/index.php?action=convert&from=${fromCurrency}&to=${toCurrency}&amount=${amount}`);
                    const data = await response.json();

                    if (!data.success) {
                        throw new Error(data.message);
                    }

                    resultText.textContent = `${amount} ${fromCurrency} = ${data.converted.toFixed(2)} ${toCurrency}`;
                    resultContainer.classList.remove('hidden');
                } catch (error) {
                    alert('Erro ao converter moedas: ' + error.message);
                }
            });

            loadRates();
        });
    </script>
</body>

</html>
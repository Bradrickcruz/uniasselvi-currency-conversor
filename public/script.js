document.addEventListener('DOMContentLoaded', () => {
  const fromCurrencySelect = document.getElementById('from-currency');
  const toCurrencySelect = document.getElementById('to-currency');
  const resultContainer = document.getElementById('result-container');
  const resultText = document.getElementById('result');

  async function loadRates() {
    try {
      const response = await fetch('/index.php?action=list');
      const data = await response.json();

      if (!data.success) throw new Error(data.message);

      populateCurrencySelect(fromCurrencySelect, data.currencies);
      populateCurrencySelect(toCurrencySelect, data.currencies);
    } catch (error) {
      alert('Erro ao carregar taxas de câmbio: ' + error.message);
    }
  }

  function populateCurrencySelect(selectElement, rates) {
    Object.keys(rates).forEach((currency) => {
      const option = document.createElement('option');
      option.value = currency;
      option.textContent = rates[currency];
      selectElement.appendChild(option);
    });
  }

  document
    .getElementById('currency-converter-form')
    .addEventListener('submit', async (event) => {
      event.preventDefault();

      const fromCurrency = fromCurrencySelect.value;
      const toCurrency = toCurrencySelect.value;
      const amount = parseFloat(document.getElementById('amount').value);

      if (!amount || amount <= 0) {
        alert('Por favor, insira um valor válido.');
        return;
      }

      try {
        const response = await fetch(
          `/index.php?action=convert&from=${fromCurrency}&to=${toCurrency}&amount=${amount}`
        );
        const data = await response.json();

        if (!data.success) throw new Error(data.message);

        resultText.textContent = `${amount} ${fromCurrency} = ${data.converted.toFixed(
          2
        )} ${toCurrency}`;
        resultContainer.classList.remove('hidden');
      } catch (error) {
        alert('Erro ao converter moedas: ' + error.message);
      }
    });

  loadRates();
});

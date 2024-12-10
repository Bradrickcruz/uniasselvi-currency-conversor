document.addEventListener('DOMContentLoaded', () => {
  const fromCurrencySelect = document.getElementById('from-currency');
  const toCurrencySelect = document.getElementById('to-currency');
  const resultContainer = document.getElementById('result-container');
  const resultText = document.querySelector('#result p');

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

  function populateCurrencySelect(selectElement, currencies) {
    currencies.forEach((currency) => {
      console.log(currency);
      const option = document.createElement('option');
      option.value = currency.code;
      option.textContent = `${currency.name} (${currency.symbol})`;
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

        resultText.textContent = `${formatCurrency(amount,fromCurrency)} = ${formatCurrency(
          data.converted.toFixed(2),
          toCurrency
        )}`;
        resultContainer.classList.remove('hidden');
      } catch (error) {
        alert('Erro ao converter moedas: ' + error.message);
      }
    });

  loadRates();
});

function formatCurrency(value, currency) {
  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency,
  }).format(value);
}

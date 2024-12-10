document.addEventListener('DOMContentLoaded', () => {
  const fromCurrencySelect = document.getElementById('from-currency');
  const toCurrencySelect = document.getElementById('to-currency');
  const resultContainer = document.getElementById('result-container');
  const resultText = document.querySelector('#result p');
  const amountInput = document.getElementById('amount');
  amountInput.value = '0,00';

  amountInput.addEventListener('input', (event) => {
    let value = moneyMask(event.target.value);
    event.target.value = value;
  });

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
      const amount = cleanCurrencyValue(
        document.getElementById('amount').value
      );

      if (!amount || amount <= 0) {
        alert('Por favor, insira um valor válido.');
        return;
      }

      const result = await getResult(fromCurrency, toCurrency, amount);
      console.log(result);
      resultText.textContent = `${formatCurrency(
        amount,
        fromCurrency
      )} = ${formatCurrency(result.converted, toCurrency)}`;
      resultContainer.classList.remove('hidden');
    });

  loadRates();
});

function formatCurrency(value, currency) {
  return new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency,
  }).format(value);
}

function formatCurrencyValue(value) {
  return new Intl.NumberFormat('pt-BR').format(value);
}

function cleanCurrencyValue(value) {
  value = value.replace(/\./g, '');
  value = value.replace(',', '.');
  return parseFloat(value);
}

async function getResult(fromCurrency, toCurrency, amount) {
  try {
    const response = await fetch(
      `/index.php?action=convert&from=${fromCurrency}&to=${toCurrency}&amount=${amount}`
    );
    const data = await response.json();

    if (!data.success) throw new Error(data.message);

    return data;
  } catch (error) {
    alert('Erro ao converter moedas: ' + error.message);
  }
}

function moneyMask(value) {
  if (!value) return value;
  value = value.replace('.', '').replace(',', '').replace(/\D/g, '');

  const options = { minimumFractionDigits: 2 };
  const result = new Intl.NumberFormat('pt-BR', options).format(
    parseFloat(value) / 100
  );

  return result;
}

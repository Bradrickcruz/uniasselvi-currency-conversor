-- Tabela para armazenar informações básicas das moedas
CREATE TABLE IF NOT EXISTS currencies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,                               -- Nome da moeda, ex: Dólar Americano
    code TEXT NOT NULL UNIQUE,                        -- Código da moeda, ex: USD, BRL
    symbol TEXT NOT NULL,                             -- Símbolo da moeda, ex: $, R$
    rate REAL NOT NULL,                               -- Taxa de conversão relativa à moeda base
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP     -- Última atualização
);

<?php

$databasePath = __DIR__ . '/database/database.sqlite';
$schemaPath = __DIR__ . '/database/schema.sql';
$seedPath = __DIR__ . '/database/seed.sql';

echo $databasePath;

if (!file_exists($databasePath)) {
    $db = new SQLite3($databasePath);

    // Executar schema.sql
    if (file_exists($schemaPath)) {
        $schema = file_get_contents($schemaPath);
        $db->exec($schema);
    } else {
        echo "schema.sql não encontrado.\n";
    }

    // Executar seed.sql
    if (file_exists($seedPath)) {
        $seed = file_get_contents($seedPath);
        $db->exec($seed);
    } else {
        echo "seed.sql não encontrado.\n";
    }

    echo "Banco de dados inicializado com sucesso.\n";
} else {
    echo "Banco de dados já existe.\n";
}
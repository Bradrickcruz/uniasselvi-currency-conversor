<?php

namespace Utils;

class Helpers
{
    public static function loadRatesJSON(): array
    {
        $jsonFilePath = './data/rates.json';
        if (!file_exists($jsonFilePath)) {
            self::sendResponse(['success' => false, 'message' => 'Arquivo de taxas de câmbio não encontrado.']);
        }

        $jsonRawData = file_get_contents($jsonFilePath);
        return json_decode($jsonRawData, true);
    }

    public static function sendResponse(array $jsonBody): never
    {
        header('Content-Type: application/json');
        echo json_encode($jsonBody);
        exit;
    }

    public static function validateGETParams(array $requiredParams): array
    {
        $missingParams = [];
        $validatedParams = [];

        foreach ($requiredParams as $param => $type) {
            if (!isset($_GET[$param])) {
                $missingParams[] = $param;
                continue;
            }

            $value = $_GET[$param];
            switch ($type) {
                case 'float':
                    if (!is_numeric($value)) {
                        self::sendResponse(['success' => false, 'message' => "Parâmetro \"$param\" deve ser um número."]);
                    }
                    $validatedParams[$param] = floatval($value);
                    break;

                case 'string':
                    if (!is_string($value)) {
                        self::sendResponse(['success' => false, 'message' => "Parâmetro \"$param\" deve ser uma string."]);
                    }
                    $validatedParams[$param] = $value;
                    break;

                default:
                    self::sendResponse(['success' => false, 'message' => "Tipo \"$type\" não suportado para o parâmetro \"$param\"."]);
            }
        }

        if (!empty($missingParams)) {
            self::sendResponse(['success' => false, 'message' => 'Parâmetros faltando: ' . implode(', ', $missingParams)]);
        }

        return $validatedParams;
    }
}

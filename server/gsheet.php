<?php

use Google\Client;
use Google\Service\Sheets;

function writeToGoogleSheet($name,$phone,$email,$source) {
    // Load the Google API Client
    $client = new Client();
    $client->setApplicationName('Google Sheets API PHP');
    $client->setScopes([Sheets::SPREADSHEETS]);
    $client->setAuthConfig('__DIR__ .service-accounts.json');
    $client->setAccessType('offline');

    // Initialize Sheets API Service
    $service = new Sheets($client);

    // ID of the Google Sheet
    $spreadsheetId = '1r3190tdQ-uy08DzWzK0gLEsn46vJY6bBoanL3_ACfr8';

    // Data to append
    $data = [
        [$name,$phone,$email,$source]
    ];

    $body = new Sheets\ValueRange([
        'values' => $data
    ]);

    $params = [
        'valueInputOption' => 'RAW', // Options: RAW or USER_ENTERED
        'insertDataOption' => 'INSERT_ROWS' // Ensures data is appended
    ];

    // Range to update (e.g., Sheet1!A1:C3)
    $range = 'Data';

   
    // Append data to the sheet
    $service->spreadsheets_values->append(
            $spreadsheetId,
            $range,
            $body,
            $params
    );
}

?>
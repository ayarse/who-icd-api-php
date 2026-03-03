<?php

return [

    /*
    |--------------------------------------------------------------------------
    | WHO ICD API Client ID
    |--------------------------------------------------------------------------
    |
    | Your OAuth2 client_id obtained from https://icd.who.int/icdapi
    |
    */
    'client_id' => env('WHO_ICD_CLIENT_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | WHO ICD API Client Secret
    |--------------------------------------------------------------------------
    |
    | Your OAuth2 client_secret obtained from https://icd.who.int/icdapi
    |
    */
    'client_secret' => env('WHO_ICD_CLIENT_SECRET', ''),

    /*
    |--------------------------------------------------------------------------
    | API Version
    |--------------------------------------------------------------------------
    |
    | The API version header to send with every request (e.g. "v2").
    |
    */
    'api_version' => env('WHO_ICD_API_VERSION', 'v2'),

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    |
    | The Accept-Language header value (e.g. "en", "es", "zh").
    |
    */
    'language' => env('WHO_ICD_LANGUAGE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Token Endpoint
    |--------------------------------------------------------------------------
    |
    | The OAuth2 token endpoint used to obtain a bearer token.
    |
    */
    'token_endpoint' => env('WHO_ICD_TOKEN_ENDPOINT', 'https://icdaccessmanagement.who.int/connect/token'),

    /*
    |--------------------------------------------------------------------------
    | Base URL
    |--------------------------------------------------------------------------
    |
    | The base URL for the ICD API.
    |
    */
    'base_url' => env('WHO_ICD_BASE_URL', 'https://id.who.int'),

];

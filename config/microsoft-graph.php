<?php

return [
    /*
   * The base URL for Microsoft Graph API
   */
    'base_url' => 'https://graph.microsoft.com/v1.0/',

    /*
   * Default headers for all requests
   */
    'default_headers' => [
        'Content-Type' => 'application/json',
        'Accept' => 'application/json',
    ],

    /*
   * Session key for access token
   */
    'session_key' => 'microsoft_access_token',

    /*
   * Default timeout for requests in seconds
   */
    'timeout' => 30,
];

<?php

namespace SanSanLabs\MicrosoftGraph;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use SanSanLabs\MicrosoftGraph\Exceptions\MicrosoftGraphException;

class MicrosoftGraph {
  protected $client;

  protected $baseUrl = "https://graph.microsoft.com/v1.0/";

  protected $accessToken;

  public function __construct() {
    $this->client = new Client();
    $this->accessToken = session()->get(config("microsoft-graph.session_key"));
  }

  public function getAccessToken() {
    return $this->accessToken;
  }

  public function setAccessToken($token) {
    $this->accessToken = $token;
    session()->put(config("microsoft-graph.session_key"), $token);

    return $this;
  }

  protected function makeRequest($method, $endpoint, $options = []) {
    if (!$this->accessToken) {
      throw new \Exception("Access token is missing");
    }

    $defaultOptions = [
      "headers" => [
        "Authorization" => "Bearer " . $this->accessToken,
        "Content-Type" => "application/json",
        "Accept" => "application/json",
      ],
    ];

    $options = array_merge_recursive($defaultOptions, $options);

    try {
      $response = $this->client->request($method, $this->baseUrl . $endpoint, $options);

      return json_decode($response->getBody()->getContents(), true);
    } catch (RequestException $e) {
      $response = $e->getResponse();
      $error = json_decode($response->getBody()->getContents(), true);

      throw new MicrosoftGraphException($error["error"]["message"] ?? "Microsoft Graph API request failed", $response->getStatusCode(), $e);
    }
  }

  public function getProfile() {
    return $this->makeRequest("GET", "me");
  }

  public function getProfilePhoto() {
    return $this->makeRequest("GET", 'me/photo/$value', [
      "headers" => [
        "Content-Type" => "image/jpeg",
      ],
    ]);
  }

  public function getCalendarEvents($params = []) {
    return $this->makeRequest("GET", "me/events", [
      "query" => $params,
    ]);
  }

  public function createCalendarEvent($eventData) {
    return $this->makeRequest("POST", "me/events", [
      "json" => $eventData,
    ]);
  }
}

<?php

namespace SanSanLabs\MicrosoftGraph;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use SanSanLabs\MicrosoftGraph\Exceptions\MicrosoftGraphException;

class MicrosoftGraph {
  protected $client;
  protected $baseUrl;
  protected $accessToken;

  public function __construct() {
    $this->client = new Client();
    $this->baseUrl = config("microsoftgraph.base_url");
    $this->accessToken = session()->get(config("microsoftgraph.session_key"));
  }

  public function getAccessToken() {
    return $this->accessToken;
  }

  public function setAccessToken($token) {
    $this->accessToken = $token;
    session()->put(config("microsoftgraph.session_key"), $token);

    return $this;
  }

  protected function makeRequest($method, $endpoint, $options = []) {
    if (!$this->accessToken) {
      throw new \Exception("Access token is missing");
    }

    $defaultOptions = [
      "headers" => [
        "Authorization" => "Bearer {$this->accessToken}",
        "Content-Type" => "application/json",
        "Accept" => "application/json",
      ],
    ];

    $options = array_merge_recursive($defaultOptions, $options);

    try {
      $response = $this->client->request($method, $this->baseUrl . $endpoint, $options);

      $contentType = $response->getHeaderLine("Content-Type");
      $body = $response->getBody()->getContents();

      if (str_starts_with($contentType, "application/json")) {
        return json_decode($body, true);
      }

      return $body;
    } catch (RequestException $e) {
      $response = $e->getResponse();
      $error = json_decode($response->getBody()->getContents(), true);

      throw new MicrosoftGraphException($error["error"]["message"] ?? "Microsoft Graph API request failed", $response->getStatusCode(), $e);
    }
  }

  /*
   *  USER SECTION
   */

  /*
   *  Get my profile
   */
  public function getMyProfile(): mixed {
    $endpoint = "me";
    return $this->makeRequest("GET", $endpoint);
  }

  /*
   *  Get my about me
   */
  public function getMyAboutMe(): mixed {
    $endpoint = "me/aboutMe";
    return $this->makeRequest("GET", $endpoint);
  }

  /*
   *  Get my photo
   */
  public function getMyPhoto(): mixed {
    $endpoint = 'me/photo/$value';
    $photo = $this->makeRequest("GET", $endpoint);
    return response($photo, 200)->header("Content-Type", "image/jpeg");
  }

  /*
   *  Get users
   */
  public function getUsers(): array {
    $users = [];
    $endpoint = 'users?$top=999';

    while ($endpoint) {
      $response = $this->makeRequest("GET", $endpoint);

      if (isset($response["value"])) {
        $users = array_merge($users, $response["value"]);
      }

      if (isset($response["@odata.nextLink"])) {
        $parsed = parse_url($response["@odata.nextLink"]);
        $endpoint = "users" . "?" . ($parsed["query"] ?? "");
      } else {
        $endpoint = null;
      }
    }

    return $users;
  }

  /*
   *  Get user's profile by email
   */
  public function getUserProfileByEmail($userEmail = null): mixed {
    if (empty($userEmail)) {
      throw new MicrosoftGraphException("User email is required", 400);
    }
    $endpoint = "users/{$userEmail}";
    return $this->makeRequest("GET", $endpoint);
  }

  /*
   *  Get user's profile by id
   */
  public function getUserProfileById($userId = ""): mixed {
    if (empty($userId)) {
      throw new MicrosoftGraphException("User id is required", 400);
    }
    $endpoint = "users/{$userId}";
    return $this->makeRequest("GET", $endpoint);
  }

  /*
   *  Get user photo
   */
  public function getUserPhoto($userId = ""): mixed {
    if (empty($userId)) {
      throw new MicrosoftGraphException("User id is required", 400);
    }
    $endpoint = "users/{$userId}" . '/photo/$value';
    $photo = $this->makeRequest("GET", $endpoint);
    return response($photo, 200)->header("Content-Type", "image/jpeg");
  }
}

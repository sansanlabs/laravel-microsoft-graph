<?php

namespace SanSanLabs\MicrosoftGraph\Exceptions;

use Exception;
use Throwable;

class MicrosoftGraphException extends Exception {
  public function __construct($message = "", $code = 0, Throwable $previous = null) {
    parent::__construct($message, $code, $previous);
  }

  public function render($request) {
    return response()->json(
      [
        "error" => [
          "message" => $this->getMessage(),
          "code" => $this->getCode(),
        ],
      ],
      $this->getCode(),
    );
  }
}

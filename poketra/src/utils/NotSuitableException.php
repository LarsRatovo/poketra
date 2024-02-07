<?php
namespace App\util;

use Exception;

class NotSuitableException extends Exception{
    public function __construct($message) {
        parent::__construct($message);
    }
}
?>
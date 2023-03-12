<?php

namespace App\Services;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;

class TokenParser{
    
    public function __construct(
        private Configuration $config
    ){}

    public function parse(string $jwt): Token
    {
        $token = $this->config->parser()->parse($jwt);

        if (!$this->config->validator()->validate($token, ...$this->config->validationConstraints())) {
            throw new \InvalidArgumentException('Invalid token provided', 401);
        }

        return $token;
    }

}
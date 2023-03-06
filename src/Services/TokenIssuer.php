<?php

namespace App\Services;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;

class TokenIssuer{
    
    public function __construct(
        private Configuration $config
    ){}

    public function issueToken($claims): Token {
        
        $now = new \DateTimeImmutable();

        return $this->config->builder()
            ->identifiedBy(bin2hex(random_bytes(16)))
            ->issuedAt($now)
            ->expiresAt($now->modify('+1 hour'))
            ->canOnlyBeUsedAfter($now)
            ->withClaim('id', $claims->getId())
            ->getToken($this->config->signer(), $this->config->signingKey());
    }


}
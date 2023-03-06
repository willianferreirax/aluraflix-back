<?php

namespace Tests\Services;

use App\Services\TokenIssuer;
use PHPUnit\Framework\TestCase;
use App\Config\JWTConfig;

class TokenIssuerTest extends TestCase{

    private TokenIssuer $tokenIssuer;

    public function setUp(): void{
        $this->tokenIssuer = new TokenIssuer(JWTConfig::getConfig("you-must-provide-a-secret-key-ab"));
    }

    public function testTokenIssuerMustReturnToken(): void
    {
        $userMock = $this->createMock(\App\Models\User::class);
        $userMock->method('getId')->willReturn(1);

        $token = $this->tokenIssuer->issueToken($userMock);
        $this->assertInstanceOf(\Lcobucci\JWT\Token::class, $token);
        $this->assertIsString($token->toString());
    }

}
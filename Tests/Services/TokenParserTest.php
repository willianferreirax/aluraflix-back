<?php

namespace Tests\Services;

use App\Services\TokenParser;
use PHPUnit\Framework\TestCase;
use App\Config\JWTConfig;
use Lcobucci\JWT\Token;
use Lcobucci\JWT\Validation\Constraint;

class TokenParserTest extends TestCase {
    private TokenParser $tokenParser;

    const VALIDTOKEN = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJqdGkiOiI4YjNlYTY4NTZiNTI2NGExZDIxNWY4ZDI5MWM5OWYzZSIsImlhdCI6MTY3Nzg3MTU0Mi41MzIyMTgsImV4cCI6MTY3Nzg3NTE0Mi41MzIyMTgsIm5iZiI6MTY3Nzg3MTU0Mi41MzIyMTgsImlkIjoxfQ.lJJMa_jyhu91cjfIcoiIP-i4YsNqi3MCw1f5OjwWFyU";

    public function setUp(): void {

        $config = JWTConfig::getConfig("you-must-provide-a-secret-key-ab");

        JWTConfig::setConstraints(new Constraint\SignedWith(
            $config->signer(),
            $config->signingKey()
        ));

        $this->tokenParser = new TokenParser($config);
    }

    public function testTokenParserMustReturnTokenWithValidStringToken(): void {

        $token = $this->tokenParser->parse(self::VALIDTOKEN);

        $this->assertInstanceOf(Token::class, $token);
    }

    public function testTokenParserMustThrowExceptionWithInvalidStringToken(): void {

        $this->expectException(\InvalidArgumentException::class);

        $this->tokenParser->parse("invalid");
    }
}
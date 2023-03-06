<?php

namespace App\Config;

use Lcobucci\Clock\SystemClock;
use Lcobucci\JWT\Validation\Constraint;

class JWTConfig {

    private static $config;

    public static function getConfig(string $key): \Lcobucci\JWT\Configuration {

        self::$config = \Lcobucci\JWT\Configuration::forSymmetricSigner(
            new \Lcobucci\JWT\Signer\Hmac\Sha256(),
            \Lcobucci\JWT\Signer\Key\InMemory::plainText($key)
        );

        self::$config->setValidationConstraints(
            new Constraint\SignedWith(
                self::$config->signer(),
                self::$config->signingKey()
            )
            ,new Constraint\StrictValidAt(
                SystemClock::fromUTC()
            )
        );
        
        return self::$config;
    }

    public static function setConstraints(Constraint ...$constraints): void {
        self::$config->setValidationConstraints(...$constraints);
    }
}
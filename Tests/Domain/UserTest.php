<?php

namespace Tests\Domain;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void{
        $this->user = new User();
        $this->user->setCreatedAt(new \DateTime('2021-01-01 00:00:00'));
        $this->user->setUpdatedAt(new \DateTime('2021-01-01 00:00:00'));
    }

    /**
     * @dataProvider FieldsMustNotBeNumericAndShouldBeString
     */
    public function testFieldMustReturnString($field): void
    {
        $method = 'set' . key($field); 
        $this->user->$method('John Doe');

        $method = 'get' . key($field); 

        $this->assertIsString($this->user->$method());
    }

    /**
     * @dataProvider FieldsMustNotBeNumericAndShouldBeString
     */
    public function testFieldMustReturnTrimmedString($field): void
    {
        $method = 'set' . key($field); 
        $this->user->$method(' John Doe ');

        $method = 'get' . key($field); 
        $this->assertEquals('John Doe', $this->user->$method());
    }

    /**
     * @dataProvider FieldsMustNotBeNumericAndShouldBeString
     */
    public function testFieldMustNotBeEmptyString($field): void
    {

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage($field[key($field)][0]);

        $method = 'set' . key($field);
        $this->user->$method('');
    }

    /**
     * @dataProvider FieldsMustNotBeNumericAndShouldBeString
     */
    public function testFieldMustNotBeEmptyStringWithSpaces($field): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage($field[key($field)][0]);
        $method = 'set' . key($field);
        $this->user->$method(' ');
    }

    /**
     * @dataProvider FieldsMustNotBeNumericAndShouldBeString
     */
    public function testFieldMustNotBeNumericString($field): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage($field[key($field)][1]);
        $method = 'set' . key($field);
        $this->user->$method('123');
    }

    public static function nameExceptionMessages(): array
    {
        return  [ "Name" => ['Name is required','Name must be a string']];
    }

    public static function loginExceptionMessages(): array
    {
        return  [ "Login" => ['Login is required','Login must be a string']];
    }

    public static function FieldsMustNotBeNumericAndShouldBeString(){
        return [
            "Name" => [
                self::nameExceptionMessages()
            ],
            "Login" => [
                self::loginExceptionMessages()
            ]
        ];
    }

    public function testUserCreatedAtMustReturnADateString(){

        $this->assertIsString($this->user->getCreatedAt());

        $this->assertTrue(\DateTime::createFromFormat('Y-m-d H:i:s', $this->user->getCreatedAt()) !== false);
    }

    public function testUserCreatedAtMustReturnADateStringWithFormatYMDHIS(){
        
        $this->assertEquals('2021-01-01 00:00:00', $this->user->getCreatedAt());
    }

    public function testUserUpdatedAtMustReturnADateString(){
        
        $this->assertIsString($this->user->getUpdatedAt());

        $this->assertTrue(\DateTime::createFromFormat('Y-m-d H:i:s', $this->user->getUpdatedAt()) !== false);
    }

    public function testUserUpdatedAtMustReturnADateStringWithFormatYMDHIS(){
        
        $this->assertEquals('2021-01-01 00:00:00', $this->user->getUpdatedAt());
    }

    public function testPassMustReturnString(): void
    {
        $this->user->setPass('John Doe');

        $this->assertIsString($this->user->getPass());
    }


    public function testPassMustNotBeEmptyString(): void
    {

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Password is required');

        $this->user->setPass('');
    }

    public function testPassMustNotBeEmptyStringWithSpaces(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage("Password is required");
        $this->user->setPass(' ');
    }

}
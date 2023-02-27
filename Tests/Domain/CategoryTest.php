<?php

namespace App\Tests\Domain;

use App\Models\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase{


    public function testCategoryTitleMustBeAString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Title must be a string');
        $category = new Category();
        $category->setTitle(123);
    }

    public function testCategoryTitleMustNotBeEmptyString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Title is required');
        $category = new Category();
        $category->setTitle('');
    }

    public function testCategoryTitleMustNotBeANumericString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Title must be a string');
        $category = new Category();
        $category->setTitle('123');
    }

    public function testCategoryTitleReceivingAStringMustWork(){
        $category = new Category();
        $category->setTitle('Category 1');
        $this->assertEquals('Category 1', $category->getTitle());
    }

    public function testCategoryColorMustBeAString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Color must be a string');
        $category = new Category();
        $category->setColor(123);
    }

    public function testCategoryColorMustNotBeEmptyString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Color is required');
        $category = new Category();
        $category->setColor('');
    }

    public function testCategoryColorMustNotBeANumericString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Color must be a string');
        $category = new Category();
        $category->setColor('123');
    }

    public function testCategoryColorReceivingAStringMustWork(){
        $category = new Category();
        $category->setColor('red');
        $this->assertEquals('red', $category->getColor());
    }

    public function testCategoryCreatedAtMustReturnADateString(){
        $category = new Category();
        $category->setCreatedAt(new \DateTime('2021-01-01 00:00:00'));
        $this->assertIsString($category->getCreatedAt());

        $this->assertTrue(\DateTime::createFromFormat('Y-m-d H:i:s', $category->getCreatedAt()) !== false);
    }

    public function testCategoryCreatedAtMustReturnADateStringWithFormatYMDHIS(){
        $category = new Category();
        $category->setCreatedAt(new \DateTime('2021-01-01 00:00:00'));
        $this->assertEquals('2021-01-01 00:00:00', $category->getCreatedAt());
    }

    public function testCategoryUpdatedAtMustReturnADateString(){
        $category = new Category();
        $category->setUpdatedAt(new \DateTime('2021-01-01 00:00:00'));
        $this->assertIsString($category->getUpdatedAt());

        $this->assertTrue(\DateTime::createFromFormat('Y-m-d H:i:s', $category->getUpdatedAt()) !== false);
    }

    public function testCategoryUpdatedAtMustReturnADateStringWithFormatYMDHIS(){
        $category = new Category();
        $category->setUpdatedAt(new \DateTime('2021-01-01 00:00:00'));
        $this->assertEquals('2021-01-01 00:00:00', $category->getUpdatedAt());
    }

}
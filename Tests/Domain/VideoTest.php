<?php

namespace App\Tests\Domain;

use App\Models\Video;
use PHPUnit\Framework\TestCase;

class VideoTest extends TestCase{

    public function testVideoTitleMustBeAString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Title must be a string');
        $video = new Video();
        $video->setTitle(123);
    }

    public function testVideoTitleMustNotBeEmptyString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Title is required');
        $video = new Video();
        $video->setTitle('');
    }

    public function testVideoTitleMustNotBeANumericString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Title must be a string');
        $video = new Video();
        $video->setTitle('123');
    }

    public function testVideoTitleReceivingAStringMustWork(){
        $video = new Video();
        $video->setTitle('Video 1');
        $this->assertEquals('Video 1', $video->getTitle());
    }

    public function testVideoUrlMustBeAString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid URL');
        $video = new Video();
        $video->setUrl(123);
    }

    public function testVideoUrlMustNotBeEmptyString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid URL');
        $video = new Video();
        $video->setUrl('');
    }

    public function testVideoUrlMustNotBeANumericString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Invalid URL');
        $video = new Video();
        $video->setUrl('123');
    }

    public function testVideoUrlReceivingAValidUrlMustWork(){
        $video = new Video();
        $video->setUrl('https://www.youtube.com/watch?v=123');
        $this->assertEquals('https://www.youtube.com/watch?v=123', $video->getUrl());
    }

    public function testVideoDescriptionMustBeAString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Description must be a string');
        $video = new Video();
        $video->setDescription(123);
    }

    public function testVideoDescriptionMustNotBeEmptyString(){
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Description is required');
        $video = new Video();
        $video->setDescription('');
        
    }

    public function testVideoCreatedAtMustReturnADateString(){
        $video = new Video();
        $video->setCreatedAt(new \DateTime('2021-01-01 00:00:00'));
        $this->assertIsString($video->getCreatedAt());

        $this->assertTrue(\DateTime::createFromFormat('Y-m-d H:i:s', $video->getCreatedAt()) !== false);
    }

    public function testVideoCreatedAtMustReturnADateStringWithFormatYMDHIS(){
        $video = new Video();
        $video->setCreatedAt(new \DateTime('2021-01-01 00:00:00'));
        $this->assertEquals('2021-01-01 00:00:00', $video->getCreatedAt());
    }

    public function testVideoUpdatedAtMustReturnADateString(){
        $video = new Video();
        $video->setUpdatedAt(new \DateTime('2021-01-01 00:00:00'));
        $this->assertIsString($video->getUpdatedAt());

        $this->assertTrue(\DateTime::createFromFormat('Y-m-d H:i:s', $video->getUpdatedAt()) !== false);
    }

    public function testVideoUpdatedAtMustReturnADateStringWithFormatYMDHIS(){
        $video = new Video();
        $video->setUpdatedAt(new \DateTime('2021-01-01 00:00:00'));
        $this->assertEquals('2021-01-01 00:00:00', $video->getUpdatedAt());
    }

}
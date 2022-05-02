<?php

namespace App\Tests;

use App\Entity\Tag;
use App\Entity\Course;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class TagUnitTest extends TestCase
{
    public function testIsTrue(): void
    {
        $tag = new Tag();
        $course = new Course();
        $user = new User();

        $tag->setName('test')
            ->setSlug('test')
            ->addCourse($course)
            ->setUser($user);

        $this->assertTrue($tag->getName() === 'test');
        $this->assertTrue($tag->getSlug() === 'test');
        $this->assertTrue($tag->getCourses()->contains($course));
        $this->assertTrue($tag->getUser() === $user);
    }

    public function testIsFalse(): void
    {
        $tag = new Tag();
        $course = new Course();
        $user = new User();

        $tag->setName('test')
            ->setSlug('test')
            ->addCourse($course)
            ->setUser($user);

        $this->assertFalse($tag->getName() === 'test2');
        $this->assertFalse($tag->getSlug() === 'test2');
        $this->assertFalse($tag->getCourses()->contains(!$course));
        $this->assertFalse($tag->getUser() === !$user);
    }

    public function testIsEmpty(): void
    {
        $tag = new Tag();

        $this->assertEmpty($tag->getName());
        $this->assertEmpty($tag->getSlug());
        $this->assertEmpty($tag->getCourses());
        $this->assertEmpty($tag->getUser());
    }
}
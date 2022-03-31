<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Factory\CourseFactory;
use App\Factory\ImageFactory;
use App\Factory\TagFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        // Create some User with a special User will be an admin
        UserFactory::createOne([
            'email' => 'instructor@example.com',
            'roles' => ['ROLE_INSTRUCTOR'],
        ]);
        UserFactory::createOne([
            'email' => 'admin@example.com',
            'roles' => ['ROLE_ADMIN'],
        ]);
        UserFactory::createOne([
            'email' => 'user@example.com',
            'roles' => ['ROLE_USER'],
        ]);
        UserFactory::createMany(10);

        // Create one Tag with a special Tag will be a react / Miss you React <3
        $tags = TagFactory::createOne();

        // Create some Courses
        CourseFactory::createMany(10, [
            'user' => UserFactory::first(),
            'tags' => $tags,
        ]);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Factory\UserFactory;
use App\Factory\CourseFactory;
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
            'email' => 'admin@example.com',
            'roles' => ['ROLE_ADMIN'],
        ]);
        UserFactory::createOne([
            'email' => 'instructor@example.com',
            'roles' => ['ROLE_INSTRUCTOR'],
        ]);
        UserFactory::createOne([
            'email' => 'user@example.com',
            'roles' => ['ROLE_USER'],
        ]);
        UserFactory::createMany(10);

        // Create some Courses
        CourseFactory::createMany(10, [
            'user' => UserFactory::random(),
        ]);

        $manager->flush();
    }
}

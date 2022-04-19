<?php

namespace App\Factory;

use App\Entity\Course;
use App\Repository\CourseRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Course>
 *
 * @method static Course|Proxy createOne(array $attributes = [])
 * @method static Course[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Course|Proxy find(object|array|mixed $criteria)
 * @method static Course|Proxy findOrCreate(array $attributes)
 * @method static Course|Proxy first(string $sortedField = 'id')
 * @method static Course|Proxy last(string $sortedField = 'id')
 * @method static Course|Proxy random(array $attributes = [])
 * @method static Course|Proxy randomOrCreate(array $attributes = [])
 * @method static Course[]|Proxy[] all()
 * @method static Course[]|Proxy[] findBy(array $attributes)
 * @method static Course[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Course[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CourseRepository|RepositoryProxy repository()
 * @method Course|Proxy create(array|callable $attributes = [])
 */
final class CourseFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'title' => self::faker()->word(),
            'slug' => self::faker()->word(),
            'description' => self::faker()->text(),
            'createdAt' => new \DateTime('now'),
            'image' => ImageFactory::new(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Course $course): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Course::class;
    }
}

<?php

namespace App\Factory;

use App\Entity\Lesson;
use App\Repository\LessonRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Lesson>
 *
 * @method static Lesson|Proxy createOne(array $attributes = [])
 * @method static Lesson[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Lesson|Proxy find(object|array|mixed $criteria)
 * @method static Lesson|Proxy findOrCreate(array $attributes)
 * @method static Lesson|Proxy first(string $sortedField = 'id')
 * @method static Lesson|Proxy last(string $sortedField = 'id')
 * @method static Lesson|Proxy random(array $attributes = [])
 * @method static Lesson|Proxy randomOrCreate(array $attributes = [])
 * @method static Lesson[]|Proxy[] all()
 * @method static Lesson[]|Proxy[] findBy(array $attributes)
 * @method static Lesson[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Lesson[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LessonRepository|RepositoryProxy repository()
 * @method Lesson|Proxy create(array|callable $attributes = [])
 */
final class LessonFactory extends ModelFactory
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
            'video' => 'https://www.youtube.com/watch?v=TNhaISOUy6Q&ab_channel=Fireship',
            'explanation' => self::faker()->text(),
            'createdAt' => new \DateTime('now'),
            'slug' => self::faker()->word(),
            'isFinished' => false,
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Lesson $lesson): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Lesson::class;
    }
}

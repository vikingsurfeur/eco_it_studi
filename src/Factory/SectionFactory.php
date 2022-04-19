<?php

namespace App\Factory;

use App\Entity\Section;
use App\Repository\SectionRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Section>
 *
 * @method static Section|Proxy createOne(array $attributes = [])
 * @method static Section[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Section|Proxy find(object|array|mixed $criteria)
 * @method static Section|Proxy findOrCreate(array $attributes)
 * @method static Section|Proxy first(string $sortedField = 'id')
 * @method static Section|Proxy last(string $sortedField = 'id')
 * @method static Section|Proxy random(array $attributes = [])
 * @method static Section|Proxy randomOrCreate(array $attributes = [])
 * @method static Section[]|Proxy[] all()
 * @method static Section[]|Proxy[] findBy(array $attributes)
 * @method static Section[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Section[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static SectionRepository|RepositoryProxy repository()
 * @method Section|Proxy create(array|callable $attributes = [])
 */
final class SectionFactory extends ModelFactory
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
            'createdAt' => new \DateTime('now'),
//            'isFinished' => false,
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Section $section): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Section::class;
    }
}

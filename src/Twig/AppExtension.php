<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('actual_route', [$this, 'getActualRoute']),
        ];
    }

    public function getActualRoute(string $value, string $route): string
    {
        return $value === $route ? 'active' : '';
    }
}
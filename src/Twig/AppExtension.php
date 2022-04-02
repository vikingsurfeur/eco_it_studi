<?php

namespace App\Twig;

use App\Entity\User;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('actual_route', [$this, 'getActualRoute']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('truncateDescriptionCourse', [$this, 'truncateDescriptionCourse']),
            new TwigFilter('getPathImage', [$this, 'getPathImage']),
        ];
    }

    // Function
    public function getActualRoute(string $value, string $route): string
    {
        return $value === $route ? 'active' : '';
    }

    // Filter
    public function getPathImage(string $path): string
    {
        return '/uploads/images/'.$path;
    }

    public function truncateDescriptionCourse(string $description): string
    {
        return substr($description, 0, 75).'...';
    }
}
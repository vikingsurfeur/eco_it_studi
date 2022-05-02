<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PageControllerTest extends WebTestCase
{
    public function testRedirectToLoginFromCoursePage()
    {
        $client = static::createClient();
        $client->request('GET', '/course');

        $this->assertResponseRedirects('/login');
    }
}
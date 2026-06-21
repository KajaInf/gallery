<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TagControllerTest extends WebTestCase
{
    public function testTagIndexRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/tag');

        $this->assertResponseRedirects();
    }

    public function testTagNewRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/tag/new');

        $this->assertResponseRedirects();
    }
}

<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testUserIndexRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/user');

        $this->assertResponseRedirects();
    }
}

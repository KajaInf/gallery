<?php

/**
 * Profile controller test.
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class ProfileControllerTest.
 */
class ProfileControllerTest extends WebTestCase
{
    /**
     * Tests profile page redirect for anonymous user.
     *
     * @return void
     */
    public function testProfileRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/profile');

        $this->assertResponseRedirects();
    }
}

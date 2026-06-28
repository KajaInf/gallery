<?php

/**
 * Home controller test.
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class HomeControllerTest.
 */
class HomeControllerTest extends WebTestCase
{
    /**
     * Tests home page.
     *
     * @return void
     */
    public function testHomePageIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('body', 'Home');
    }
}

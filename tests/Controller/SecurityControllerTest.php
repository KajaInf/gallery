<?php

/**
 * Security controller test.
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class SecurityControllerTest.
 */
class SecurityControllerTest extends WebTestCase
{
    /**
     * Tests login page.
     *
     * @return void
     */
    public function testLoginPageIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('form');
    }
}

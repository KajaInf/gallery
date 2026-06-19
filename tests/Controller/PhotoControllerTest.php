<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PhotoControllerTest extends WebTestCase
{
    public function testPhotoIndexIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request('GET', '/photo');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Photo index');
    }

    public function testPhotoIndexWithTagFilterIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request('GET', '/photo?tag=1');

        $this->assertResponseIsSuccessful();
    }
}

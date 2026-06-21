<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GalleryControllerTest extends WebTestCase
{
    public function testGalleryIndexIsSuccessful(): void
    {
        $client = static::createClient();

        $client->request('GET', '/gallery');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('body');
    }

    public function testGalleryNewRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/gallery/new');

        $this->assertResponseRedirects();
    }
}

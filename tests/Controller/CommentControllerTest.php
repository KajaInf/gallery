<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CommentControllerTest extends WebTestCase
{
    public function testCommentIndexRedirectsAnonymousUser(): void
    {
        $client = static::createClient();

        $client->request('GET', '/comment');

        $this->assertResponseRedirects();
    }
}


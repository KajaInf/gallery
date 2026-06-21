<?php

namespace App\Tests\Form;

use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\Form\Test\TypeTestCase;

class CommentTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'content' => 'Test comment content',
        ];

        $comment = new Comment();

        $form = $this->factory->create(CommentType::class, $comment);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame('Test comment content', $comment->getContent());
    }
}

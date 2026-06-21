<?php

namespace App\Tests\Form;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Component\Form\Test\TypeTestCase;

class TagTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'name' => 'test',
        ];

        $tag = new Tag();

        $form = $this->factory->create(TagType::class, $tag);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame('test', $tag->getName());
    }
}

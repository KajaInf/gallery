<?php

/**
 * Tag type form test.
 */

namespace App\Tests\Form;

use App\Entity\Tag;
use App\Form\TagType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class TagTypeTest.
 */
class TagTypeTest extends TypeTestCase
{
    /**
     * Tests submitting valid form data.
     *
     * @return void
     */
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

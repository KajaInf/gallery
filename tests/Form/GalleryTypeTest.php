<?php

namespace App\Tests\Form;

use App\Entity\Gallery;
use App\Form\GalleryType;
use Symfony\Component\Form\Test\TypeTestCase;

class GalleryTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'title' => 'Test gallery',
        ];

        $gallery = new Gallery();

        $form = $this->factory->create(GalleryType::class, $gallery);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame('Test gallery', $gallery->getTitle());
    }
}

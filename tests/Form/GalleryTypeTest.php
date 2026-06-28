<?php

/**
 * Gallery type form test.
 */

namespace App\Tests\Form;

use App\Entity\Gallery;
use App\Form\GalleryType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class GalleryTypeTest.
 */
class GalleryTypeTest extends TypeTestCase
{
    /**
     * Tests submitting valid form data.
     *
     * @return void
     */
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

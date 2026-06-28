<?php

/**
 * Profile type form test.
 */

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\ProfileType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * Class ProfileTypeTest.
 */
class ProfileTypeTest extends TypeTestCase
{
    /**
     * Tests submitting valid form data.
     *
     * @return void
     */
    public function testSubmitValidData(): void
    {
        $formData = [
            'email' => 'profile-test@example.com',
        ];

        $user = new User();

        $form = $this->factory->create(ProfileType::class, $user);
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertSame('profile-test@example.com', $user->getEmail());
    }
}

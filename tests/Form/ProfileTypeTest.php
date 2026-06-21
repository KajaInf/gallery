<?php

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\ProfileType;
use Symfony\Component\Form\Test\TypeTestCase;

class ProfileTypeTest extends TypeTestCase
{
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

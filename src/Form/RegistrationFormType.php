<?php

/**
 * Registration form type.
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Class RegistrationFormType.
 */
class RegistrationFormType extends AbstractType
{
    /**
     * Builds registration form.
     *
     * @param FormBuilderInterface $builder Form builder
     * @param array                $options Form options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'label' => 'label.email',
            ])
        ->add('agreeTerms', CheckboxType::class, [
            'label' => 'label.agree_terms',
            'mapped' => false,
            'constraints' => [
            new IsTrue(
                message: 'registration.terms_required',
            ),
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
            'label' => 'label.password',
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
            new NotBlank(
                message: 'registration.password_required',
            ),
            new Length(
                min: 6,
                minMessage: 'registration.password_too_short',
                max: 4096,
            ),
            ],
        ]);
    }

    /**
     * Configures registration form options.
     *
     * @param OptionsResolver $resolver Options resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

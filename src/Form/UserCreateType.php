<?php

/**
 * User create form type.
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class UserCreateType.
 */
class UserCreateType extends AbstractType
{
    /**
     * Builds user create form.
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
        ->add('roles', ChoiceType::class, [
            'label' => 'label.roles',
            'choices' => [
            'role.user' => 'ROLE_USER',
            'role.admin' => 'ROLE_ADMIN',
            ],
            'choice_translation_domain' => 'messages',
            'multiple' => true,
            'expanded' => true,
        ])
        ->add('plainPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'mapped' => false,
            'required' => true,
            'first_options' => [
            'label' => 'label.password',
            ],
            'second_options' => [
            'label' => 'label.repeat_password',
            ],
        ]);
    }

    /**
     * Configures user create form options.
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

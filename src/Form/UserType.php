<?php

/**
 * Registration form File
 *
 * PHP Version 7.2
 *
 * @category Form
 * @package  Registration
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\IsTrue;

/**
 * Registration class UserType
 *
 * @category Form
 * @package  Registration
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName', TextType::class, [
                    'label' => 'First name',
                    'translation_domain' => 'messages',
                    'attr' => [
                        'minLength' => '2',
                        'maxLength' => '32'
                    ]
                ]
            )
            ->add(
                'lastName', TextType::class, [
                    'label' => 'Last name',
                    'translation_domain' => 'messages',
                    'attr' => [
                        'minLength' => '2',
                        'maxLength' => '32'
                    ]
                ]
            )
            ->add('email', EmailType::class)
            ->add(
                'plainPassword', RepeatedType::class, [
                    'type' => PasswordType::class,
                    'first_options'  => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                ]
            )
            ->add(
                'termsAccepted', CheckboxType::class, [
                    'mapped' => false,
                    'label' => 'Check accepted terms',
                    'translation_domain' => 'messages',
                    'constraints' => new IsTrue(),
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
            'data_class' => User::class,
            )
        );
    }
}
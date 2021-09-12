<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

/**
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class RegistrationFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'form.user.firstname.label',
                'attr' => ['placeholder' => 'form.user.firstname.placeholder', 'minLength' => '2', 'maxLength' => '32'],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'form.user.lastname.label',
                'attr' => ['placeholder' => 'form.user.lastname.placeholder', 'minLength' => '2', 'maxLength' => '32'],
            ])
            ->add('birthDate', DateType::class, [
                'label' => 'form.user.birthDate.label',
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'years' => range(date('Y'), date('Y') - 200),
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.user.email.label',
                'attr' => ['placeholder' => 'form.user.email.placeholder', 'maxLength' => '180'],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'form.user.password.invalid.message',
                'first_options'  => [
                    'label' => 'form.user.password.first.label',
                    'attr' => ['placeholder' => 'form.user.password.first.placeholder']
                ],
                'second_options' => [
                    'label' => 'form.user.password.second.label',
                    'attr' => ['placeholder' => 'form.user.password.second.placeholder']
                ],
            ])
            ->add('termsAccepted', CheckboxType::class, [
                'mapped' => false,
                'label' => 'form.user.terms.label',
                'constraints' => new IsTrue(),
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(['data_class' => User::class, 'translation_domain' => 'forms']);
    }
}

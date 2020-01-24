<?php

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
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class UserType extends AbstractType
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
            ->add('email', EmailType::class, [
                'label' => 'form.user.email.label',
                'attr' => ['placeholder' => 'form.user.email.placeholder', 'maxLength' => '64'],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'form.user.password.invalid.message',
                'first_options'  => ['attr' => ['placeholder' => 'form.user.password.first.placeholder']],
                'second_options' => ['attr' => ['placeholder' => 'form.user.password.second.placeholder']],
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

<?php

namespace App\Member\Application\Language\Form;

use App\Member\Application\Language\Model\LanguageFormModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LanguageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('languageName', TextType::class, ['label' => 'Language Name'])
            ->add('isActive', CheckboxType::class, ['label' => 'Active?', 'required' => false]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LanguageFormModel::class,
        ]);
    }
}

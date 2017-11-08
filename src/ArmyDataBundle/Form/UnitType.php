<?php

namespace ArmyDataBundle\Form;

use ArmyDataBundle\Entity\Army;
use ArmyDataBundle\Entity\Weapon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ArmyDataBundle\Entity\Unit;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class UnitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('name',TextType::class, array ('label' => 'unit.nam'))
        ->add('ha', ChoiceType::class, array ('choices' => range(0,10)))
            ->add('hp', ChoiceType::class, array ('choices' => range(0,10)))
            ->add('f', ChoiceType::class, array ('choices' => range(0,10)))
            ->add('r', ChoiceType::class, array ('choices' => range(0,10)))
            ->add('h', ChoiceType::class, array ('choices' => range(0,10)))
            ->add('i', ChoiceType::class, array ('choices' => range(0,10)))
            ->add('a', ChoiceType::class, array ('choices' => range(0,10)))
            ->add('l', ChoiceType::class, array ('choices' => range(0,10)))
            ->add('s', ChoiceType::class, array ('choices' => array(
                '1' => 1,
                '2' => 2,
                '3' => 3,
                '4' => 4,
                '5' => 5,
                '6' => 6)))
            ->add('army', 'Symfony\Bridge\Doctrine\Form\Type\EntityType', array(
                'required' => false,
                'class' => 'ArmyDataBundle\Entity\Army',
                'label' => 'army.nam'
            ))
            ->add('weapons',CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Weapon::class,

                ],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'allow_extra_fields' => true,
                'by_reference' => false,
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ArmyDataBundle\Entity\Unit',
        ));
    }

    public function getBlockPrefix()
    {
        return 'unit';
    }
}

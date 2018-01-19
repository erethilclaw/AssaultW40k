<?php

namespace ArmyDataBundle\Form;

use ArmyDataBundle\Entity\Army;
use ArmyDataBundle\Entity\Unit;
use ArmyDataBundle\Entity\Weapon;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class WeaponType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'weapon.nam'))
            ->add('distance', IntegerType::class, array('label' => 'weapon.ds'))
            ->add('f', ChoiceType::class, array('choices' => range(0, 10)))
            ->add('fp', ChoiceType::class, array('choices' => range(0, 10)))
            ->add('type', ChoiceType::class, array('choices' => array(
                'generic.choose'=> 'blank',
                'weapon.as' => 'Asalto',
                'weapon.ps' => 'Pesada',
                'weapon.rf' => 'Fuego Rapido',
                'weapon.ar' => 'Artilleria',
                ),'label'=> 'weapon.tp'
                ))
            ->add('shoots', IntegerType::class, array (
                'label'=> 'weapon.st'
                ))
            ->add('armies', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Army::class
                ],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'allow_extra_fields' => true,
                'by_reference' => false,
            ])
            ->add('units', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'class' => Unit::class
                ],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'allow_extra_fields' => true,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ArmyDataBundle\Entity\Weapon' ,
        ));
    }

    public function getBlockPrefix()
    {
        return 'weapon';
    }
}

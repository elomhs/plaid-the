<?php

namespace App\Form;

use App\Entity\Region;
use App\Entity\Room;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class RoomType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageName', TextType::class,  ['disabled' => true])
            ->add('imageFile', VichImageType::class, ['required' => false])
            ->add('summary')
            ->add('description')
            ->add('capacity')
            ->add('superficy')
            ->add('price')
            ->add('address')
            ->add("regions", EntityType::class, array(
               "class" => Region::class,
                "choice_label" => function($region, $key, $index) {
                   return $region->getName();
                },
                "multiple" => true,
                "expanded" => true,
            ));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Room::class,
        ]);
    }
}

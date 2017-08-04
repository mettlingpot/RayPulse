<?php

namespace MP\PlatformBundle\Form;
use MP\PlatformBundle\Entity\Adresse;
use MP\PlatformBundle\Form\AdresseType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('datedebut')
            ->add('datefin')
            ->add('title')
            ->add('author')
            ->add('site')
            ->add('prix')
            ->add('content')
            ->add('published')
            ->add('adresse',    AdresseType::class) 
            ->add('image',      ImageType::class) 
            ->add('categories', EntityType::class, array(
                'class'        => 'MPPlatformBundle:Category',
                'choice_label' => 'name',
                'multiple'     => true,
              ))
            ->add('save',      SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\PlatformBundle\Entity\Advert'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mp_platformbundle_advert';
    }


}

<?php

namespace MP\UserBundle\Form;

use MP\PlatformBundle\Entity\Adresse;
use MP\PlatformBundle\Form\AdresseType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username')
            ->add('password')
            ->add('email')
            ->add('adresse',    AdresseType::class) 
           ->add('favoris', EntityType::class, array(
                'class'        => 'MPPlatformBundle:Advert',
                'choice_label' => 'id',
                'multiple'     => true,
                'expanded'     => true,
              ))
            ->add('save',      SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mp_userbundle_user';
    }


}

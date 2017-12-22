<?php

namespace MP\PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class AdresseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder                
                ->add('adresse')                
                ->add('pays', HiddenType::class, array('data' => '',))
                ->add('departement', HiddenType::class, array('data' => '',))
                ->add('numero', HiddenType::class, array('data' => '',))
                ->add('rue', HiddenType::class, array('data' => '',))
                ->add('code', HiddenType::class, array('data' => '',))
                ->add('ville', HiddenType::class, array('data' => '',))                
                ->add('lat', HiddenType::class, array('data' => '',))                
                ->add('lng', HiddenType::class, array('data' => '',));

            //->add('save',      SubmitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MP\PlatformBundle\Entity\Adresse'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'mp_platformbundle_adresse';
    }


}

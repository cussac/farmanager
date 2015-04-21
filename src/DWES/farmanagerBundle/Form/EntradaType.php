<?php

namespace DWES\farmanagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EntradaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo','text', array(
                    'attr'=>array(
                        'class'=>'form-control input-lg',
                        'placeholder' => 'Introduce un título'
                    ))
            )
            ->add('contenido', 'textarea', array(
                    'attr'=>array(
                        'class'=>'form-control',
                    ))
            )
            ->add('file','file',array(
                'attr'  => array(
                    'placeholder'=>'Imagen entrada',
                    'class'=>'form-control input-lg',
                ),
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DWES\farmanagerBundle\Entity\Entrada'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dwes_farmanagerbundle_entrada';
    }
}

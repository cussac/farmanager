<?php

namespace DWES\farmanagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsuarioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username','text',array(
		        'label' => false,
		        'attr'  => array(
			        'placeholder'=>'Nombre de usuario',
			        'class'=>'form-control input-lg',
		        ),
	        ))
            ->add('password', 'repeated', array(
		        'label'          => false,
	            'type'           => 'password',
	            'invalid_message'=> 'Las contraseñas no coinciden',
	            'options'        => array('attr' => array('class' => 'password-field ', 'id'=>'password')),
	            'required'       => true,
	            'first_options'  => array(
		            'label' => false,
		            'attr' => array('placeholder'=>'Introduce tu contraseña', 'class'=>'form-control input-lg')
	            ),
	            'second_options' => array(
		            'label' => false,
		            'attr' => array('placeholder'=>'Repite tu contraseña', 'class'=>'form-control input-lg')
	            ),
            ))
            ->add('file','file',array(
                'label' => false,
                'attr'  => array(
                    'placeholder'=>'Foto de perfil',
                    'class'=>'form-control input-lg',
                ),
            ))
            ->add('captcha', 'captcha',array(
                  'label' => false,
                  'attr'  => array(
                    'placeholder'=>'Introduzca el captcha',
                    'class'=>'form-control input-lg',
                )))
            ->add('terms','checkbox',array(
                  'property_path' => 'termsAccepted'
                )
            );

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DWES\farmanagerBundle\Entity\Usuario'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dwes_framanagerbundle_usuario';
    }

    // The following function is what's important here.
    // This tells this form to use the "registration" validation group.
    public function getDefaultOptions(array $options)
    {
        return array(
            'validation_groups' => array('registration')
        );
    }
}

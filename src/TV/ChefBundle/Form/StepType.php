<?php

namespace TV\ChefBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StepType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class, array(
                    'label'=> 'Nom: '
                ))
                ->add('content', TextareaType::class, array(
                    'label'=> 'Contenu: ',
                    'label_attr' => array('class' => 'lab-content-step'),
                    'attr'=> array('class'=>'content-step')
                ))
                ->add('image', ImageType::class, array('required' => false))
                ->add('video', TextType::class, array('required'  => false,))
                ->add('timer', TimeType::class, array(
                    'required'  => false,
                    'widget' => 'text',
                    'input' => 'timestamp',
                    'with_seconds' => true,
                    ))
                ->add('save', SubmitType::class, array(
                    'attr' => array('class' => 'save'),
                ))   
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TV\ChefBundle\Entity\Step'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tv_chefbundle_step';
    }


}

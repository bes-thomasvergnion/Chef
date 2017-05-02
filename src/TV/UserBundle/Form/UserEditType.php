<?php

namespace TV\UserBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use TV\ChefBundle\Form\ImageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserEditType extends AbstractType
{ 
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('image', ImageType::class, array('required' => false))
            ->add('level', EntityType::class, array(
                    'class' => 'TVUserBundle:LevelUser',
                    'placeholder' => '--',
                    'required'  => true,
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->orderBy('u.id', 'ASC');
                    },
                    'choice_label' => 'name',
                ))
            ->add('content', TextareaType::class)
            ->add('save', SubmitType::class, array(
                    'attr' => array('class' => 'save, btn'),
            ))   
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TV\UserBundle\Entity\User'
        ));
    }
}

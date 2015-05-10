<?php

namespace Liuks\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Vardas'])
            ->add('surname', 'text', ['label' => 'Pavardė'])
            ->add('email', 'email', ['label' => 'El. paštas']);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Liuks\UserBundle\Entity\User'
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'liuks_userbundle_user';
    }
}

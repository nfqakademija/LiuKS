<?php

namespace Liuks\TableBundle\Form;

use Liuks\UserBundle\Form\GroupType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TableType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Pavadinimas'])
            ->add('address', 'text', ['label' => 'Adresas'])
            ->add('city', 'text', ['label' => 'Miestas'])
            ->add('lat', 'number', ['label' => 'Platuma'])
            ->add('long', 'number', ['label' => 'Ilguma'])
            ->add('availableFrom', 'time', ['label' => 'Dirba Nuo'])
            ->add('availableTo', 'time', ['label' => 'Dirba iki'])
            ->add('api', 'url', ['label' => 'API'])
            ->add(
                'private',
                'checkbox',
                [
                    'label' => 'Privatus?',
                    'attr' => ['class' => 'custom-checkbox', 'onclick' => 'groupToggle()'],
                    'required' => false
                ]
            )
            ->add('group', new GroupType(), ['label' => 'Grupė', 'required' => false]);
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Liuks\TableBundle\Entity\Table'
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'liuks_tablebundle_table';
    }
}

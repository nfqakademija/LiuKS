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
            ->add('address')
            ->add('city')
            ->add('lat')
            ->add('long')
            ->add('availableFrom')
            ->add('availableTo')
            ->add('api')
            ->add('disabled', null, ['required' => false, 'attr' => ['checked' => 'checked']])
            ->add('private', null, ['attr' => ['onclick' => 'groupToggle()'], 'required' => false])
            ->add('group', new GroupType(), ['required' => false]);
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

<?php

namespace Liuks\GameBundle\Form;

use Liuks\TableBundle\Entity\Table;
use Liuks\TableBundle\Form\Transformers\TimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TournamentType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', ['label' => 'Pavadinimas'])
            ->add(
                $builder->create('startTime', 'datetime', ['label' => 'Pradžios laikas'])
                    ->addModelTransformer(new TimeTransformer('Y-m-d H:i'))
            )
            ->add(
                'table',
                'entity',
                [
                    'label' => 'Stalas',
                    'class' => 'Liuks\TableBundle\Entity\Table',
                    'property' => 'address',
                    'empty_value' => 'Pasirinkite stalą',
                    //TODO: CREATE TableRepository and query only available tables
                    //                'query_builder' => function(Table $table) {
                    //                    if ($table->getDisabled() == false && $table->getPrivate() == false)
                    //                    {
                    //                        return $table;
                    //                    }
                    //                    return $table;
                    //                }
                ]
            )//TODO: add more options for tournament organizer
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => 'Liuks\GameBundle\Entity\Tournament'
            ]
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'liuks_gamebundle_tournament';
    }
}

<?php

namespace App\Form;

use App\Entity\Commande;
use App\Form\TicketType;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CommandeType extends AbstractType
{
    private $transformer;
    
    public function __construct(FrenchToDateTimeTransformer $transformer){
        $this->transformer = $transformer;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('VisitDay', TextType::class, ['label' => 'Jour de la visite :'])
            ->add('TicketType', ChoiceType::class, [
                'choices'  => [
                    'Journée' => 'j1',
                    'Demi-journée' => 'j2',
                ],
                'label' => 'Type de billet :'
            ])
            ->add('Email', EmailType::Class, ['label' => 'Votre adresse email :'])
            ->add('tickets', CollectionType::class, [
                'entry_type' => TicketType::class,
                'allow_add' => true
            ])
        ;

        $builder->get('VisitDay')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}

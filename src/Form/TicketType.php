<?php

namespace App\Form;

use App\Entity\Ticket;
use App\Form\DataTransformer\FrenchToDateTimeTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class TicketType extends AbstractType
{
    private $transformer;
    
    public function __construct(FrenchToDateTimeTransformer $transformer){
        $this->transformer = $transformer;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['attr' => [
                'placeholder' => "votre nom"
                ]])
            ->add('surname', TextType::class, ['attr' => [
                'placeholder' => "votre prénom"
                ]])
            ->add('birthday', TextType::class, ['attr' => [
                'placeholder' => "Date de naissance"
                ]])
            ->add('country', CountryType::class, ['label' => 'Votre Pays :'])
            ->add('reducedPrice', CheckboxType::class, ['label' => 'Prix réduit ?', 'required' => false, 'value' => 0])
        ;

        $builder->get('birthday')->addModelTransformer($this->transformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}

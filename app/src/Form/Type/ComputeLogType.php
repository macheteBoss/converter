<?php

namespace App\Form\Type;

use App\DBAL\Types\CurrencyType;
use App\DependencyInjection\Traits\EntityManagerInterfaceInjectionTrait;
use App\DTO\ComputeLogDTO;
use App\Entity\Rate;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ComputeLogType extends AbstractType
{
    use EntityManagerInterfaceInjectionTrait;

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('currencyFrom', ChoiceType::class, [
                'label' => 'Currency From',
                'choices' => CurrencyType::getChoices(),
                'mapped' => false,
            ])
            ->add('currencyTo', ChoiceType::class, [
                'label' => 'Currency To',
                'choices' => CurrencyType::getChoices(),
                'mapped' => false,
            ])
            ->add('sum', null, [
                'label' => 'Sum',
            ])
        ;

        $builder->addEventListener(FormEvents::SUBMIT, [$this, 'submit']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class'         => ComputeLogDTO::class,
            'csrf_protection'    => false,
            'allow_extra_fields' => true,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'calculate';
    }

    /**
     * @param FormEvent $event
     */
    public function submit(FormEvent $event): void
    {
        $this->modifyForm($event->getForm());

        /** @var ComputeLogDTO $data */
        $data = $event->getData();
        $data->setRate($event->getForm()->get('rate')->getData());
        $event->setData($data);
    }

    /**
     * @param FormInterface $form
     */
    protected function modifyForm(FormInterface $form): void
    {
        $form
            ->add('rate', EntityType::class, [
                'class'         => Rate::class,
                'query_builder' => $this->createRateQB(),
            ])
        ;

        $currencyFrom = $form->get('currencyFrom')->getViewData();
        $currencyTo   = $form->get('currencyTo')->getViewData();

        /** @var Rate|null $rate */
        $rate = $this->em->getRepository(Rate::class)->findOneBy(['currencyFrom' => $currencyFrom, 'currencyTo' => $currencyTo]);

        $form->get('rate')->setData($rate);
    }

    /**
     * @return QueryBuilder
     */
    public function createRateQB(): QueryBuilder
    {
        return $this->em
            ->getRepository(Rate::class)
            ->createQueryBuilder('r')
        ;
    }
}
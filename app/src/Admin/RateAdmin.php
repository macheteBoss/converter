<?php

namespace App\Admin;

use App\Entity\Rate;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

class RateAdmin extends AbstractAdmin
{
    /**
     * {}
     */
    protected function configureRoutes(RouteCollectionInterface $collection): void
    {
        parent::configureRoutes($collection);

        $collection->remove('create');
        $collection->remove('edit');
        $collection->remove('delete');
    }

    public function toString(object $object): string
    {
        return $object instanceof Rate
            ? $object->getCurrencyFrom() . ' => ' . $object->getCurrencyTo()
            : 'Rate';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('currencyFrom');
        $list->addIdentifier('currencyTo');
        $list->addIdentifier('value');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('currencyFrom');
        $show->add('currencyTo');
        $show->add('value');
    }
}
<?php

namespace App\Admin;

use App\Entity\ComputeLog;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollectionInterface;

class ComputeLogAdmin extends AbstractAdmin
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
        return $object instanceof ComputeLog
            ? $object->getRate()->getCurrencyFrom() . ' => ' . $object->getRate()->getCurrencyTo()
            : 'Compute log';
    }

    /**
     * {@inheritdoc}
     */
    protected function configureListFields(ListMapper $list): void
    {
        $list->addIdentifier('date');
        $list->add('rate');
        $list->add('sum');
        $list->add('result');
    }

    /**
     * {@inheritdoc}
     */
    protected function configureShowFields(ShowMapper $show): void
    {
        $show->add('date');
        $show->add('rate');
        $show->add('sum');
        $show->add('result');
    }
}
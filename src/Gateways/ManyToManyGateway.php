<?php namespace Jmkim\EntrustGui\Gateways;

use Prettus\Repository\Eloquent\BaseRepository;
use Jmkim\EntrustGui\Traits\PaginationGatewayTrait;
use Jmkim\EntrustGui\Traits\DeleteModelTrait;
use Jmkim\EntrustGui\Traits\FindModelTrait;
use Illuminate\Config\Repository as Config;
use Illuminate\Events\Dispatcher;

/**
 * This file is part of Entrust GUI,
 * A Laravel 5 GUI for Entrust.
 *
 * @license MIT
 * @package Jmkim\EntrustGui
 */
abstract class ManyToManyGateway
{

    use PaginationGatewayTrait, FindModelTrait, DeleteModelTrait;

    protected $repository;
    protected $config;
    protected $dispatcher;

    /**
     * Create a new gateway instance.
     *
     * @param Config $config
     * @param Repository $repository
     * @param Dispatcher $dispatcher
     *
     * @return void
     */
    public function __construct(Config $config, BaseRepository $repository, Dispatcher $dispatcher)
    {
        $this->config = $config;
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * Create a model
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($request)
    {
        $model = $this->repository->create($request->all());
        $model->{$this->getShortRelationName()}()->sync($request->get($this->getRelationName(), []));
        $event_class = "Jmkim\EntrustGui\Events\\".ucwords($this->getModelName()).'CreatedEvent';
        $event = new $event_class;
        $this->dispatcher->dispatch($event->setModel($model));
        return $model;
    }

    /**
     * Find model by ID
     *
     * @param integer $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        return $this->repository->with($this->getShortRelationName())->find($id);
    }

    /**
     * Update model
     *
     * @param Illuminate\Http\Request $request
     * @param integer $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($request, $id)
    {
        $model = $this->repository->update($request->all(), $id);
        $event_class = "Jmkim\EntrustGui\Events\\".ucwords($this->getModelName()).'UpdatedEvent';
        $event = new $event_class;
        $this->dispatcher->dispatch($event->setModel($model));
        return $model;
    }
}

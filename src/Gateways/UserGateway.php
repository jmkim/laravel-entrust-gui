<?php namespace Jmkim\EntrustGui\Gateways;

use Jmkim\EntrustGui\Repositories\UserRepository;
use Jmkim\EntrustGui\Events\UserCreatedEvent;
use Jmkim\EntrustGui\Events\UserUpdatedEvent;
use Jmkim\EntrustGui\Events\UserDeletedEvent;
use Jmkim\EntrustGui\Traits\DeleteModelTrait;
use Jmkim\EntrustGui\Traits\FindModelTrait;
use Jmkim\EntrustGui\Traits\GetPermissionUserRelationNameTrait;
use Jmkim\EntrustGui\Traits\PaginationGatewayTrait;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Config\Repository as Config;
use Illuminate\Events\Dispatcher;

/**
 * This file is part of Entrust GUI,
 * A Laravel 5 GUI for Entrust.
 *
 * @license MIT
 * @package Jmkim\EntrustGui
 */
class UserGateway implements ManyToManyGatewayInterface
{

    use PaginationGatewayTrait, FindModelTrait, DeleteModelTrait, GetPermissionUserRelationNameTrait;

    protected $repository;
    protected $role;
    protected $config;
    protected $dispatcher;
    protected $hash;

    /**
     * Create a new gateway instance.
     *
     * @param Config $config
     * @param UserRepository $permission_repository
     * @param Dispatcher $dispatcher
     * @param Hasher $hash
     *
     * @return void
     */
    public function __construct(Config $config, UserRepository $repository, Dispatcher $dispatcher, Hasher $hash)
    {
        $this->config = $config;
        $this->repository = $repository;
        $role_class = $this->config->get('entrust.role');
        $this->role = new $role_class;
        $this->dispatcher = $dispatcher;
        $this->hash = $hash;
    }

    /**
     * Create a user
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function create($request)
    {
        $data = $request->all();
        $user = $this->repository->create($data);

        $event_class = "Jmkim\EntrustGui\Events\\".ucwords($this->getModelName()).'CreatedEvent';
        $event = new $event_class;
        $this->dispatcher->dispatch($event->setModel($user));
        return $user;
    }

    /**
     * Update user
     *
     * @param Illuminate\Http\Request $request
     * @param integer $id
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function update($request, $id)
    {
        $data = $request->except('password', 'password_confirmation');
        if ($request->has('password') && $request->get('password') !== null) {
            $data['password'] = $request->get('password');
            $data['password_confirmation'] = $request->get('password_confirmation');
        }
        $user = $this->repository->update($data, $id);
        $event_class = "Jmkim\EntrustGui\Events\\".ucwords($this->getModelName()).'UpdatedEvent';
        $event = new $event_class;
        $this->dispatcher->dispatch($event->setModel($user));
        return $user;
    }

    /**
     * Return model name
     *
     *
     * @return string
     */
    public function getModelName()
    {
        return 'user';
    }

    /**
     * Paginate models
     *
     * @param integer $take
     *
     * @return Illuminate\Database\Eloquent\Collection
     */
    public function paginate($take = 5, $search = "")
    {
	    $search = trim($search);
	    return $this->repository->scopeQuery(function($query) use ($search) {
		    return ($search != "") ? $query->where('email', 'LIKE', '%'.$search.'%')->orWhere('name', 'LIKE', '%'.$search.'%') : $query;
	    })->paginate($take);
    }
}

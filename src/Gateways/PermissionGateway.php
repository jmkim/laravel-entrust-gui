<?php namespace Jmkim\EntrustGui\Gateways;

use Jmkim\EntrustGui\Repositories\PermissionRepository;
use Jmkim\EntrustGui\Traits\GetPermissionModelNameTrait;
use Jmkim\EntrustGui\Traits\GetPermissionUserRelationNameTrait;
use Illuminate\Config\Repository as Config;
use Illuminate\Events\Dispatcher;

/**
 * This file is part of Entrust GUI,
 * A Laravel 5 GUI for Entrust.
 *
 * @license MIT
 * @package Jmkim\EntrustGui
 */
class PermissionGateway extends ManyToManyGateway implements ManyToManyGatewayInterface
{

    use GetPermissionModelNameTrait, GetPermissionUserRelationNameTrait;

    /**
     * Create a new gateway instance.
     *
     * @param Config $config
     * @param PermissionRepository $repository
     * @param Dispatcher $dispatcher
     *
     * @return void
     */
    public function __construct(Config $config, PermissionRepository $repository, Dispatcher $dispatcher)
    {
        parent::__construct($config, $repository, $dispatcher);
    }
}

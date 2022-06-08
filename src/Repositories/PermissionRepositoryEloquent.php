<?php

namespace Jmkim\EntrustGui\Repositories;

use Jmkim\EntrustGui\Traits\GetPermissionModelNameTrait;
use Jmkim\EntrustGui\Traits\GetPermissionUserRelationNameTrait;

/**
 * This file is part of Entrust GUI,
 * A Laravel 5 GUI for Entrust.
 *
 * @license MIT
 * @package Jmkim\EntrustGui
 */
class PermissionRepositoryEloquent extends ManyToManyRepositoryEloquent implements PermissionRepository
{

    use GetPermissionModelNameTrait, GetPermissionUserRelationNameTrait;
}

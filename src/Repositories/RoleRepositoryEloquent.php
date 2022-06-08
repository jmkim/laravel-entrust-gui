<?php

namespace Jmkim\EntrustGui\Repositories;

use Jmkim\EntrustGui\Traits\GetRoleModelNameTrait;
use Jmkim\EntrustGui\Traits\GetRoleRelationNameTrait;

/**
 * This file is part of Entrust GUI,
 * A Laravel 5 GUI for Entrust.
 *
 * @license MIT
 * @package Jmkim\EntrustGui
 */
class RoleRepositoryEloquent extends ManyToManyRepositoryEloquent implements RoleRepository
{

    use GetRoleModelNameTrait, GetRoleRelationNameTrait;
}

<?php namespace Jmkim\EntrustGui\Models;

use Esensi\Model\Contracts\ValidatingModelInterface;
use Esensi\Model\Traits\ValidatingModelTrait;
use Shanmuga\Entrust\EntrustPermission;

class Permission extends EntrustPermission implements ValidatingModelInterface
{
    use ValidatingModelTrait;

    protected $throwValidationExceptions = true;

    protected $fillable = [
    'name',
    'display_name',
    'description',
    ];

    protected $rules = [
    'name'      => 'required|unique:permissions',
    ];
}

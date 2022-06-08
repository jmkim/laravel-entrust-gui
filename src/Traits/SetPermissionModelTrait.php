<?php namespace Jmkim\EntrustGui\Traits;

trait SetPermissionModelTrait
{

    public $permission;

    /**
     * Create a new event instance.
     *
     * @param $permission
     *
     * @return void
     */
    public function setModel($model)
    {
        $this->permission = $model;
        return $this;
    }
}

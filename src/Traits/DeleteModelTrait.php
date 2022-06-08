<?php namespace Jmkim\EntrustGui\Traits;

trait DeleteModelTrait
{

    /**
     * Delete model
     *
     * @param integer $id
     *
     * @return void
     */
    public function delete($id)
    {
        $model = $this->repository->find($id);
        $this->repository->delete($id);
        $event_class = "Jmkim\EntrustGui\Events\\".ucwords($this->getModelName()).'DeletedEvent';
        $event = new $event_class;
        $this->dispatcher->dispatch($event->setModel($model));
    }
}

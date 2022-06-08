<?php namespace Jmkim\EntrustGui\Events;

use Jmkim\EntrustGui\Traits\SetRoleModelTrait;
use App\Events\Event;
use Illuminate\Queue\SerializesModels;

/**
 * This file is part of Entrust GUI,
 * A Laravel 5 GUI for Entrust.
 *
 * @license MIT
 * @package Jmkim\EntrustGui
 */
class RoleUpdatedEvent implements EventInterface
{

    use SerializesModels, SetRoleModelTrait;
}

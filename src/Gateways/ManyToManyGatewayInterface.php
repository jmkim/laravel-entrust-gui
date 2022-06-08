<?php namespace Jmkim\EntrustGui\Gateways;

interface ManyToManyGatewayInterface
{
  
    public function getModelName();

    public function getRelationName();

    public function getShortRelationName();
}

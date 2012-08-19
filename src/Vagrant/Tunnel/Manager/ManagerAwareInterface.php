<?php

namespace Vagrant\Tunnel\Manager;

interface ManagerAwareInterface
{
    public function setManager(TunnelManager $manager);
}

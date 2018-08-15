<?php

namespace DM20Client;


use DM20Client\PacketListener\CommandSocketConnectListener;
use DM20Client\PacketListener\StatusPacketListener;
use DM20Client\Socket\Connection;
use React\EventLoop\LoopInterface;

class Kernel
{
    /**
     * @var LoopInterface
     */
    private $loop;

    /**
     * @var Connection
     */
    private $statusConnection;

    /**
     * @var Connection
     */
    private $commandConnection;

    /**
     * Kernel constructor.
     * @param LoopInterface $loop
     */
    public function __construct(LoopInterface $loop)
    {
        pcntl_signal(SIGINT, [$this, 'shutdown']);
        pcntl_signal(SIGTERM, [$this, 'shutdown']);

        $this->loop = $loop;
        $this->statusConnection = new Connection($loop, '127.0.0.1', 6400);
        $this->commandConnection = new Connection($loop, '127.0.0.1', 6401);

        $this->statusConnection->registerPacketListener(new StatusPacketListener());
        $this->commandConnection->registerPacketListener(new CommandSocketConnectListener());

        $this->commandConnection->connect();
        $this->statusConnection->connect();
    }

    public function shutdown()
    {
        $this->commandConnection->end();
        $this->statusConnection->end();
    }

}
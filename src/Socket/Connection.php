<?php

namespace DM20Client\Socket;

use React\EventLoop\LoopInterface;
use React\Socket\ConnectionInterface;
use React\Socket\Connector;
use React\Socket\ConnectorInterface;

class Connection
{
    /**
     * @var string
     */
    protected $address;

    /**
     * @var int
     */
    protected $port;

    /**
     * @var ConnectorInterface
     */
    protected $connector;

    /**
     * @var PacketListenerInterface[]
     */
    protected $packetListener;

    /**
     * @var ConnectionInterface|null
     */
    protected $connection;

    /**
     * Connection constructor.
     * @param LoopInterface $loop
     * @param string $address
     * @param int $port
     * @param bool $directConnect
     * @param array $packetListener
     */
    public function __construct(LoopInterface $loop, string $address, int $port, bool $directConnect = false, array $packetListener = [])
    {
        $this->address = $address;
        $this->port = $port;
        $this->packetListener = $packetListener;

        $this->connector = new Connector($loop);

        if ($directConnect) {
            $this->connect();
        }
    }

    public function connect()
    {
        $this->connector->connect($this->address . ':' . $this->port)->then(function (ConnectionInterface $connection) {
            $this->onConnect($connection);
        });
    }

    protected function onConnect(ConnectionInterface $connection)
    {
        $this->connection = $connection;

        foreach ($this->packetListener as $packetListener) {
            $packetListener->onConnect($this);
        }

        $this->connection->on('data', function ($data) {
            foreach ($this->packetListener as $packetListener) {
                $packetListener->onData($this, new ByteBuf($data));
            }
        });
    }

    protected function onData($data)
    {
        foreach ($this->packetListener as $packetListener) {
            $packetListener->onData($this, new ByteBuf($data));
        }
    }


    public function registerPacketListener(PacketListenerInterface $packetListener)
    {
        $this->packetListener[] = $packetListener;
    }

    public function write(ByteBuf $byteBuf)
    {
        $this->connection->write($byteBuf);
    }

    public function disconnect()
    {
        $this->connection->close();
    }

    public function end()
    {
        $this->connection->end();
    }
}
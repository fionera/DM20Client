<?php

namespace DM20Client\Socket;

abstract class AbstractPacketListener implements PacketListenerInterface
{
    public function onConnect(Connection $connection)
    {
    }

    public function onData(Connection $connection, ByteBuf $byteBuf)
    {
    }
}


<?php

namespace DM20Client\Socket;

interface PacketListenerInterface
{
    public function onConnect(Connection $connection);

    public function onData(Connection $connection, ByteBuf $byteBuf);
}
<?php

namespace DM20Client\PacketListener;

use DM20Client\Socket\AbstractPacketListener;
use DM20Client\Socket\ByteBuf;
use DM20Client\Socket\Connection;

class StatusPacketListener extends AbstractPacketListener
{
    public function onData(Connection $connection, ByteBuf $byteBuf)
    {
        echo 'Got Status Packet' . PHP_EOL;
    }

}

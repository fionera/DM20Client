<?php

namespace DM20Client\PacketListener;

use DM20Client\Socket\AbstractPacketListener;
use DM20Client\Socket\Connection;

class CommandSocketConnectListener extends AbstractPacketListener
{
    public function onConnect(Connection $connection)
    {
//        $byteBuf = new ByteBuf();
//
//        $byteBuf->writeInt(90);
//        $byteBuf->writeInt(90);
//        $byteBuf->writeInt(90);
//        $byteBuf->writeInt(90);
//        $byteBuf->writeInt(90);
//        $byteBuf->writeInt(90);
//        $byteBuf->writeInt(1);
//        $byteBuf->writeInt(0);
//
//        $connection->write($byteBuf);
    }
}

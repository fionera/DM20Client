<?php

use DM20Client\Socket\ByteBuf;
use PHPUnit\Framework\TestCase;

class ByteBufTest extends TestCase
{

    public function testConstruct()
    {
        $byteBuf = new ByteBuf();
        $this->assertEmpty($byteBuf->getRawData());

        $byteBuf2 = new ByteBuf('');
        $this->assertEmpty($byteBuf2->getRawData());

        $this->assertEquals($byteBuf, $byteBuf2);
    }

    public function testWriteInt()
    {
        $byteBuf = new ByteBuf();

        $int = random_int(1, 100);
        $int2 = random_int(1, 100);

        $byteBuf->writeInt($int);
        $byteBuf->writeInt($int2);

        $this->assertEquals($byteBuf->readInt(), $int);
        $this->assertEquals($byteBuf->readInt(), $int2);
    }

    public function testReadInt()
    {
        $byteBuf = new ByteBuf(hex2bin('00000001'));

        $this->assertEquals($byteBuf->readInt(), 1);
    }
}

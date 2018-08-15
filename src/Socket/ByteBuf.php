<?php

namespace DM20Client\Socket;

class ByteBuf
{
    /**
     * @var string[]
     */
    private $rawData = [];

    /**
     * ByteBuf constructor.
     * @param string $data
     */
    public function __construct(string $data = null)
    {
        if ($data !== null) {
            $hex = bin2hex($data);

            $nibbles = str_split($hex);

            $this->rawData = array_filter($nibbles, function ($nibble) {
                return $nibble !== '';
            });
        }
    }

    /**
     * @return int
     * @throws \Exception
     */
    public function readInt(): int
    {
        $binary = hex2bin(implode($this->getBytes(4)));

        return unpack('N', $binary)[1];
    }

    public function writeInt(int $int): self
    {
        $binary = pack('N', $int);

        $this->writeBytes(bin2hex($binary));

        return $this;
    }

    private function hasEnoughtBytes(int $bytes): bool
    {
        return \count($this->rawData) >= $bytes * 2;
    }

    /**
     * @param string $bytes Hexadecimal Bytes
     */
    private function writeBytes(string $bytes): void
    {
        foreach (str_split($bytes) as $nibble) {
            $this->rawData[] = $nibble;
        }
    }

    private function getBytes(int $bytes): array
    {
        if ($this->hasEnoughtBytes($bytes)) {
            $fetchedBytes = [];
            for ($i = 0; $i < $bytes * 2; $i++) {
                $fetchedBytes[] = array_shift($this->rawData);
            }

            return $fetchedBytes;
        }

        throw new \Exception();
    }

    /**
     * @return string[]
     */
    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function __toString()
    {
        return hex2bin(implode($this->rawData));
    }
}
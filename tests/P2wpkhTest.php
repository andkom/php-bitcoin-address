<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class P2wpkhTest extends TestCase
{
    protected function getOutput(): OutputInterface
    {
        return OutputFactory::p2wpkh(hex2bin('751e76e8199196d454941c45d1b3a323f1433bd6'));
    }

    public function testHex()
    {
        $this->assertEquals('0014751e76e8199196d454941c45d1b3a323f1433bd6', $this->getOutput()->hex());
    }

    public function testAsm()
    {
        $this->assertEquals('0 PUSHDATA(20)[751e76e8199196d454941c45d1b3a323f1433bd6]', $this->getOutput()->asm());
    }

    public function testAddress()
    {
        $this->assertEquals('bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t4', $this->getOutput()->address());
        $this->assertEquals('tb1qw508d6qejxtdg4y5r3zarvary0c5xw7kxpjzsx', $this->getOutput()->address(NetworkFactory::bitcoinTest()));
        $this->assertEquals('tb1qw508d6qejxtdg4y5r3zarvary0c5xw7kxpjzsx', $this->getOutput()->address(NetworkFactory::bitcoinRegtest()));
    }
}
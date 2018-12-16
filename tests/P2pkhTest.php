<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class P2pkhTest extends TestCase
{
    protected function getOutput(): OutputInterface
    {
        return OutputFactory::p2pkh(hex2bin('751e76e8199196d454941c45d1b3a323f1433bd6'));
    }

    public function testHex()
    {
        $this->assertEquals('76a914751e76e8199196d454941c45d1b3a323f1433bd688ac', $this->getOutput()->hex());
    }

    public function testAsm()
    {
        $this->assertEquals('DUP HASH160 PUSHDATA(20)[751e76e8199196d454941c45d1b3a323f1433bd6] EQUALVERIFY CHECKSIG', $this->getOutput()->asm());
    }

    public function testAddress()
    {
        $this->assertEquals('1BgGZ9tcN4rm9KBzDn7KprQz87SZ26SAMH', $this->getOutput()->address());
        $this->assertEquals('mrCDrCybB6J1vRfbwM5hemdJz73FwDBC8r', $this->getOutput()->address(NetworkFactory::bitcoinTest()));
        $this->assertEquals('mrCDrCybB6J1vRfbwM5hemdJz73FwDBC8r', $this->getOutput()->address(NetworkFactory::bitcoinRegtest()));
    }
}
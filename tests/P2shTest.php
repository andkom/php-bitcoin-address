<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class P2shTest extends TestCase
{
    protected function getOutput(): OutputInterface
    {
        $factory = new OutputFactory();
        $p2ms = $factory->p2ms(1, [hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798')]);
        return $factory->p2sh($p2ms);
    }

    public function testHex()
    {
        $this->assertEquals('a91483eebb7d79aa1d388e3b0ac65b98ac580c4da01a87', $this->getOutput()->hex());
    }

    public function testAsm()
    {
        $this->assertEquals('HASH160 PUSHDATA(20)[83eebb7d79aa1d388e3b0ac65b98ac580c4da01a] EQUAL', $this->getOutput()->asm());
    }

    public function testAddress()
    {
        $this->assertEquals('3DicS6C8JZm59RsrgXr56iVHzYdQngiehV', $this->getOutput()->address());
        $this->assertEquals('2N5GpVq89v2GRMDWQMfTwifUZCtqaczC6Y7', $this->getOutput()->address(NetworkFactory::bitcoinTest()));
        $this->assertEquals('2N5GpVq89v2GRMDWQMfTwifUZCtqaczC6Y7', $this->getOutput()->address(NetworkFactory::bitcoinRegtest()));
    }
}
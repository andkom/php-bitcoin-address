<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2tr;
use AndKom\Bitcoin\Address\Taproot;
use PHPUnit\Framework\TestCase;

/**
 * Class P2trTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class P2trTest extends TestCase
{
    /**
     * @return OutputInterface
     * @throws Exception
     */
    protected function getOutput(): OutputInterface
    {
        $taprootPubKey = Taproot::construct(
            hex2bin('03cc8a4bc64d897bddc5fbc2f670f7a8ba0b386779106cf1223c6fc5d7cd6fc115')
        );
        return OutputFactory::p2tr($taprootPubKey);
    }

    /**
     * @throws Exception
     */
    public function testHex(): void
    {
        $this->assertEquals(
            '5120a60869f0dbcf1dc659c9cecbaf8050135ea9e8cdc487053f1dc6880949dc684c',
            $this->getOutput()->hex()
        );
    }

    /**
     * @throws Exception
     */
    public function testAsm(): void
    {
        $this->assertEquals(
            '1 PUSHDATA(32)[a60869f0dbcf1dc659c9cecbaf8050135ea9e8cdc487053f1dc6880949dc684c]',
            $this->getOutput()->asm()
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoin(): void
    {
        $this->assertEquals(
            'bc1p5cyxnuxmeuwuvkwfem96lqzszd02n6xdcjrs20cac6yqjjwudpxqkedrcr',
            $this->getOutput()->address()
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoinTestnet(): void
    {
        $this->assertEquals(
            'tb1p5cyxnuxmeuwuvkwfem96lqzszd02n6xdcjrs20cac6yqjjwudpxqp3mvzv',
            $this->getOutput()->address(NetworkFactory::bitcoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoin(): void
    {
        $this->assertEquals(
            'ltc1p5cyxnuxmeuwuvkwfem96lqzszd02n6xdcjrs20cac6yqjjwudpxq4arnzx',
            $this->getOutput()->address(NetworkFactory::litecoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoinTestnet(): void
    {
        $this->assertEquals(
            'tltc1p5cyxnuxmeuwuvkwfem96lqzszd02n6xdcjrs20cac6yqjjwudpxq7j8dan',
            $this->getOutput()->address(NetworkFactory::litecoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testFromScript(): void
    {
        $output = $this->getOutput();
        $this->assertEquals($output->script(), P2tr::fromScript($output->script())->script());
    }
}

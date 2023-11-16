<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2wpkh;
use PHPUnit\Framework\TestCase;

/**
 * Class P2wpkhTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class P2wpkhTest extends TestCase
{
    /**
     * @return OutputInterface
     * @throws Exception
     */
    protected function getOutput(): OutputInterface
    {
        return OutputFactory::p2wpkh(hex2bin('751e76e8199196d454941c45d1b3a323f1433bd6') ?: '');
    }

    /**
     * @throws Exception
     */
    public function testHex(): void
    {
        $this->assertEquals(
            '0014751e76e8199196d454941c45d1b3a323f1433bd6',
            $this->getOutput()->hex()
        );
    }

    /**
     * @throws Exception
     */
    public function testAsm(): void
    {
        $this->assertEquals(
            '0 PUSHDATA(20)[751e76e8199196d454941c45d1b3a323f1433bd6]',
            $this->getOutput()->asm()
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoin(): void
    {
        $this->assertEquals(
            'bc1qw508d6qejxtdg4y5r3zarvary0c5xw7kv8f3t4',
            $this->getOutput()->address()
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoinTestnet(): void
    {
        $this->assertEquals(
            'tb1qw508d6qejxtdg4y5r3zarvary0c5xw7kxpjzsx',
            $this->getOutput()->address(NetworkFactory::bitcoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoin(): void
    {
        $this->assertEquals(
            'ltc1qw508d6qejxtdg4y5r3zarvary0c5xw7kgmn4n9',
            $this->getOutput()->address(NetworkFactory::litecoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoinTestnet(): void
    {
        $this->assertEquals(
            'tltc1qw508d6qejxtdg4y5r3zarvary0c5xw7klfsuq0',
            $this->getOutput()->address(NetworkFactory::litecoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressViacoin(): void
    {
        $this->assertEquals(
            'via1qw508d6qejxtdg4y5r3zarvary0c5xw7kxzdzsn',
            $this->getOutput()->address(NetworkFactory::viacoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressViacoinTestnet(): void
    {
        $this->assertEquals(
            'tvia1qw508d6qejxtdg4y5r3zarvary0c5xw7k3swtre',
            $this->getOutput()->address(NetworkFactory::viacoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testFromScript(): void
    {
        $output = $this->getOutput();
        $this->assertEquals($output->script(), P2wpkh::fromScript($output->script())->script());
    }
}

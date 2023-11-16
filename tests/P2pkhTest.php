<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use PHPUnit\Framework\TestCase;

/**
 * Class P2pkhTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class P2pkhTest extends TestCase
{
    /**
     * @return OutputInterface
     * @throws Exception
     */
    protected function getOutput(): OutputInterface
    {
        return OutputFactory::p2pkh(hex2bin('751e76e8199196d454941c45d1b3a323f1433bd6') ?: '');
    }

    /**
     * @throws Exception
     */
    public function testHex(): void
    {
        $this->assertEquals(
            '76a914751e76e8199196d454941c45d1b3a323f1433bd688ac',
            $this->getOutput()->hex()
        );
    }

    /**
     * @throws Exception
     */
    public function testAsm(): void
    {
        $this->assertEquals(
            'DUP HASH160 PUSHDATA(20)[751e76e8199196d454941c45d1b3a323f1433bd6] EQUALVERIFY CHECKSIG',
            $this->getOutput()->asm()
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoin(): void
    {
        $this->assertEquals(
            '1BgGZ9tcN4rm9KBzDn7KprQz87SZ26SAMH',
            $this->getOutput()->address()
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoinTestnet(): void
    {
        $this->assertEquals(
            'mrCDrCybB6J1vRfbwM5hemdJz73FwDBC8r',
            $this->getOutput()->address(NetworkFactory::bitcoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoinCash(): void
    {
        $this->assertEquals(
            'bitcoincash:qp63uahgrxged4z5jswyt5dn5v3lzsem6cy4spdc2h',
            $this->getOutput()->address(NetworkFactory::bitcoinCash())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoinGold(): void
    {
        $this->assertEquals(
            'GUXByHDZLvU4DnVH9imSFckt3HEQ5cFgE5',
            $this->getOutput()->address(NetworkFactory::bitcoinGold())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoin(): void
    {
        $this->assertEquals(
            'LVuDpNCSSj6pQ7t9Pv6d6sUkLKoqDEVUnJ',
            $this->getOutput()->address(NetworkFactory::litecoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoinTestnet(): void
    {
        $this->assertEquals(
            'mrCDrCybB6J1vRfbwM5hemdJz73FwDBC8r',
            $this->getOutput()->address(NetworkFactory::litecoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressDogecoin(): void
    {
        $this->assertEquals(
            'DFpN6QqFfUm3gKNaxN6tNcab1FArL9cZLE',
            $this->getOutput()->address(NetworkFactory::dogecoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressDogecoinTestnet(): void
    {
        $this->assertEquals(
            'nesRpRaAbTDmZHwmzBkLd2AtF7Z9L9z5S2',
            $this->getOutput()->address(NetworkFactory::dogecoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressViacoin(): void
    {
        $this->assertEquals(
            'Vkg6Ts44mskyD668xZkxFkjqovjXX9yUzZ',
            $this->getOutput()->address(NetworkFactory::viacoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressViacoinTestnet(): void
    {
        $this->assertEquals(
            'tHbsbwkCXyi31MtzL4QoQmyu4BAMJz8hS6',
            $this->getOutput()->address(NetworkFactory::viacoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressDash(): void
    {
        $this->assertEquals(
            'XmN7PQYWKn5MJFna5fRYgP6mxT2F7xpekE',
            $this->getOutput()->address(NetworkFactory::dash())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressDashTestnet(): void
    {
        $this->assertEquals(
            'y7f7RFKf49GYpZa2d6QdEHFLcEFfuoNcer',
            $this->getOutput()->address(NetworkFactory::dashTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressZcash(): void
    {
        $this->assertEquals(
            't1UYsZVJkLPeMjxEtACvSxfWuNmddpWfxzs',
            $this->getOutput()->address(NetworkFactory::zcash())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressClams(): void
    {
        $this->assertEquals('xJyuT2j5dnLoBhHraFjzG2hmMDjnS3fefx', $this->getOutput()->address(NetworkFactory::clams()));
    }

    /**
     * @throws Exception
     */
    public function testFromScript(): void
    {
        $output = $this->getOutput();
        $this->assertEquals($output->script(), P2pkh::fromScript($output->script())->script());
    }
}

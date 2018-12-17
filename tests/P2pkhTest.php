<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

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
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    protected function getOutput(): OutputInterface
    {
        return OutputFactory::p2pkh(hex2bin('751e76e8199196d454941c45d1b3a323f1433bd6'));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testHex()
    {
        $this->assertEquals('76a914751e76e8199196d454941c45d1b3a323f1433bd688ac', $this->getOutput()->hex());
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAsm()
    {
        $this->assertEquals('DUP HASH160 PUSHDATA(20)[751e76e8199196d454941c45d1b3a323f1433bd6] EQUALVERIFY CHECKSIG', $this->getOutput()->asm());
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressBitcoin()
    {
        $this->assertEquals('1BgGZ9tcN4rm9KBzDn7KprQz87SZ26SAMH', $this->getOutput()->address());
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressBitcoinTestnet()
    {
        $this->assertEquals('mrCDrCybB6J1vRfbwM5hemdJz73FwDBC8r', $this->getOutput()->address(NetworkFactory::bitcoinTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressBitcoinCash()
    {
        $this->assertEquals('bitcoincash:qp63uahgrxged4z5jswyt5dn5v3lzsem6cy4spdc2h', $this->getOutput()->address(NetworkFactory::bitcoinCash()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressBitcoinGold()
    {
        $this->assertEquals('GUXByHDZLvU4DnVH9imSFckt3HEQ5cFgE5', $this->getOutput()->address(NetworkFactory::bitcoinGold()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressLitecoin()
    {
        $this->assertEquals('LVuDpNCSSj6pQ7t9Pv6d6sUkLKoqDEVUnJ', $this->getOutput()->address(NetworkFactory::litecoin()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressLitecoinTestnet()
    {
        $this->assertEquals('mrCDrCybB6J1vRfbwM5hemdJz73FwDBC8r', $this->getOutput()->address(NetworkFactory::litecoinTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressDogecoin()
    {
        $this->assertEquals('DFpN6QqFfUm3gKNaxN6tNcab1FArL9cZLE', $this->getOutput()->address(NetworkFactory::dogecoin()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressDogecoinTestnet()
    {
        $this->assertEquals('nesRpRaAbTDmZHwmzBkLd2AtF7Z9L9z5S2', $this->getOutput()->address(NetworkFactory::dogecoinTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressViacoin()
    {
        $this->assertEquals('Vkg6Ts44mskyD668xZkxFkjqovjXX9yUzZ', $this->getOutput()->address(NetworkFactory::viacoin()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressViacoinTestnet()
    {
        $this->assertEquals('tHbsbwkCXyi31MtzL4QoQmyu4BAMJz8hS6', $this->getOutput()->address(NetworkFactory::viacoinTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressDash()
    {
        $this->assertEquals('XmN7PQYWKn5MJFna5fRYgP6mxT2F7xpekE', $this->getOutput()->address(NetworkFactory::dash()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressDashTestnet()
    {
        $this->assertEquals('y7f7RFKf49GYpZa2d6QdEHFLcEFfuoNcer', $this->getOutput()->address(NetworkFactory::dashTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressZcash()
    {
        $this->assertEquals('t1UYsZVJkLPeMjxEtACvSxfWuNmddpWfxzs', $this->getOutput()->address(NetworkFactory::zcash()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testFromScript()
    {
        $output = $this->getOutput();
        $this->assertEquals($output->script(), P2pkh::fromScript($output->script())->script());
    }
}
<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use PHPUnit\Framework\TestCase;

/**
 * Class P2shTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class P2shTest extends TestCase
{
    /**
     * @return OutputInterface
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    protected function getOutput(): OutputInterface
    {
        $factory = new OutputFactory();
        $p2ms = $factory->p2ms(1, [hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798')]);
        return $factory->p2sh($p2ms);
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testHex()
    {
        $this->assertEquals('a91483eebb7d79aa1d388e3b0ac65b98ac580c4da01a87', $this->getOutput()->hex());
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAsm()
    {
        $this->assertEquals('HASH160 PUSHDATA(20)[83eebb7d79aa1d388e3b0ac65b98ac580c4da01a] EQUAL', $this->getOutput()->asm());
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressBitcoin()
    {
        $this->assertEquals('3DicS6C8JZm59RsrgXr56iVHzYdQngiehV', $this->getOutput()->address());
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressBitcoinTestnet()
    {
        $this->assertEquals('2N5GpVq89v2GRMDWQMfTwifUZCtqaczC6Y7', $this->getOutput()->address(NetworkFactory::bitcoinTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressBitcoinCash()
    {
        $this->assertEquals('bitcoincash:pzp7awma0x4p6wyw8v9vvkuc43vqcndqrg9umkmd8g', $this->getOutput()->address(NetworkFactory::bitcoinCash()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressBitcoinGold()
    {
        $this->assertEquals('dRSt8KXceu9YfGjDmCAAKNdAVRXbFQWRxF', $this->getOutput()->address(NetworkFactory::bitcoinGold()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressLitecoin()
    {
        $this->assertEquals('MKvkjyc6FgcVww9knQqQvMjhKFDrpERUsa', $this->getOutput()->address(NetworkFactory::litecoin()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressLitecoinTestnet()
    {
        $this->assertEquals('QYdacqzPw8KWVQGSymVxoMuzMHHQYBayi6', $this->getOutput()->address(NetworkFactory::litecoinTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressDogecoin()
    {
        $this->assertEquals('A4TsAwG2Nddy3oFL6fWVLr7fh81SuuSoLQ', $this->getOutput()->address(NetworkFactory::dogecoin()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressDogecoinTestnet()
    {
        $this->assertEquals('2N5GpVq89v2GRMDWQMfTwifUZCtqaczC6Y7', $this->getOutput()->address(NetworkFactory::dogecoinTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressViacoin()
    {
        $this->assertEquals('EVBW18YCBcjc3ZnHNHAzgE7KcfqpgPjScU', $this->getOutput()->address(NetworkFactory::viacoin()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressViacoinTestnet()
    {
        $this->assertEquals('2N5GpVq89v2GRMDWQMfTwifUZCtqaczC6Y7', $this->getOutput()->address(NetworkFactory::viacoinTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressDash()
    {
        $this->assertEquals('7eSFGHUJ7Yri9CQox9WaS6Uwv6TngFDeEa', $this->getOutput()->address(NetworkFactory::dash()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressDashTestnet()
    {
        $this->assertEquals('8rT4DcNAF6FLbVq52QWXtUJJocEcmYMNRG', $this->getOutput()->address(NetworkFactory::dashTestnet()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testAddressZcash()
    {
        $this->assertEquals('t3WbDSRcGGtYfk4vkcxfCEXbDFCpVZxhxKh', $this->getOutput()->address(NetworkFactory::zcash()));
    }

    /**
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function testFromScript()
    {
        $output = $this->getOutput();
        $this->assertEquals($output->script(), P2sh::fromScript($output->script())->script());
    }
}
<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Exception;
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
     * @throws Exception
     */
    protected function getOutput(): OutputInterface
    {
        $factory = new OutputFactory();
        $p2ms = $factory->p2ms(
            1,
            [hex2bin('0279be667ef9dcbbac55a06295ce870b07029bfcdb2dce28d959f2815b16f81798') ?: '']
        );
        return $factory->p2sh($p2ms);
    }

    /**
     * @throws Exception
     */
    public function testHex(): void
    {
        $this->assertEquals(
            'a91483eebb7d79aa1d388e3b0ac65b98ac580c4da01a87',
            $this->getOutput()->hex()
        );
    }

    /**
     * @throws Exception
     */
    public function testAsm(): void
    {
        $this->assertEquals(
            'HASH160 PUSHDATA(20)[83eebb7d79aa1d388e3b0ac65b98ac580c4da01a] EQUAL',
            $this->getOutput()->asm()
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoin(): void
    {
        $this->assertEquals('3DicS6C8JZm59RsrgXr56iVHzYdQngiehV', $this->getOutput()->address());
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoinTestnet(): void
    {
        $this->assertEquals(
            '2N5GpVq89v2GRMDWQMfTwifUZCtqaczC6Y7',
            $this->getOutput()->address(NetworkFactory::bitcoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoinCash(): void
    {
        $this->assertEquals(
            'bitcoincash:pzp7awma0x4p6wyw8v9vvkuc43vqcndqrg9umkmd8g',
            $this->getOutput()->address(NetworkFactory::bitcoinCash())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressBitcoinGold(): void
    {
        $this->assertEquals('AToUA3ZK5p6qsEPR85qopyPTKdGPaUNd9V', $this->getOutput()->address(NetworkFactory::bitcoinGold()));
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoin(): void
    {
        $this->assertEquals(
            'MKvkjyc6FgcVww9knQqQvMjhKFDrpERUsa',
            $this->getOutput()->address(NetworkFactory::litecoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressLitecoinTestnet(): void
    {
        $this->assertEquals(
            'QYdacqzPw8KWVQGSymVxoMuzMHHQYBayi6',
            $this->getOutput()->address(NetworkFactory::litecoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressDogecoin(): void
    {
        $this->assertEquals(
            'A4TsAwG2Nddy3oFL6fWVLr7fh81SuuSoLQ',
            $this->getOutput()->address(NetworkFactory::dogecoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressDogecoinTestnet(): void
    {
        $this->assertEquals(
            '2N5GpVq89v2GRMDWQMfTwifUZCtqaczC6Y7',
            $this->getOutput()->address(NetworkFactory::dogecoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressViacoin(): void
    {
        $this->assertEquals(
            'EVBW18YCBcjc3ZnHNHAzgE7KcfqpgPjScU',
            $this->getOutput()->address(NetworkFactory::viacoin())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressViacoinTestnet(): void
    {
        $this->assertEquals(
            '2N5GpVq89v2GRMDWQMfTwifUZCtqaczC6Y7',
            $this->getOutput()->address(NetworkFactory::viacoinTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressDash(): void
    {
        $this->assertEquals(
            '7eSFGHUJ7Yri9CQox9WaS6Uwv6TngFDeEa',
            $this->getOutput()->address(NetworkFactory::dash())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressDashTestnet(): void
    {
        $this->assertEquals(
            '8rT4DcNAF6FLbVq52QWXtUJJocEcmYMNRG',
            $this->getOutput()->address(NetworkFactory::dashTestnet())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressZcash(): void
    {
        $this->assertEquals(
            't3WbDSRcGGtYfk4vkcxfCEXbDFCpVZxhxKh',
            $this->getOutput()->address(NetworkFactory::zcash())
        );
    }

    /**
     * @throws Exception
     */
    public function testAddressClams()
    {
        $this->assertEquals('6SRSJxaRz1U5gtzYstWcyifb2agxWxnFiW', $this->getOutput()->address(NetworkFactory::clams()));
    }

    /**
     * @throws Exception
     */
    public function testFromScript(): void
    {
        $output = $this->getOutput();
        $this->assertEquals($output->script(), P2sh::fromScript($output->script())->script());
    }
}

<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Tests;

use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Output\OutputFactory;
use AndKom\Bitcoin\Address\Taproot;
use PHPUnit\Framework\TestCase;

/**
 * Class TaprootTest
 * @package AndKom\Bitcoin\Address\Tests
 */
class TaprootTest extends TestCase
{
    function testAddress()
    {
        $pubKeys = [
            '026f7b861432127845aac3f0685f03359d73c5009929cfa88920aaba8419e0d3fc' => 'tb1pw9d6svmf4zsl27qnz76fcmz9yxpeqsz0xqsed59pdh68lr4ud5vsjk506u',
            '02be3a48320efd83fb3c80c961a06b25c3049f63a0b0d9009c27ecbbca80fb2d85' => 'tb1p8969s4chlgj6jncd0qyqv77cha00uk7v6nnm4pzpr67u7p4jkgsqemy6yq',
            '03ee397d520b5a9e59b0813eed5f84274af42ba2fa074cd5c68ad01b1b1521ecb1' => 'tb1pk9v0nuu0cr78c9lmrl22crdjwtxhsr0ekjuv9p8hkjquwtnknxdqprjpjh',
            '0367ca30afae9d9b5374c9d34b0dc684044bf04a19c9a299b1d68bd6da173c9ccb' => 'tb1pyxakgvcv6cq2zakm599zuxs7mljfww0fj9k00w3z9e5g8uf4gujqxwws6a',
        ];

        $network = NetworkFactory::bitcoinTestnet();

        foreach ($pubKeys as $pubKey => $address) {
            $this->assertEquals(
                OutputFactory::p2tr(Taproot::construct(hex2bin($pubKey)))->address($network),
                $address
            );
        }
    }
}
<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\Op;
use AndKom\Bitcoin\Address\Validate;

/**
 * Class P2pkh
 * Pay-To-PubKeyHash output.
 * @package AndKom\Bitcoin\Address\Output\Outputs
 */
class P2pkh extends AbstractOutput
{
    /**
     * @var string
     */
    protected $pubKeyHash;

    /**
     * P2pkh constructor.
     * @param string $pubKeyHash
     * @throws Exception
     */
    public function __construct(string $pubKeyHash)
    {
        $this->pubKeyHash = Validate::pubKeyHash($pubKeyHash);
    }

    /**
     * @return string
     */
    public function script(): string
    {
        return Op::DUP . Op::HASH160 . "\x14" . $this->pubKeyHash . Op::EQUALVERIFY . Op::CHECKSIG;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('DUP HASH160 PUSHDATA(20)[%s] EQUALVERIFY CHECKSIG', bin2hex($this->pubKeyHash));
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2pkh($this->pubKeyHash);
    }
}
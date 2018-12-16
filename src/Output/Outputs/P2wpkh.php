<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Validate;

/**
 * Class P2wpkh
 * Pay-To-WitnessPubKeyHash output.
 * @package AndKom\Bitcoin\Address\Output\Outputs
 */
class P2wpkh extends AbstractOutput
{
    /**
     * @var string
     */
    protected $pubKeyHash;

    /**
     * P2wpkh constructor.
     * @param string $pubKeyHash
     * @throws \AndKom\Bitcoin\Address\Exception
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
        return "\x00\x14" . $this->pubKeyHash;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('0 PUSHDATA(20)[%s]', bin2hex($this->pubKeyHash));
    }

    /**
     * @return string
     * @param NetworkInterface|null $network
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2wpkh($this->pubKeyHash);
    }
}
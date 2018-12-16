<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\Op;
use AndKom\Bitcoin\Address\Utils;
use AndKom\Bitcoin\Address\Validate;

/**
 * Class P2pk
 * Pay-To-PubKey
 * @package AndKom\Bitcoin\Address\Output\Outputs
 */
class P2pk extends AbstractOutput
{
    /**
     * @var string
     */
    protected $pubKey;

    /**
     * P2pk constructor.
     * @param string $pubKey
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function __construct(string $pubKey)
    {
        $this->pubKey = Validate::pubKey($pubKey);
    }

    /**
     * @return string
     */
    public function script(): string
    {
        return chr(strlen($this->pubKey)) . $this->pubKey . Op::CHECKSIG;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('PUSHDATA(%d)[%s] CHECKSIG', strlen($this->pubKey), bin2hex($this->pubKey));
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2pkh(Utils::hash160($this->pubKey));
    }
}
<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Validate;

/**
 * Class P2wsh
 * Pay-To-WitnessScriptHash output.
 * @package AndKom\Bitcoin\Address\Output\Outputs
 */
class P2wsh extends AbstractOutput
{
    /**
     * @var string
     */
    protected $witnessHash;

    /**
     * P2wsh constructor.
     * @param OutputInterface|string $witnessHash
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function __construct($witnessHash)
    {
        if ($witnessHash instanceof OutputInterface) {
            $witnessHash = $witnessHash->witnessHash();
        }

        $this->witnessHash = Validate::witnessHash($witnessHash);
    }

    /**
     * @return string
     */
    public function script(): string
    {
        return "\x00\x20" . $this->witnessHash;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('0 PUSHDATA(32)[%s]', bin2hex($this->witnessHash));
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2wsh($this->witnessHash);
    }
}
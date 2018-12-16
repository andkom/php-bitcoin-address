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
    protected $witnessScriptHash;

    /**
     * P2wsh constructor.
     * @param string|OutputInterface $witnessScriptHash
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function __construct($witnessScriptHash)
    {
        if ($witnessScriptHash instanceof OutputInterface) {
            $witnessScriptHash = $witnessScriptHash->witnessHash();
        }

        $this->witnessScriptHash = Validate::witnessScriptHash($witnessScriptHash);
    }

    /**
     * @return string
     */
    public function script(): string
    {
        return "\x00\x20" . $this->witnessScriptHash;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('0 PUSHDATA(32)[%s]', bin2hex($this->witnessScriptHash));
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2wsh($this->witnessScriptHash);
    }
}
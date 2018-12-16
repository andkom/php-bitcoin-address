<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\Op;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Validate;

/**
 * Class P2sh
 * Pay-To-ScriptHash output
 * @package AndKom\Bitcoin\Address\Output\Outputs
 */
class P2sh extends AbstractOutput
{
    /**
     * @var string
     */
    protected $scriptHash;

    /**
     * P2sh constructor.
     * @param string|OutputInterface $scriptHash
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    public function __construct($scriptHash)
    {
        if ($scriptHash instanceof OutputInterface) {
            $scriptHash = $scriptHash->hash();
        }

        $this->scriptHash = Validate::scriptHash($scriptHash);
    }

    /**
     * @return string
     */
    public function script(): string
    {
        return Op::HASH160 . "\x14" . $this->scriptHash . Op::EQUAL;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('HASH160 PUSHDATA(20)[%s] EQUAL', bin2hex($this->scriptHash));
    }

    /**
     * @return string
     * @param NetworkInterface|null $network
     * @throws \Exception
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2sh($this->scriptHash);
    }
}
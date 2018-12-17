<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\Op;
use AndKom\Bitcoin\Address\Output\OutputInterface;

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
    protected $output;

    /**
     * P2sh constructor.
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @return string
     */
    public function script(): string
    {
        return Op::HASH160 . "\x14" . $this->output->hash() . Op::EQUAL;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('HASH160 PUSHDATA(20)[%s] EQUAL', bin2hex($this->output->hash()));
    }

    /**
     * @return string
     * @param NetworkInterface|null $network
     * @throws \Exception
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2sh($this->output);
    }
}
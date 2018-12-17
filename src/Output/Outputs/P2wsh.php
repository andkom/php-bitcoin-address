<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\OutputInterface;

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
    protected $output;

    /**
     * P2wsh constructor.
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
        return "\x00\x20" . $this->output->witnessHash();
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('0 PUSHDATA(32)[%s]', bin2hex($this->output->witnessHash()));
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2wsh($this->output);
    }
}
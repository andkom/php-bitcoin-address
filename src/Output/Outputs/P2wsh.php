<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Exception;
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
    const SCRIPT_LEN = 34;
    const WITNESS_VERSION = "\x00";

    /**
     * @var string
     */
    protected $witnessHash;

    /**
     * P2wsh constructor.
     * @param string|OutputInterface $witnessHash
     * @throws Exception
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
    public function getWitnessHash(): string
    {
        return $this->witnessHash;
    }
    
    /**
     * @return string
     */
    public function script(): string
    {
        return static::WITNESS_VERSION . "\x20" . $this->witnessHash;
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

    /**
     * @param string $script
     * @throws Exception
     */
    static public function validateScript(string $script)
    {
        if (static::SCRIPT_LEN != strlen($script)) {
            throw new Exception('Invalid P2WSH script length.');
        }

        if (static::WITNESS_VERSION != $script[0] ||
            "\x20" != $script[1]) {
            throw new Exception('Invalid P2WSH script format.');
        }
    }

    /**
     * @param string $script
     * @return OutputInterface
     * @throws Exception
     */
    static public function fromScript(string $script): OutputInterface
    {
        static::validateScript($script);

        $witnessHash = substr($script, 2, 32);

        return new static($witnessHash);
    }
}
<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Validate;

/**
 * Class P2wpkh
 * Pay-To-WitnessPubKeyHash output.
 * @package AndKom\Bitcoin\Address\Output\Outputs
 */
class P2wpkh extends AbstractOutput
{
    public const SCRIPT_LEN = 22;
    public const WITNESS_VERSION = "\x00";

    /**
     * @var string
     */
    protected $pubKeyHash;

    /**
     * P2wpkh constructor.
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
    public function getPubKeyHash(): string
    {
        return $this->pubKeyHash;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return 'p2wpkh';
    }

    /**
     * @return string
     */
    public function script(): string
    {
        return static::WITNESS_VERSION . "\x14" . $this->pubKeyHash;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('0 PUSHDATA(20)[%s]', bin2hex($this->pubKeyHash));
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2wpkh($this->pubKeyHash);
    }

    /**
     * @param string $script
     * @throws Exception
     */
    public static function validateScript(string $script)
    {
        if (static::SCRIPT_LEN != strlen($script)) {
            throw new Exception('Invalid P2WPKH script length.');
        }

        if (
            static::WITNESS_VERSION != $script[0] ||
            "\x14" != $script[1]
        ) {
            throw new Exception('Invalid P2WPKH script format.');
        }
    }

    /**
     * @param string $script
     * @return OutputInterface
     * @throws Exception
     */
    public static function fromScript(string $script): OutputInterface
    {
        static::validateScript($script);

        $pubKeyHash = substr($script, 2, 20);

        return new P2wpkh($pubKeyHash);
    }
}

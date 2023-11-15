<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\OutputInterface;

/**
 * Class P2tr
 * Pay-To-Taproot output.
 * @package AndKom\Bitcoin\Address\Output\Outputs
 */
class P2tr extends AbstractOutput
{
    public const SCRIPT_LEN = 34;
    public const WITNESS_VERSION = "\x51";

    /**
     * @var string
     */
    protected $taprootPubKey;

    /**
     * P2pkh constructor.
     * @param string $taprootPubKey
     */
    public function __construct(string $taprootPubKey)
    {
        $this->taprootPubKey = $taprootPubKey;
    }

    /**
     * @return string
     */
    public function getTaprootPubKey(): string
    {
        return $this->taprootPubKey;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return 'p2tr';
    }

    /**
     * @return string
     */
    public function script(): string
    {
        return static::WITNESS_VERSION . "\x20" . $this->taprootPubKey;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        return sprintf('1 PUSHDATA(32)[%s]', bin2hex($this->taprootPubKey));
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     */
    public function address(NetworkInterface $network = null): string
    {
        return $this->network($network)->getAddressP2tr($this->taprootPubKey);
    }

    /**
     * @param string $script
     * @throws Exception
     */
    public static function validateScript(string $script)
    {
        if (static::SCRIPT_LEN != strlen($script)) {
            throw new Exception('Invalid P2TR script length.');
        }

        if (
            static::WITNESS_VERSION != $script[0] ||
            "\x20" != $script[1]
        ) {
            throw new Exception('Invalid P2TR script format.');
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

        $taprootPubKey = substr($script, 2, 32);

        return new P2tr($taprootPubKey);
    }
}

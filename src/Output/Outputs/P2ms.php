<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output\Outputs;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\AbstractOutput;
use AndKom\Bitcoin\Address\Output\Op;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Validate;

/**
 * Class P2ms
 * Pay-To-Multisig output.
 * @package AndKom\Bitcoin\Address\Output\Outputs
 */
class P2ms extends AbstractOutput
{
    const MIN_SCRIPT_LEN = 37;

    /**
     * Number of signatures
     * @var int
     */
    protected $m;

    /**
     * Public keys
     * @var string[]
     */
    protected $pubKeys;

    /**
     * P2ms constructor.
     * @param int $m Number of signatures
     * @param array $pubKeys
     * @throws Exception
     */
    public function __construct(int $m, array $pubKeys)
    {
        if ($m < 1 || $m > 16) {
            throw new Exception('Number of signatures must be from 1 to 16.');
        }

        $pubKeysLen = count($pubKeys);

        if ($pubKeysLen < 1 || $pubKeysLen > 16) {
            throw new Exception('Number of pubkeys must be from 1 to 16.');
        }

        if ($m > count($pubKeys)) {
            throw new Exception('Number of signatures must be less or equal to number of pubkeys.');
        }

        $this->m = $m;
        $this->pubKeys = array_map([Validate::class, 'pubKey'], $pubKeys);
    }

    /**
     * @return string
     */
    public function script(): string
    {
        $script = chr(0x50 + $this->m);

        foreach ($this->pubKeys as $pubKey) {
            $script .= chr(strlen($pubKey)) . $pubKey;
        }
        $script .= chr(0x50 + count($this->pubKeys)) . Op::CHECKMULTISIG;

        return $script;
    }

    /**
     * @return string
     */
    public function asm(): string
    {
        $script = $this->m . ' ';

        foreach ($this->pubKeys as $pubKey) {
            $script .= sprintf('PUSHDATA(%d)[%s] ', strlen($pubKey), bin2hex($pubKey));
        }

        $script .= count($this->pubKeys) . ' CHECKMULTISIG';

        return $script;
    }

    /**
     * @param NetworkInterface|null $network
     * @return string
     * @throws Exception
     */
    public function address(NetworkInterface $network = null): string
    {
        throw new Exception('P2MS output cannot have address.');
    }

    /**
     * @param string $script
     * @throws Exception
     */
    static public function validateScript(string $script)
    {
        $scriptLen = strlen($script);

        if (static::MIN_SCRIPT_LEN > $scriptLen) {
            throw new Exception('Invalid P2MS script length.');
        }

        $m = ord($script[0]) - 0x50;
        $n = ord($script[-2]) - 0x50;

        if ($m < 1 || $m > 16 || $n < 1 || $n > 16 || $m > $n || Op::CHECKMULTISIG != $script[-1]) {
            throw new Exception('Invalid P2MS script format.');
        }

        for ($i = 1, $c = 0; $i < $scriptLen - 2; $c++) {
            $pubKeyLen = ord($script[$i]);

            if (Validate::COMPRESSED_PUBKEY_LEN != $pubKeyLen &&
                Validate::UNCOMPRESSED_PUBKEY_LEN != $pubKeyLen) {
                throw new Exception('Invalid pubkey length.');
            }

            $i += $pubKeyLen + 1;
        }

        if ($c != $n) {
            throw new Exception('Invalid number of pubkeys.');
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

        $scriptLen = strlen($script);
        $m = ord($script[0]) - 0x50;
        $pubKeys = [];

        for ($i = 1; $i < $scriptLen - 2;) {
            $pubKeyLen = ord($script[$i]);
            $pubKeys[] = substr($script, $i + 1, $pubKeyLen);
            $i += $pubKeyLen + 1;
        }

        return new static($m, $pubKeys);
    }
}
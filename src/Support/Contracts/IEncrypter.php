<?php

namespace Feather\Support\Contracts;

/**
 *
 * @author fcarbah
 */
interface IEncrypter
{

    /**
     *
     * @param string $encryptedText
     * @param bool $unserialize set this to true if original value was serialize during encryption
     * @return string
     */
    public function decrypt(string $encryptedText, bool $unserialize = false): string;

    /**
     *
     * @param string|object|array $plainText if not string, then set serialize to true
     * @param bool $serialize
     * @return string
     */
    public function encrypt($plainText, bool $serialize = false): string;
}

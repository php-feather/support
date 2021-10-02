<?php

use Feather\Support\Util\Token;
use PHPUnit\Framework\TestCase;

/**
 * Description of TokenTest
 *
 * @author fcarbah
 */
class TokenTest extends TestCase
{

    /**
     * @test
     */
    public function tokenIsExpired()
    {
        $token = new Token('test', '123', 1);
        sleep(65);
        $this->assertTrue($token->isExpired());
    }

    /**
     * @test
     */
    public function tokenIsNotExpired()
    {
        $token = new Token('test', '123', 2);
        sleep(65);
        $this->assertFalse($token->isExpired());
    }

}

<?php

namespace Feather\Support\MultiThreading;

use Opis\Closure\SerializableClosure;
use Opis\Closure\ClosureStream;

/**
 * Description of SerializeClosure
 *
 * @author fcarbah
 */
class SerializeClosure extends SerializableClosure
{

    public function getClosureFromCode(array $args = [])
    {
        if ($this->closure == null && $this->code) {
            ClosureStream::register();
            $this->closure = include(ClosureStream::STREAM_PROTO . '://' . $this->code . ';');
        }

        return $this->closure;
    }

}

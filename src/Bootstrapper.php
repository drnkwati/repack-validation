<?php

namespace Repack\Validation;

class Bootstrapper
{
    public static function bootstrap($ioc)
    {
        $ioc['validation.presence'] = function ($ioc) {
            return new DatabasePresenceVerifier($ioc['db']);
        };

        $ioc['validator'] = function () use ($ioc) {
            $validator = new Factory($ioc['translator'], $ioc);

            // The validation presence verifier is responsible for determining the existence
            // of values in a given data collection, typically a relational database or
            // other persistent data stores. And it is used to check for uniqueness.
            if ($ioc->offsetExists('validation.presence')) {
                $validator->setPresenceVerifier($ioc['validation.presence']);
            }

            return $validator;
        };
    }
}

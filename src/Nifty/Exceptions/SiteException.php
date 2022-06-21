<?php

namespace Nifty\Exceptions;

use RuntimeException;

class SiteException
{
    public static function EnvNotFound()
    {
        die(json_encode(
            [
                ['status' => 'error'],
                [
                    'message'
                    =>
                    "You need to create an .env file. ".
                    "Use the template .env.example provided."
                ]
            ]
        ));
    }

    public static function MigrationArgNotFound()
    {
        die(json_encode(
            [
                ['status' => 'error'],
                ['message' => "Argument unrecognized"]
            ]
            )
        );
    }
}
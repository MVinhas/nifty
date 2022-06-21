<?php

namespace Nifty\Exceptions;

class DatabaseException
{
    public static function cannotConnect($error)
    {
        die(
            json_encode(
                [
                    ['status' => 'error'],
                    [
                        'message'
                        =>
                        "An error was encountered while connecting".
                        " to the database"
                    ],
                    ['technicalInfo' => $error]
                ]
            )
        );
    }

    public static function cannotSelect($error)
    {
        die(json_encode(
            [
                ['status' => 'error'],
                ['message' => $error]
            ]
            )
        );
    }

    public static function cannotCreate($error)
    {
        die(json_encode(
            [
                ['status' => 'error'],
                ['message' => $error]
            ]
            )
        );
    }

    public static function cannotInsert($error, $query)
    {
        die(json_encode(
            [
                ['status' => 'error'],
                ['message' => $error],
                ['query' => $query]
            ]
            )
        );
    }

    public static function cannotClean($error, $query)
    {
        die(json_encode(
            [
                ['status' => 'error'],
                ['message' => $error],
                ['query' => $query]
            ]
            )
        );
    }

    public static function cannotDrop($error, $query)
    {
        die(json_encode(
            [
                ['status' => 'error'],
                ['message' => $error],
                ['query' => $query]
            ]
            )
        );
    }
}
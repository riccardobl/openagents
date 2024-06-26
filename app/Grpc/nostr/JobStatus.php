<?php

// Generated by the protocol buffer compiler.  DO NOT EDIT!
// source: JobStatus.proto

namespace App\Grpc\nostr;

use UnexpectedValueException;

/**
 * Protobuf type <code>JobStatus</code>
 */
class JobStatus
{
    /**
     * Generated from protobuf enum <code>PENDING = 0;</code>
     */
    const PENDING = 0;

    /**
     * Generated from protobuf enum <code>PROCESSING = 1;</code>
     */
    const PROCESSING = 1;

    /**
     * Generated from protobuf enum <code>ERROR = 2;</code>
     */
    const ERROR = 2;

    /**
     * Generated from protobuf enum <code>SUCCESS = 3;</code>
     */
    const SUCCESS = 3;

    /**
     * Generated from protobuf enum <code>PARTIAL = 4;</code>
     */
    const PARTIAL = 4;

    /**
     * Generated from protobuf enum <code>PAYMENT_REQUIRED = 7;</code>
     */
    const PAYMENT_REQUIRED = 7;

    /**
     * Generated from protobuf enum <code>UNKNOWN = 99;</code>
     */
    const UNKNOWN = 99;

    private static $valueToName = [
        self::PENDING => 'PENDING',
        self::PROCESSING => 'PROCESSING',
        self::ERROR => 'ERROR',
        self::SUCCESS => 'SUCCESS',
        self::PARTIAL => 'PARTIAL',
        self::PAYMENT_REQUIRED => 'PAYMENT_REQUIRED',
        self::UNKNOWN => 'UNKNOWN',
    ];

    public static function name($value)
    {
        if (! isset(self::$valueToName[$value])) {
            throw new UnexpectedValueException(sprintf(
                'Enum %s has no name defined for value %s', __CLASS__, $value));
        }

        return self::$valueToName[$value];
    }

    public static function value($name)
    {
        $const = __CLASS__.'::'.strtoupper($name);
        if (! defined($const)) {
            throw new UnexpectedValueException(sprintf(
                'Enum %s has no value defined for name %s', __CLASS__, $name));
        }

        return constant($const);
    }
}

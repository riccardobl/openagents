<?php

// Generated by the protocol buffer compiler.  DO NOT EDIT!
// source: JobStatus.proto

namespace App\Grpc\nostr\GPBMetadata;

class JobStatus
{
    public static $is_initialized = false;

    public static function initOnce()
    {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
            return;
        }
        $pool->internalAddGeneratedFile(
            '
�
JobStatus.proto*p
	JobStatus
PENDING 

PROCESSING	
ERROR
SUCCESS
PARTIAL
PAYMENT_REQUIRED
UNKNOWNcB.�App\\Grpc\\nostr�App\\Grpc\\nostr\\GPBMetadatabproto3', true);

        static::$is_initialized = true;
    }
}

<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: rpc.proto

namespace App\Grpc\nostr;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>RpcCacheGetRequest</code>
 */
class RpcCacheGetRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string key = 1;</code>
     */
    protected $key = '';
    /**
     * Generated from protobuf field <code>optional uint64 lastVersion = 2;</code>
     */
    protected $lastVersion = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $key
     *     @type int|string $lastVersion
     * }
     */
    public function __construct($data = NULL) {
        \App\Grpc\nostr\GPBMetadata\Rpc::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string key = 1;</code>
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Generated from protobuf field <code>string key = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setKey($var)
    {
        GPBUtil::checkString($var, True);
        $this->key = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional uint64 lastVersion = 2;</code>
     * @return int|string
     */
    public function getLastVersion()
    {
        return isset($this->lastVersion) ? $this->lastVersion : 0;
    }

    public function hasLastVersion()
    {
        return isset($this->lastVersion);
    }

    public function clearLastVersion()
    {
        unset($this->lastVersion);
    }

    /**
     * Generated from protobuf field <code>optional uint64 lastVersion = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setLastVersion($var)
    {
        GPBUtil::checkUint64($var);
        $this->lastVersion = $var;

        return $this;
    }

}

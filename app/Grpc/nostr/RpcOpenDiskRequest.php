<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: rpc.proto

namespace App\Grpc\nostr;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>RpcOpenDiskRequest</code>
 */
class RpcOpenDiskRequest extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string url = 1;</code>
     */
    protected $url = '';
    /**
     * Generated from protobuf field <code>optional string encryptionKey = 2;</code>
     */
    protected $encryptionKey = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $url
     *     @type string $encryptionKey
     * }
     */
    public function __construct($data = NULL) {
        \App\Grpc\nostr\GPBMetadata\Rpc::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string url = 1;</code>
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Generated from protobuf field <code>string url = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->url = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional string encryptionKey = 2;</code>
     * @return string
     */
    public function getEncryptionKey()
    {
        return isset($this->encryptionKey) ? $this->encryptionKey : '';
    }

    public function hasEncryptionKey()
    {
        return isset($this->encryptionKey);
    }

    public function clearEncryptionKey()
    {
        unset($this->encryptionKey);
    }

    /**
     * Generated from protobuf field <code>optional string encryptionKey = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setEncryptionKey($var)
    {
        GPBUtil::checkString($var, True);
        $this->encryptionKey = $var;

        return $this;
    }

}


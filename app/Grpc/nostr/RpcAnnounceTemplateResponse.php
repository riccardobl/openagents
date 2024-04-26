<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: rpc.proto

namespace App\Grpc\nostr;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>RpcAnnounceTemplateResponse</code>
 */
class RpcAnnounceTemplateResponse extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>bool success = 1;</code>
     */
    protected $success = false;
    /**
     * Generated from protobuf field <code>uint64 refreshInterval = 4;</code>
     */
    protected $refreshInterval = 0;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type bool $success
     *     @type int|string $refreshInterval
     * }
     */
    public function __construct($data = NULL) {
        \App\Grpc\nostr\GPBMetadata\Rpc::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>bool success = 1;</code>
     * @return bool
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * Generated from protobuf field <code>bool success = 1;</code>
     * @param bool $var
     * @return $this
     */
    public function setSuccess($var)
    {
        GPBUtil::checkBool($var);
        $this->success = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint64 refreshInterval = 4;</code>
     * @return int|string
     */
    public function getRefreshInterval()
    {
        return $this->refreshInterval;
    }

    /**
     * Generated from protobuf field <code>uint64 refreshInterval = 4;</code>
     * @param int|string $var
     * @return $this
     */
    public function setRefreshInterval($var)
    {
        GPBUtil::checkUint64($var);
        $this->refreshInterval = $var;

        return $this;
    }

}

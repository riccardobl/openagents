<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: rpc.proto

namespace App\Grpc\nostr;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>RpcRequestJob</code>
 */
class RpcRequestJob extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string runOn = 1;</code>
     */
    protected $runOn = '';
    /**
     * Generated from protobuf field <code>uint64 expireAfter = 2;</code>
     */
    protected $expireAfter = 0;
    /**
     * Generated from protobuf field <code>repeated .JobInput input = 3;</code>
     */
    private $input;
    /**
     * Generated from protobuf field <code>repeated .JobParam param = 4;</code>
     */
    private $param;
    /**
     * Generated from protobuf field <code>string description = 6;</code>
     */
    protected $description = '';
    /**
     * Generated from protobuf field <code>optional uint32 kind = 7;</code>
     */
    protected $kind = null;
    /**
     * Generated from protobuf field <code>optional string outputFormat = 8;</code>
     */
    protected $outputFormat = null;
    /**
     * Generated from protobuf field <code>optional string requestProvider = 9;</code>
     */
    protected $requestProvider = null;
    /**
     * Generated from protobuf field <code>optional bool encrypted = 10;</code>
     */
    protected $encrypted = null;
    /**
     * Generated from protobuf field <code>optional string userId = 11;</code>
     */
    protected $userId = null;

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type string $runOn
     *     @type int|string $expireAfter
     *     @type array<\App\Grpc\nostr\JobInput>|\Google\Protobuf\Internal\RepeatedField $input
     *     @type array<\App\Grpc\nostr\JobParam>|\Google\Protobuf\Internal\RepeatedField $param
     *     @type string $description
     *     @type int $kind
     *     @type string $outputFormat
     *     @type string $requestProvider
     *     @type bool $encrypted
     *     @type string $userId
     * }
     */
    public function __construct($data = NULL) {
        \App\Grpc\nostr\GPBMetadata\Rpc::initOnce();
        parent::__construct($data);
    }

    /**
     * Generated from protobuf field <code>string runOn = 1;</code>
     * @return string
     */
    public function getRunOn()
    {
        return $this->runOn;
    }

    /**
     * Generated from protobuf field <code>string runOn = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setRunOn($var)
    {
        GPBUtil::checkString($var, True);
        $this->runOn = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint64 expireAfter = 2;</code>
     * @return int|string
     */
    public function getExpireAfter()
    {
        return $this->expireAfter;
    }

    /**
     * Generated from protobuf field <code>uint64 expireAfter = 2;</code>
     * @param int|string $var
     * @return $this
     */
    public function setExpireAfter($var)
    {
        GPBUtil::checkUint64($var);
        $this->expireAfter = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .JobInput input = 3;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * Generated from protobuf field <code>repeated .JobInput input = 3;</code>
     * @param array<\App\Grpc\nostr\JobInput>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setInput($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \App\Grpc\nostr\JobInput::class);
        $this->input = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>repeated .JobParam param = 4;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getParam()
    {
        return $this->param;
    }

    /**
     * Generated from protobuf field <code>repeated .JobParam param = 4;</code>
     * @param array<\App\Grpc\nostr\JobParam>|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setParam($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \App\Grpc\nostr\JobParam::class);
        $this->param = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string description = 6;</code>
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Generated from protobuf field <code>string description = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setDescription($var)
    {
        GPBUtil::checkString($var, True);
        $this->description = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional uint32 kind = 7;</code>
     * @return int
     */
    public function getKind()
    {
        return isset($this->kind) ? $this->kind : 0;
    }

    public function hasKind()
    {
        return isset($this->kind);
    }

    public function clearKind()
    {
        unset($this->kind);
    }

    /**
     * Generated from protobuf field <code>optional uint32 kind = 7;</code>
     * @param int $var
     * @return $this
     */
    public function setKind($var)
    {
        GPBUtil::checkUint32($var);
        $this->kind = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional string outputFormat = 8;</code>
     * @return string
     */
    public function getOutputFormat()
    {
        return isset($this->outputFormat) ? $this->outputFormat : '';
    }

    public function hasOutputFormat()
    {
        return isset($this->outputFormat);
    }

    public function clearOutputFormat()
    {
        unset($this->outputFormat);
    }

    /**
     * Generated from protobuf field <code>optional string outputFormat = 8;</code>
     * @param string $var
     * @return $this
     */
    public function setOutputFormat($var)
    {
        GPBUtil::checkString($var, True);
        $this->outputFormat = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional string requestProvider = 9;</code>
     * @return string
     */
    public function getRequestProvider()
    {
        return isset($this->requestProvider) ? $this->requestProvider : '';
    }

    public function hasRequestProvider()
    {
        return isset($this->requestProvider);
    }

    public function clearRequestProvider()
    {
        unset($this->requestProvider);
    }

    /**
     * Generated from protobuf field <code>optional string requestProvider = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setRequestProvider($var)
    {
        GPBUtil::checkString($var, True);
        $this->requestProvider = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional bool encrypted = 10;</code>
     * @return bool
     */
    public function getEncrypted()
    {
        return isset($this->encrypted) ? $this->encrypted : false;
    }

    public function hasEncrypted()
    {
        return isset($this->encrypted);
    }

    public function clearEncrypted()
    {
        unset($this->encrypted);
    }

    /**
     * Generated from protobuf field <code>optional bool encrypted = 10;</code>
     * @param bool $var
     * @return $this
     */
    public function setEncrypted($var)
    {
        GPBUtil::checkBool($var);
        $this->encrypted = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>optional string userId = 11;</code>
     * @return string
     */
    public function getUserId()
    {
        return isset($this->userId) ? $this->userId : '';
    }

    public function hasUserId()
    {
        return isset($this->userId);
    }

    public function clearUserId()
    {
        unset($this->userId);
    }

    /**
     * Generated from protobuf field <code>optional string userId = 11;</code>
     * @param string $var
     * @return $this
     */
    public function setUserId($var)
    {
        GPBUtil::checkString($var, True);
        $this->userId = $var;

        return $this;
    }

}


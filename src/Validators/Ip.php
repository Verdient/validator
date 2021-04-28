<?php
namespace Verdient\Validator\Validators;

/**
 * IP
 * @author Verdient。
 */
class Ip extends \Verdient\Validator\AbstractValidator
{
    /**
     * @var bool 是否允许IPv4
     * @author Verdient。
     */
    public $ipv4 = true;

    /**
     * @var bool 是否允许IPv6
     * @author Verdient。
     */
    public $ipv6 = true;

    /**
     * @var bool|null 是否允许携带子网
     * - `true` - 必须携带子网
     * - `false` - 必须不含子网
     * - `null` - 子网信息可选
     * @author Verdient。
     */
    public $subnet = false;

    /**
     * @var bool IP地址开头是否允许有取反字符
     * @author Verdient。
     */
    public $negation = false;

    /**
     * @var string IPv4 正则
     * @author Verdient。
     */
    protected $ipv4Pattern = '/^(?:(?:2(?:[0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9])\.){3}(?:(?:2([0-4][0-9]|5[0-5])|[0-1]?[0-9]?[0-9]))$/';

    /**
     * @var string IPv6 正则
     * @author Verdient。
     */
    protected $ipv6Pattern = '/^(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))$/';

    /**
     * @var string 提示信息
     * @author Verdient。
     */
    public $message = '{name}必须是一个IP地址';

    /**
     * @var string 不支持IPv4的提示信息
     * @author Verdient。
     */
    public $ipv4NotAllowed = '{name}不支持IPv4';

    /**
     * @var string 不支持IPv6的提示信息
     * @author Verdient。
     */
    public $ipv6NotAllowed = '{name}不支持IPv6';

    /**
     * @var string 缺失子网信息时的提示信息
     * @author Verdient。
     */
    public $noSubnet = '{name}必须包含子网掩码信息';

    /**
     * @var string 包含子网信息时的提示信息
     * @author Verdient。
     */
    public $hasSubnet = '{name}必须不包含子网掩码信息';

    /**
     * @var string IP解析正则
     * @author Verdient。
     */
    protected $ipParsePattern = '/^(\!?)(.+?)(\/(\d+))?$/';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value)
    {
        if(!is_string($value)){
            return [$this->message];
        }
        list($negation, $ip, $cidr) = $this->parseIp($value);
        if($this->subnet === true && $cidr === null){
            return [$this->noSubnet];
        }
        if($this->subnet === false && $cidr !== null){
            return [$this->hasSubnet];
        }
        if($this->negation === false && $negation !== null){
            return [$this->message];
        }
        if($this->getIpVersion($ip) === 6){
            if($cidr !== null){
                if($cidr > 128 || $cidr < 0){
                    return [$this->wrongCidr];
                }
            }else{
                $cidr = 128;
            }
            if(!$this->ipv6){
                return [$this->ipv6NotAllowed];
            }
            if(!preg_match($this->ipv6Pattern, $value)){
                return [$this->message];
            }
        }else{
            if($cidr !== null){
                if($cidr > 32 || $cidr < 0){
                    return [$this->wrongCidr];
                }
            }else{
                $cidr = 32;
            }
            if(!$this->ipv4){
                return [$this->ipv4NotAllowed];
            }
            if(!preg_match($this->ipv4Pattern, $value)){
                return [$this->message];
            }
        }
        return [];
    }

    /**
     * 获取IP版本
     * @return int
     * @author Verdient。
     */
    protected function getIpVersion($value)
    {
        return strpos($value, ':') === false ? 4 : 6;
    }

    /**
     * 解析IP地址
     * @return array
     * @author Verdient。
     */
    protected function parseIp($value)
    {
        $negation = null;
        $cidr = null;
        $ip = $value;
        if(preg_match($this->ipParsePattern, $value, $matches)){
            $negation = ($matches[1] !== '') ? $matches[1] : null;
            $ip = $matches[2];
            $cidr = isset($matches[4]) ? $matches[4] : null;
        }
        return [$negation, $ip, $cidr];
    }
}
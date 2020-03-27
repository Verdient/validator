<?php
namespace Verdient\Validator\Validators;

/**
 * 电子邮件
 * @author Verdient。
 */
class Email extends \Verdient\Validator\Validator
{
	/**
	 * @var string 正则表达式
	 * @author Verdient。
	 */
	protected $pattern = '/^[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+(?:\.[a-zA-Z0-9!#$%&\'*+\\/=?^_`{|}~-]+)*@(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9-]*[a-zA-Z0-9])?$/';

	/**
	 * @var string 提示信息
	 * @author Verdient。
	 */
	public $message = '{name}必须是一个有效的电子邮件地址';

	/**
	 * @var bool 是否检查DNS
	 * @author Verdient。
	 */
	public $checkDNS = false;

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){
		if(!is_string($value)){
			return [$this->message];
		}elseif(!preg_match($this->pattern, $value)){
			return [$this->message];
		}else{
			if($this->checkDNS === true){
				if(!preg_match('/^(?P<name>(?:"?([^"]*)"?\s)?)(?:\s+)?(?:(?P<open><?)((?P<local>.+)@(?P<domain>[^>]+))(?P<close>>?))$/i', $value, $matches)){
					return [$this->message];
				}
				if(!$this->isDNSValid($matches['domain'])){
					return [$this->message];
				}
			}
		}
		return [];
	}

	/**
	 * 检查DNS是否合法
	 * @return bool
	 * @author Verdient。
	 */
	protected function isDNSValid($domain){
		if(checkdnsrr($domain . '.', 'MX')){
			$mxRecords = dns_get_record($domain . '.', DNS_MX);
			if($mxRecords !== false && count($mxRecords) > 0){
				return true;
			}
		}
		return false;
	}
}
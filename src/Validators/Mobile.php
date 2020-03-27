<?php
namespace Verdient\Validator\Validators;

/**
 * 手机号码
 * @author Verdient。
 */
class Mobile extends \Verdient\Validator\Validator
{
	/**
	 * @var string 正则表达式
	 * @author Verdient。
	 */
	protected $pattern = '/^(13[0-9]|14[57]|15[012356789]|16[68]|17[0135678]|18[0-9]|19[189])[0-9]{8}$/';

	/**
	 * @var string 提示信息
	 * @author Verdient。
	 */
	public $message = '{name}必须是一个手机号码';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){
		if(!preg_match($this->pattern, (string) $value)){
			return [$this->message];
		}
		return [];
	}
}
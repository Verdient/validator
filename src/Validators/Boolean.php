<?php
namespace Verdient\Validator\Validators;

/**
 * 布尔校验器
 * @author Verdient。
 */
class Boolean extends \Verdient\Validator\Validator
{
	/**
	 * @var string 提示信息
	 * @author Verdient。
	 */
	public $message = '{name}必须是一个布尔值';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){
		if(!in_array($value, [true, 1, '1', false, 0, '0'], true)){
			return [$this->message];
		}
		return [];
	}
}
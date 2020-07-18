<?php
namespace Verdient\Validator\Validators;

/**
 * 必填
 * @author Verdient。
 */
class Required extends \Verdient\Validator\Validator
{
	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	public $skipOnEmpty = false;

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	public $allowArray = true;

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	public $message = '{name}不能为空';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){
		if($this->isEmpty($value)){
			return [$this->message];
		}
		return [];
	}
}
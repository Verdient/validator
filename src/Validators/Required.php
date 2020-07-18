<?php
namespace Verdient\Validator\Validators;

use chorus\ArrayHelper;

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
	public $allowArray = false;

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	public $message = '{name}不能为空';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	public function validate($value, $name = '参数'){
		if($this->isEmpty($value)){
			$this->addError($this->message, [
				'name' => $name
			]);
			return false;
		}
		if($this->allowArray === true){
			foreach($value as $element){
				if($this->isEmpty($element)){
					$this->addError($this->message, [
						'name' => $name
					]);
					return false;
				}
			}
		}
		return true;
	}

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){}
}
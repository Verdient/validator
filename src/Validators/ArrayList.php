<?php
namespace Verdient\Validator\Validators;

use chorus\ArrayHelper;

/**
 * 数组校验器
 * @author Verdient。
 */
class ArrayList extends \Verdient\Validator\Validator
{
	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	public $message = '{name}必须为数组';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	public $noIndexd = '{name}必须为索引数组';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	public $allowArray = true;

	/**
	 * @var int 是否必须为索引数组
	 * @author Verdient。
	 */
	public $indexd = false;

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	public function validate($value, $name = '参数'){
		if(!is_array($value)){
			$this->addError($this->message, [
				'name' => $name
			]);
			return false;
		}
		if($this->indexd === true && !$this->isIndexd($value)){
			$this->addError($this->noIndexd, [
				'name' => $name
			]);
			return false;
		}
		return true;
	}

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){
		return [];
	}

	/**
	 * 是否是索引数组
	 * @param array $value 数组
	 * @return bool
	 * @author Verdient。
	 */
	protected function isIndexd($value){
		return ArrayHelper::isIndexed($value);
	}
}
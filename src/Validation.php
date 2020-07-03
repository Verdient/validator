<?php
namespace Verdient\Validator;

/**
 * 校验
 * @author Verdient。
 */
class Validation extends \chorus\BaseObject
{
	/**
	 * @var array 内置校验器
	 * @author Verdient。
	 */
	const BUILT_IN_VALIDATORS = [
		'required' => 'Verdient\Validator\Validators\Required',
		'string' => 'Verdient\Validator\Validators\Str',
		'mobile' => 'Verdient\Validator\Validators\Mobile',
		'in' => 'Verdient\Validator\Validators\In',
		'date' => 'Verdient\Validator\Validators\Date',
		'number' => 'Verdient\Validator\Validators\Number',
		'integer' => 'Verdient\Validator\Validators\Integer',
		'decimal' => 'Verdient\Validator\Validators\Decimal',
		'email' => 'Verdient\Validator\Validators\Email',
		'ip' => 'Verdient\Validator\Validators\Ip',
		'url' => 'Verdient\Validator\Validators\Url',
		'chineseIDCard' => 'Verdient\Validator\Validators\ChineseIDCard',
		'uuid' => 'Verdient\Validator\Validators\Uuid',
		'array' => 'Verdient\Validator\Validators\ArrayList',
		'bool' => 'Verdient\Validator\Validators\Boolean'
	];

	/**
	 * @var array 验证后的数据
	 * @author Verdient。
	 */
	protected $data = [];

	/**
	 * @var Errors 错误集合
	 * @author Verdient。
	 */
	protected $errors = null;

	/**
	 * @var Errors 限制条件
	 * @author Verdient。
	 */
	protected $constraints = [];

	/**
	 * 初始化
	 * @inheritdoc
	 * @author Verdient。
	 */
	public function init(){
		$this->errors = new Errors();
	}

	/**
	 * 校验
	 * @return bool
	 * @author Verdient。
	 */
	public function validate($data){
		if(!is_array($data)){
			$data = [];
		}
		foreach($this->constraints as $name => $constraints){
			foreach($constraints as $constraint){
				$class = array_shift($constraint);
				if(isset(static::BUILT_IN_VALIDATORS[$class])){
					$class = static::BUILT_IN_VALIDATORS[$class];
				}
				$validator = new $class($constraint);
				$exists = array_key_exists($name, $data);
				$value = $exists ? $data[$name] : null;
				if(!$validator->validate($value, $name)){
					unset($this->data[$name]);
					$this->errors->addError($name, $validator->getErrors());
				}else if($exists){
					$this->data[$name] = $value;
				}
			}
		}
		return !$this->errors->hasError();
	}

	/**
	 * 获取验证后的数据
	 * @return array
	 * @author Verdient。
	 */
	public function data(){
		return $this->data;
	}

	/**
	 * 是否有错误
	 * @return bool
	 * @author Verdient。
	 */
	public function hasError(){
		return $this->errors->hasError();
	}

	/**
	 * 获取错误集合
	 * @return Errors
	 * @author Verdient。
	 */
	public function getErrors(){
		return $this->errors;
	}
}
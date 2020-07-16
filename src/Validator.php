<?php
namespace Verdient\Validator;

/**
 * 校验器
 * @author Verdient。
 */
abstract class Validator extends \chorus\BaseObject
{
	/**
	 * @var Errors 错误集合
	 * @author Verdient。
	 */
	protected $errors = null;

	/**
	 * @var bool 是否在为空时跳过
	 * @author Verdient。
	 */
	public $skipOnEmpty = true;

	/**
	 * @var bool 是否允许数组
	 * @author Verdient。
	 */
	public $allowArray = false;

	/**
	 * @var string 提示信息
	 * @author Verdient。
	 */
	public $message = '{name}校验失败';

	/**
	 * @var string 元素为数组时的错误信息
	 * @author Verdient。
	 */
	public $isArray = '{name}不能为数组(对象)';

	/**
	 * 初始化
	 * @inheritdoc
	 * @author Verdient。
	 */
	public function init(){
		$this->errors = new Errors();
		$this->normalizeMessage();
	}

	/**
	 * 校验值是否合法
	 * @param mixed $value 值
	 * @param string $name 名称
	 * @return bool
	 * @author Verdient。
	 */
	public function validate($value, $name = '参数'){
		if(is_array($value)){
			if($this->allowArray !== true){
				$this->addError($this->isArray, [
					'name' => $name
				]);
				return false;
			}
		}else{
			$value = [$value];
		}
		foreach($value as $element){
			$result = $this->verify($element, $name);
			if(!empty($result)){
				foreach($result as $message){
					$this->addError($message, [
						'name' => $name
					]);
				}
				return false;
			}
		}
		return true;
	}

	/**
	 * 判断数据是否合法，子类必须实现这个方法
	 * 该方法和validate的区别是，validate会多一些限制性的操作，而verify则仅校验是否合法
	 * @param mixed $value 值
	 * @return array 如果校验合法返回空数组，否则返回错误信息的集合
	 * @author Verdient。
	 */
	abstract protected function verify($value);

	/**
	 * 添加错误
	 * @param string $message 消息
	 * @param array $params 替换参数
	 * @return Validator
	 * @author Verdient。
	 */
	public function addError($message, $params = []){
		foreach($params as $name => $value){
			$message = str_replace('{' . $name . '}', ($value ?: ''), $message);
		}
		$this->errors->addError(static::class, $message);
		return $this;
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
	 * @return array
	 * @author Verdient。
	 */
	public function getErrors(){
		return $this->errors;
	}

	/**
	 * 是否为空
	 * @param mixed $value 值
	 * @return boolean
	 * @author Verdient。
	 */
	public function isEmpty($value){
		return empty($value);
	}

	/**
	 * 消息映射关系
	 * @return array
	 * @author Verdient。
	 */
	protected function relations(){
		return [];
	}

	/**
	 * 格式化提示消息
	 * @author Verdient。
	 */
	protected function normalizeMessage(){
		foreach($this->relations() as $name => $message){
			if($this->$message){
				$this->$message = str_replace('{' . $name . '}', $this->$name, $this->$message);
			}else{
				$this->$message = $this->message;
			}
		}
	}
}
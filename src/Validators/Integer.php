<?php
namespace Verdient\Validator\Validators;

/**
 * 整数校验器
 * @author Verdient。
 */
class Integer extends \Verdient\Validator\Validator
{
	/**
	 * @var int 最小值
	 * @author Verdient。
	 */
	public $min = false;

	/**
	 * @var int 最大值
	 * @author Verdient。
	 */
	public $max = false;

	/**
	 * @var string 过小提示
	 * @author Verdient。
	 */
	public $tooSmall = '{name}不能小于{min}';

	/**
	 * @var string 过大提示
	 * @author Verdient。
	 */
	public $tooBig = '{name}不能大于{max}';

	/**
	 * @var string 提示信息
	 * @author Verdient。
	 */
	public $message = '{name}必须为整数';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){
		if(!is_numeric($value)){
			return [$this->message];
		}else{
			$message = [];
			if(strpos($value, '.') !== false){
				$message[] = $this->message;
			}else{
				if($this->min !== false && bccomp($value, $this->min, 0) === -1){
					$message[] = $this->tooSmall;
				}
				if($this->max !== false && bccomp($value, $this->max, 0) === 1){
					$message[] = $this->tooBig;
				}
			}
		}
		return $message;
	}

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function relations(){
		return ['min' => 'tooSmall', 'max' => 'tooBig'];
	}
}
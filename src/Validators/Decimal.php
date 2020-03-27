<?php
namespace Verdient\Validator\Validators;

/**
 * 小数
 * @author Verdient。
 */
class Decimal extends \Verdient\Validator\Validator
{
	/**
	 * @var int 小数点位数
	 * @author Verdient。
	 */
	public $decimal = 0;

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
	public $message = '{name}必须为数字';

	/**
	 * @var string 小数点后位数错误提示信息
	 * @author Verdient。
	 */
	public $wrongDecimal = '{name}小数点位数不得多于{decimal}位';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){
		if(!is_numeric($value)){
			return [$this->message];
		}
		$message = [];
		if($this->decimal > 0){
			if(!preg_match('/^-?[0-9]+(.[0-9]{1,' . $this->decimal . '})?$/', (string) $value)){
				$message[] = $this->wrongDecimal;
			}
		}
		if($this->min !== false && $value < $this->min){
			$message[] = $this->tooSmall;
		}
		if($this->max !== false && $value > $this->max){
			$message[] = $this->tooBig;
		}
		return $message;
	}

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function relations(){
		return ['min' => 'tooSmall', 'max' => 'tooBig', 'decimal' => 'wrongDecimal'];
	}
}
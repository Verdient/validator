<?php
namespace Verdient\Validator\Validators;

/**
 * 字符串
 * @author Verdient。
 */
class Str extends \Verdient\Validator\Validator
{
	/**
	 * @var int 最短长度
	 * @author Verdient。
	 */
	public $min = false;

	/**
	 * @var int 最大长度
	 * @author Verdient。
	 */
	public $max = false;

	/**
	 * @var int 长度
	 * @author Verdient。
	 */
	public $length = false;

	/**
	 * @var string 字符集
	 * @author Verdient。
	 */
	public $charset = false;

	/**
	 * @var string 提示信息
	 * @author Verdient。
	 */
	public $message = '{name}必须是一个字符串';

	/**
	 * @var string 长度过短提示语
	 * @author Verdient。
	 */
	public $tooShort = '{name}长度不得小于{min}';

	/**
	 * @var string 长度过长提示语
	 * @author Verdient。
	 */
	public $tooLong = '{name}长度不得大于{max}';

	/**
	 * @var string 长度错误提示语
	 * @author Verdient。
	 */
	public $wrongLength = '{name}长度必须为{length}';

	/**
	 * @var string 字符集错误提示语
	 * @author Verdient。
	 */
	public $wrongCharset = '{name}字符集必须为{charset}';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function relations(){
		return ['min' => 'tooShort', 'max' => 'tooLong', 'length' => 'wrongLength', 'charset' => 'wrongCharset'];
	}

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){
		$message = [];
		if(!is_string($value) && !is_numeric($value)){
			$message[] = $this->message;
		}else{
			$value = (string) $value;
			$charset = mb_internal_encoding();
			if($this->charset){
				if(!@mb_check_encoding($value, $this->charset)){
					$message[] = $this->wrongCharset;
				}else{
					$charset = $this->charset;
				}
			}
			if(is_integer($this->length)){
				$length = mb_strlen($value, $charset);
				if($length !== $this->length){
					$message[] = $this->wrongLength;
				}
			}else{
				$length = mb_strlen($value, $charset);
				if(is_integer($this->min) && ($length < $this->min)){
					$message[] = $this->tooShort;
				}
				if(is_integer($this->max) && ($length > $this->max)){
					$message[] = $this->tooLong;
				}
			}
		}
		return $message;
	}
}
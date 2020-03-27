<?php
namespace Verdient\Validator\Validators;

/**
 * URL
 * @author Verdient。
 */
class Url extends \Verdient\Validator\Validator
{
	/**
	 * @var string 校验正则
	 * @author Verdient。
	 */
	protected $pattern = '/^{schemes}:\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(?::\d{1,5})?(?:$|[?\/#])/i';

	/**
	 * @var array 允许的方案
	 * @author Verdient。
	 */
	public $schemes = ['http', 'https'];

	/**
	 * @var string 提示信息
	 * @author Verdient。
	 */
	public $message = '{name}必须是一个URL';

	/**
	 * @inheritdoc
	 * @author Verdient。
	 */
	protected function verify($value){
		if(is_string($value) && strlen($value) < 2000){
			if(strpos($this->pattern, '{schemes}') !== false) {
				$pattern = str_replace('{schemes}', '(' . implode('|', $this->schemes) . ')', $this->pattern);
			}else{
				$pattern = $this->pattern;
			}
			if(preg_match($pattern, $value)){
				return [];
			}
		}
		return [$this->message];
	}
}
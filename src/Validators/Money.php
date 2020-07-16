<?php
namespace Verdient\Validator\Validators;

/**
 * 金额校验器
 * @author Verdient。
 */
class Money extends Decimal
{
	/**
	 * @var int 小数点位数
	 * @author Verdient。
	 */
	public $decimal = 2;
}
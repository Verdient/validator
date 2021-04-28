<?php
namespace Verdient\Validator\Validators;

/**
 * 金额校验器
 * @author Verdient。
 */
class Money extends Decimal
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $decimal = 2;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $min = 0;
}
<?php
namespace Verdient\Validator\Validators;

/**
 * 安全校验器
 * @author Verdient。
 */
class Safe extends \Verdient\Validator\AbstractValidator
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
    public function validate($value, $name = '参数'){
        return true;
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function isEmpty($value)
    {
        return false;
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value){}
}
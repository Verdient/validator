<?php
namespace Verdient\Validator\Validators;

/**
 * 分页校验器
 * @author Verdient。
 */
class Pagination extends Integer
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $min = 1;
}
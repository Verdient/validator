<?php
namespace Verdient\Validator\Validators;

/**
 * UUID
 * @author Verdient。
 */
class Uuid extends \Verdient\Validator\AbstractValidator
{
    /**
     * @var int|string 版本
     * @author Verdient。
     */
    public $version = '*';

    /**
     * @var string 提示信息
     * @author Verdient。
     */
    public $message = '{name}必须是UUID';

    /**
     * @var array 正则集合
     * @author Verdient。
     */
    protected $patterns = [
        1 => '/^[0-9A-F]{8}-[0-9A-F]{4}-1[0-9A-F]{3}-[0-9A-F]{4}-[0-9A-F]{12}$/i',
        3 => '/^[0-9A-F]{8}-[0-9A-F]{4}-3[0-9A-F]{3}-[0-9A-F]{4}-[0-9A-F]{12}$/i',
        4 => '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i',
        5 => '/^[0-9A-F]{8}-[0-9A-F]{4}-5[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i',
        '*' => '/^[0-9A-F]{8}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{4}-[0-9A-F]{12}$/i',
    ];

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value)
    {
        if(!is_string($value)){
            return false;
        }
        if(!preg_match($this->patterns[$this->version], $value)){
            return [$this->message];
        }
        return [];
    }
}
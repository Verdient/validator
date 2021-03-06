<?php
namespace Verdient\Validator\Validators;

/**
 * 范围校验器
 * @author Verdient。
 */
class In extends \Verdient\Validator\AbstractValidator
{
    /**
     * @var array $range 范围
     * @author Verdient。
     */
    public $range = [];

    /**
     * @var bool 是否严格匹配
     * @author Verdient。
     */
    public $strict = false;

    /**
     * @var string 提示信息
     * @author Verdient。
     */
    public $message = '{name}不在指定范围内';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
        foreach($this->range as &$value){
            if(is_numeric($value)){
                $value = (string) $value;
            }
        }
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value)
    {
        if(is_numeric($value)){
            $value = (string) ($value);
        }
        if(!in_array($value, $this->range, $this->strict)){
            return [$this->message];
        }
        return [];
    }
}
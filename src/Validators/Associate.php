<?php

namespace Verdient\Validator\Validators;

use Verdient\Validator\AbstractValidator;
use Verdient\Validator\Validation;

/**
 * 关联数组校验器
 * @author Verdient。
 */
class Associate extends AbstractValidator
{
    /**
     * @var array 校验规则
     * @author Verdient。
     */
    public $rules = [];

    /**
     * @var int 是否允许存在未知的键值
     * @author Verdient。
     */
    public $allowUnknownKey = false;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $message = '{name}必须为包含关联数组(对象)的索引数组';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function validate($value, $name = '参数')
    {
        if(!is_array($value)){
            $this->addError($this->message, ['name' => $name]);
        }else{
            $attributes = array_keys($this->rules);
            $validation = new Validation(['constraints' => $this->rules]);
            if(!is_array($value)){
                $this->addError($this->message, ['name' => $name]);
            }else{
                if($this->allowUnknownKey !== true){
                    $unknownKeys = array_diff(array_keys($value), $attributes);
                    if(!empty($unknownKeys)){
                        $this->addError('未知的键名: ' . implode(', ', $unknownKeys));
                    }
                }
                if(!$validation->validate($value)){
                    $this->addError($validation->getErrors());
                }
            }
        }
        return !$this->hasError();
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value)
    {
    }
}
<?php

namespace Verdient\Validator\Validators;

use Verdient\Validator\AbstractValidator;
use Verdient\Validator\Validation;

/**
 * 组合校验器
 * @author Verdient。
 */
class Group extends AbstractValidator
{
    /**
     * @var array 校验规则
     * @author Verdient。
     */
    public $rules = [];

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $message = '{name}必须为包含对象的关联数组(对象)';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function validate($value, $name = '参数')
    {
        if(!is_array($value)){
            $this->addError($this->message, ['name' => $name]);
            return false;
        }
        $attributes = array_keys($this->rules);
        $validation = new Validation(['constraints' => $this->rules]);
        foreach($value as $element){
            if(!is_array($element)){
                $this->addError($this->message, ['name' => $name]);
                return false;
            }
            $unknownKeys = array_diff(array_keys($element), $attributes);
            if(!empty($unknownKeys)){
                $this->addError('未知的键名: ' . implode(', ', $unknownKeys));
                return false;
            }
            if($validation->validate($element)){
                return true;
            }else{
                $this->addError($validation->getErrors());
                return false;
            }
        }
        return true;
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value)
    {
    }
}
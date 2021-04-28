<?php
namespace Verdient\Validator\Validators;

/**
 * Snowflake校验器
 * @author Verdient。
 */
class Snowflake extends \Verdient\Validator\AbstractValidator
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $message = '{name}必须为Snowflake ID';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value)
    {
        if(!is_numeric($value)){
            return [$this->message];
        }else{
            $message = [];
            if(strpos($value, '.') !== false){
                $message[] = $this->message;
            }else if(bccomp($value, 0, 0) === -1){
                $message[] = $this->message;
            }else{
                $length = strlen((string) $value);
                if($length !== 18){
                    return [$this->message];
                }
            }
        }
        return $message;
    }
}
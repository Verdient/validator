<?php
namespace Verdient\Validator\Validators;

/**
 * 中国身份证号码
 * @author Verdient。
 */
class ChineseIDCard extends \Verdient\Validator\AbstractValidator
{
    /**
     * @var bool 是否允许15位身份证号码
     * @author Verdient。
     */
    public $enable15 = true;

    /**
     * @var string 正则表达式
     * @author Verdient。
     */
    protected $pattern = '/^(^[1-9]\d{7}((0\d)|(1[0-2]))(([0|1|2]\d)|3[0-1])\d{3}$)|(^[1-9]\d{5}[1-9]\d{3}(0[1-9]|(1[0-2]))(0[1-9]|([1|2])\d|3[0-1])((\d{4})|\d{3}[X])$)$/';

    /**
     * @var string 提示信息
     * @author Verdient。
     */
    public $message = '{name}必须是身份证号码';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value)
    {
        $value = strtoupper($value);
        if(preg_match($this->pattern, $value)){
            if(strlen($value) == 18){
                $value = str_split($value);
                $idCardWi = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                $idCardY = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
                $idCardWiSum = 0;
                for($i = 0; $i < 17; $i++){
                    $idCardWiSum += $value[$i] * $idCardWi[$i];
                }
                $idCardMod = $idCardWiSum % 11;
                if($value[17] == $idCardY[$idCardMod]){
                    return [];
                }
            }else{
                if($this->enable15 && strlen($value) == 15){
                    return [];
                }
            }
        }
        return [$this->message];;
    }
}
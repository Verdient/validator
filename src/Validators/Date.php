<?php
namespace Verdient\Validator\Validators;

/**
 * 日期校验器
 * @author Verdient。
 */
class Date extends \Verdient\Validator\AbstractValidator
{
    /**
     * @var string $format 格式
     * @author Verdient。
     */
    public $format = 'Y-m-d';

    /**
     * @var string $min 最小日期
     * @author Verdient。
     */
    public $min = false;

    /**
     * @var string $max 最大日期
     * @author Verdient。
     */
    public $max = false;

    /**
     * @var string 过小提示语
     * @author Verdient。
     */
    public $tooSmall = '{name}不得早于{min}';

    /**
     * @var string 过大提示语
     * @author Verdient。
     */
    public $tooBig = '{name}不得晚于{max}';

    /**
     * @var string 提示信息
     * @author Verdient。
     */
    public $message = '{name}必须是一个日期';

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value)
    {
        if(!$timestamp = $this->parseDateValue($value)){
            return [$this->message];
        }
        $message = [];
        if($this->min !== false){
            $min = $this->parseDateValue($this->min);
            if($timestamp < $min){
                $message[] = $this->tooSmall;
            }
        }
        if($this->max !== false){
            $max = $this->parseDateValue($this->max);
            if($timestamp > $max){
                $message[] = $this->tooBig;
            }
        }
        return $message;
    }

    /**
     * 解析日期值
     * @param string $value 要解析的日期字符串
     * @param string $format 日期格式
     * @return bool
     * @author Verdient。
     */
    protected function parseDateValue($value)
    {
        $hasTimeInfo = (strpbrk($this->format, 'HhGgisU') !== false);
        $date = \DateTime::createFromFormat($this->format, $value);
        $errors = \DateTime::getLastErrors();
        if($date === false || $errors['error_count'] || $errors['warning_count'] || $date->format($this->format) !== $value){
            return false;
        }
        if(!$hasTimeInfo){
            $date->setTime(0, 0, 0);
        }
        return $date->getTimestamp();
    }

    /**
     * 映射关系
     * @inheritdoc
     * @return array
     * @author Verdient。
     */
    protected function relations()
    {
        return ['min' => 'tooSmall', 'max' => 'tooBig'];
    }
}
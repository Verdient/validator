<?php
namespace Verdient\Validator\Validators;

use chorus\ArrayHelper;

/**
 * 数组校验器
 * @author Verdient。
 */
class ArrayList extends \Verdient\Validator\AbstractValidator
{
    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $message = '{name}必须为数组';

    /**
     * @var string 数组不是索引时的提示
     * @author Verdient。
     */
    public $noIndexd = '{name}必须为索引数组';

    /**
     * @var string 数组包含重复的值时的提示
     * @author Verdient。
     */
    public $hasDuplicate = '{name}不能包含重复的值';

    /**
     * @var string 过小提示
     * @author Verdient。
     */
    public $tooSmall = '{name}至少需要包含{min}个元素';

    /**
     * @var string 过大提示
     * @author Verdient。
     */
    public $tooBig = '{name}不能多于{max}个元素';

    /**
     * @var int 数组大小下限
     * @author Verdient。
     */
    public $min = false;

    /**
     * @var int 数组大小上限
     * @author Verdient。
     */
    public $max = false;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public $allowArray = true;

    /**
     * @var bool 是否必须为索引数组
     * @author Verdient。
     */
    public $indexd = false;

    /**
     * @var bool 是否不允许包含重复的值
     * @author Verdient。
     */
    public $distinct = false;

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function validate($value, $name = '参数')
    {
        if(!is_array($value)){
            $this->addError($this->message, [
                'name' => $name
            ]);
            return false;
        }
        $this->validateIndexed($value, $name);
        $this->validateDistinct($value, $name);
        $this->validateSize($value, $name);
        return !$this->hasError();
    }

    /**
     * 校验是否是索引数组
     * @param array $value 待校验的数组
     * @param string $name 参数名称
     * @author Verdient。
     */
    protected function validateIndexed($value, $name)
    {
        if($this->indexd === true && !$this->isIndexd($value)){
            $this->addError($this->noIndexd, [
                'name' => $name
            ]);
        }
    }

    /**
     * 校验重复值
     * @param array $value 待校验的数组
     * @param string $name 参数名称
     * @author Verdient。
     */
    protected function validateDistinct($value, $name)
    {
        if($this->distinct === true && (count(array_unique($value, SORT_REGULAR)) !== count(($value)))){
            $this->addError($this->hasDuplicate, [
                'name' => $name
            ]);
        }
    }

    /**
     * 校验大小
     * @param array $value 待校验的数组
     * @param string $name 参数名称
     * @author Verdient。
     */
    protected function validateSize($value, $name)
    {
        if(is_int($this->max) && count($value) > $this->max){
            $this->addError($this->tooBig, [
                'name' => $name
            ]);
        }
        if(is_int($this->min) && count($value) < $this->min){
            $this->addError($this->tooSmall, [
                'name' => $name
            ]);
        }
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function verify($value)
    {
        return [];
    }

    /**
     * 是否是索引数组
     * @param array $value 数组
     * @return bool
     * @author Verdient。
     */
    protected function isIndexd($value)
    {
        return ArrayHelper::isIndexed($value);
    }

    /**
     * @inheritdoc
     * @author Verdient。
     */
    protected function relations()
    {
        return [
            'max' => 'tooBig',
            'min' => 'tooSmall'
        ];
    }
}
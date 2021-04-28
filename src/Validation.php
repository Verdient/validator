<?php
namespace Verdient\Validator;

use chorus\Configurable;

/**
 * 校验
 * @author Verdient。
 */
class Validation extends \chorus\BaseObject
{
    use Configurable;

    /**
     * @var array 内置校验器
     * @author Verdient。
     */
    const BUILT_IN_VALIDATORS = [
        'required' => 'Verdient\Validator\Validators\Required',
        'string' => 'Verdient\Validator\Validators\Str',
        'mobile' => 'Verdient\Validator\Validators\Mobile',
        'in' => 'Verdient\Validator\Validators\In',
        'date' => 'Verdient\Validator\Validators\Date',
        'number' => 'Verdient\Validator\Validators\Number',
        'integer' => 'Verdient\Validator\Validators\Integer',
        'decimal' => 'Verdient\Validator\Validators\Decimal',
        'email' => 'Verdient\Validator\Validators\Email',
        'ip' => 'Verdient\Validator\Validators\Ip',
        'url' => 'Verdient\Validator\Validators\Url',
        'chineseIDCard' => 'Verdient\Validator\Validators\ChineseIDCard',
        'uuid' => 'Verdient\Validator\Validators\Uuid',
        'array' => 'Verdient\Validator\Validators\ArrayList',
        'bool' => 'Verdient\Validator\Validators\Boolean',
        'money' => 'Verdient\Validator\Validators\Money',
        'snowflake' => 'Verdient\Validator\Validators\Snowflake',
        'pagination' => 'Verdient\Validator\Validators\Pagination'
    ];

    /**
     * @var array 验证后的数据
     * @author Verdient。
     */
    protected $data = [];

    /**
     * @var Errors 错误集合
     * @author Verdient。
     */
    protected $errors = null;

    /**
     * @var Errors 限制条件
     * @author Verdient。
     */
    protected $constraints = [];

    /**
     * @inheritdoc
     * @author Verdient。
     */
    public function __construct($config = [])
    {
        $this->configuration($config);
        $this->errors = new Errors();
    }

    /**
     * 校验
     * @return bool
     * @author Verdient。
     */
    public function validate($data)
    {
        if(!is_array($data)){
            $data = [];
        }
        foreach($this->constraints as $name => $constraints){
            foreach($constraints as $constraint){
                if(isset($constraint['name'])){
                    $name2 = $constraint['name'];
                    unset($constraint['name']);
                }else{
                    $name2 = $name;
                }
                if($validator = $this->getValidator($constraint, $data)){
                    $exists = array_key_exists($name, $data);
                    $value = $exists ? $data[$name] : null;
                    if($validator->skipOnEmpty !== true || !$validator->isEmpty($value)){
                        if(!$validator->validate($value, $name2)){
                            unset($this->data[$name]);
                            $this->errors->addError($name2, $validator->getErrors());
                        }else if($exists){
                            $this->data[$name] = $value;
                        }
                    }
                }
            }
        }
        return !$this->errors->hasError();
    }

    /**
     * 获取校验器
     * @param string $class 类名称
     * @param $params 参数
     * @param $data 原始数据
     * @return Validator
     * @author Verdient。
     */
    protected function getValidator($constraint, $data)
    {
        $class = array_shift($constraint);
        if(isset(static::BUILT_IN_VALIDATORS[$class])){
            $class = static::BUILT_IN_VALIDATORS[$class];
        }
        if(isset($constraint['when'])){
            if(is_array($constraint['when'])){
                $when = $constraint['when'];
                $name = $when[0];
                $operator = $when[1];
                $value = isset($when[2]) ? $when[2] : null;
                if(!$this->compareValue($data, $name, $value, $operator)){
                    return null;
                }
            }
            unset($constraint['when']);
        }
        return new $class($constraint);
    }

    /**
     * 比较值
     * @param array $data 数据
     * @param string $name 名称
     * @param mixed $value 值
     * @param string $operator 操作符
     * @author Verdient。
     */
    protected function compareValue($data, $name, $value, $operator)
    {
        switch($operator){
            case '=':
                return isset($data[$name]) && $data[$name] == $value;
            case '!=':
                return isset($data[$name]) && $data[$name] != $value;
            case '>':
                return isset($data[$name]) && $data[$name] > $value;
            case '>=':
                return isset($data[$name]) && $data[$name] >= $value;
            case '<':
                return isset($data[$name]) && $data[$name] < $value;
            case '<=':
                return isset($data[$name]) && $data[$name] <= $value;
            case 'empty':
                return !isset($data[$name]) || empty($data[$name]);
            case 'notEmpty':
                return isset($data[$name]) && !empty($data[$name]);
            default:
                return false;
        }
    }

    /**
     * 获取验证后的数据
     * @return array
     * @author Verdient。
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * 是否有错误
     * @return bool
     * @author Verdient。
     */
    public function hasError()
    {
        return $this->errors->hasError();
    }

    /**
     * 获取错误集合
     * @return Errors
     * @author Verdient。
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
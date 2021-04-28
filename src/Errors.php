<?php
namespace Verdient\Validator;

/**
 * 错误集合
 * @author Verdient。
 */
class Errors
{
    /**
     * @var array 错误集合
     * @author Verdient。
     */
    protected $errors = [];

    /**
     * 添加错误
     * @param string $name 名称
     * @param string $message 错误信息
     * @return Error
     * @author Verdient。
     */
    public function addError($name, $message)
    {
        if(!isset($this->errors[$name])){
            $this->errors[$name] = [];
        }
        $this->errors[$name][] = $message;
        return $this;
    }

    /**
     * 获取错误
     * @return Errors
     * @author Verdient。
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * 获取是否有错误
     * @return bool
     * @author Verdient。
     */
    public function hasError()
    {
        return !empty($this->errors);
    }

    /**
     * 获取第一个错误
     * @return array|null
     * @author Verdient。
     */
    public function first()
    {
        if($this->hasError()){
            $errors = reset($this->errors);
            $name = key($errors);
            $message = reset($errors);
            if($message instanceof Errors){
                while($message instanceof Errors){
                    $errors = $message->getErrors();
                    $errors = reset($errors);
                    $message = reset($errors);
                }
                $message = reset($errors);
            }
            return [$name => $message];
        }
        return null;
    }

    /**
     * 转换为字符串
     * @return string
     * @author Verdient。
     */
    public function __toString()
    {
        if($error = $this->first()){
            $message = reset($error);
            return (string) $message;
        }
        return '';
    }
}
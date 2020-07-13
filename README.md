# 校验器

## 批量校验数据
```php
use Verdient\Validator\Validation;

/**
 * 限定条件，格式为数组
 * 第一级的Key为字段的名称，value为索引数组，数组内的每一个数组代表一个校验规则
 * 校验规则格式为：第一个元素为校验器的名字，其后的参数为注入到校验器内的参数
 */
$constraints = [
		'mobile' => [
			['mobile'], //规则1，要求必须是手机号码
			['string'], //规则2，要求必须是字符串
		],
		'date' => [
			['date', 'min' => '2020-02-02', 'max' => '2020-02-02'] //校验是否为日期，且最大最小日期均为2020-02-02
		],
		'in' => [
			['in', 'range' => [1, 2, 3]] //校验是否为1, 2, 3中的一个(或多个)
		], ...
];

/**
 * 要校验的数据
 */
$data = [
	'mobile' => '15757116316',
	'date' => '2020-02-02',
	'in' => 1, ...
];

$result = $validation->validate($data); //返回结果为true或false
```
## 校验单个数据
```php
use Verdient\Validator\Validators\In;

$validator = new In(['range' => [1, 2, 3]]);
$result = $validator->validate(4);
```
## 获取错误信息
```php
$errors = $validation->getErrors();
```
### 获取第一个错误
```php
$firstError = $errors->first(); //返回的结果为数组，key为字段名称，value为提示信息
```
### 直接取得错误提示信息
```php
$message = (string) $errors;
```
# 校验器及其参数
<table>
	<tr>
		<th>名称</th>
		<th>简述</th>
		<th>参数 [默认值]</th>
		<th>释义</th>
	</tr>
	<tr>
		<td>required</td>
		<td>校验是否为空</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td rowspan="8">string</td>
		<td rowspan="8">校验是否为字符串</td>
		<td>min [false]</td>
		<td>最小长度</td>
	</tr>
	<tr>
		<td>max [false]</td>
		<td>最大长度</td>
	</tr>
	<tr>
		<td>length [false]</td>
		<td>长度，当length和min或者max同时设置时，已length的设置为准</td>
	</tr>
	<tr>
		<td>charset [false]</td>
		<td>字符集</td>
	</tr>
	<tr>
		<td>tooShort</td>
		<td>长度过短时的提示信息</td>
	</tr>
	<tr>
		<td>tooLong</td>
		<td>长度过长时的提示信息</td>
	</tr>
	<tr>
		<td>wrongLength</td>
		<td>长度不匹配时的提示信息</td>
	</tr>
	<tr>
		<td>wrongCharset</td>
		<td>字符集不匹配时的提示信息</td>
	</tr>
	<tr>
		<td>mobile</td>
		<td>校验是否为合法的手机号码</td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td rowspan="2">in</td>
		<td rowspan="2">校验是否在给定的范围内</td>
		<td>range</td>
		<td>范围</td>
	</tr>
	<tr>
		<td>strict [false]</td>
		<td>是否严格匹配</td>
	</tr>
	<tr>
		<td rowspan="5">date</td>
		<td rowspan="5">校验是否为日期</td>
		<td>format [Y-m-d]</td>
		<td>格式</td>
	</tr>
	<tr>
		<td>min [false]</td>
		<td>最小日期</td>
	</tr>
	<tr>
		<td>max [false]</td>
		<td>最大日期</td>
	</tr>
	<tr>
		<td>tooSmall</td>
		<td>日期过小提示信息</td>
	</tr>
	<tr>
		<td>tooBig</td>
		<td>日期过大提示信息</td>
	</tr>
	<tr>
		<td rowspan="4">number | integer | decimal</td>
		<td rowspan="4">校验是否为数字 | 整数 | 小数</td>
		<td>min [false]</td>
		<td>最小</td>
	</tr>
	<tr>
		<td>max [false]</td>
		<td>最大</td>
	</tr>
	<tr>
		<td>tooSmall</td>
		<td>数字过小提示信息</td>
	</tr>
	<tr>
		<td>tooBig</td>
		<td>数字过大提示信息</td>
	</tr>
	<tr>
		<td>email</td>
		<td>校验是否为电子邮件地址</td>
		<td>checkDNS [false]</td>
		<td>是否检查DNS</td>
	</tr>
	<tr>
		<td rowspan="8">ip</td>
		<td rowspan="8">校验是否为IP地址</td>
		<td>ipv4 [true]</td>
		<td>是否允许IPv4地址</td>
	</tr>
	<tr>
		<td>ipv6 [true]</td>
		<td>是否允许IPv6地址</td>
	</tr>
	<tr>
		<td>subnet [false]</td>
		<td>子网信息 - false 不允许携带子网 | true 必须包含子网信息 | null 子网信息可选</td>
	</tr>
	<tr>
		<td>negation [false]</td>
		<td>是否允许包含取反标志位</td>
	</tr>
	<tr>
		<td>ipv4NotAllowed</td>
		<td>IPv4不被允许时的提示信息</td>
	</tr>
	<tr>
		<td>ipv6NotAllowed</td>
		<td>IPv6不被允许时的提示信息</td>
	</tr>
	<tr>
		<td>noSubnet</td>
		<td>不包含子网信息时的提示信息</td>
	</tr>
	<tr>
		<td>hasSubnet</td>
		<td>包含子网信息时的提示信息</td>
	</tr>
	<tr>
		<td>url</td>
		<td>校验是否为url地址</td>
		<td>schemes [http, https]</td>
		<td>允许的协议</td>
	</tr>
	<tr>
		<td>chineseIDCard</td>
		<td>校验是否为中国身份证号码</td>
		<td>enable15 [true]</td>
		<td>是否允许15位身份证号码(第一代身份证)</td>
	</tr>
	<tr>
		<td>uuid</td>
		<td>校验是否为UUID</td>
		<td>version [*]</td>
		<td>特定的版本，*代表所有版本</td>
	</tr>
	<tr>
		<td>array</td>
		<td>校验是否为数组</td>
		<td>indexded[false]</td>
		<td>是否仅索引数组</td>
	</tr>
	<tr>
		<td>bool</td>
		<td>校验是否为布尔值</td>
		<td></td>
		<td></td>
	</tr>
</table>

# 公共参数
<table>
	<tr>
		<th>名称</th>
		<th>简述</th>
		<th>参数 [默认值]</th>
		<th>释义</th>
	</tr>
	<tr>
		<td>skipOnEmpty</td>
		<td>是否在为空时跳过</td>
		<td>bool[true]</td>
		<td></td>
	</tr>
	<tr>
		<td>allowArray</td>
		<td>是否允许数组</td>
		<td>bool[true]</td>
		<td>当该值为true时，相当于循环调用校验器（除array校验器）</td>
	</tr>
	<tr>
		<td>message</td>
		<td>校验错误时的提示信息</td>
		<td>{name}校验失败</td>
		<td>{name}会被替换为属性名称</td>
	</tr>
	<tr>
		<td>isArray</td>
		<td>传入数据为数组时的提示信息</td>
		<td>{name}不能为数组(对象)</td>
		<td>仅在allowArray为false时生效</td>
	</tr>
	<tr>
		<td>when</td>
		<td>限定条件</td>
		<td>array[null]</td>
		<td>只有符合限定条件是时，校验器才会执行</td>
	</tr>
<table>

## 限定条件
可以在声明限定条件时指定when参数来限定校验器的执行，只有当限定条件满足时，校验器才会真正的被执行，否则将会跳过校验器的检查。

参数的格式为：
```php
$when = ['{name}', '{operator}', '{comparedValue}'];
```
name代指属性名称，operator为操作符，comparedValue为被比较的值

其中name和value必填，comparedValue默认为空

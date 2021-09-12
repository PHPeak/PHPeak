<?php

namespace PHPeak\Services;

use PHPeak\Enums\ValueType\Type;
use PHPeak\TypeHinting\AbstractValueType;
use PHPeak\TypeHinting\ArrayValueType;
use PHPeak\TypeHinting\ValueType;
use PHPeak\TypeHinting\ValueTypeImmutable;

class TypeService
{

	/**
	 * Guesses the type of a variable
	 *
	 * @param mixed $variable
	 * @return AbstractValueType
	 */
	public static function guessType(mixed $variable): AbstractValueType|ArrayValueType
	{
		$type = gettype($variable);

		switch($type) {
			case Type::ARRAY:
				$returnValue = self::guessArrayType($variable);
				break;

			case Type::OBJECT:
				$returnValue = new ValueTypeImmutable(get_class($variable));
				break;

			default:
				if(in_array($type, Type::CONVERT_TYPES)) {
					$returnValue = TYPE::CONVERT_TYPES[$type];
				} else {
					$returnValue = $type;
				}
				break;
		}

		return $returnValue;
	}

	public static function guessArrayType(array $variable): ArrayValueType
	{
		$firstKey = array_key_first($variable);
		$firstValue = array_shift($variable);

		$keyType = self::getType($firstKey);
		$valueType = self::getType($firstValue);

		foreach($variable as $key => $value) {
			//get type
			//check nullable
			//make nullable if applicable

			$vKeyType = self::getType($key);
			$vValueType = self::getType($value);

			//don't check for diff type if the value is null
			if($vKeyType->isNullable()) {
				$keyType->setIsNullable(true);
			} else if($keyType->getType() !== Type::MIXED && $vKeyType->getType() !== $keyType->getType()) {
				$keyType->setType(Type::MIXED);
			}

			if($vValueType->isNullable()) {
				$valueType->setIsNullable(true);
			} elseif($valueType->getType() !== Type::MIXED && $vValueType->getType() !== $valueType->getType()) {
				$valueType->setType(Type::MIXED);
			}

			if($valueType->getType() === Type::MIXED && $keyType->getType() === Type::MIXED) {
				break;
			}
		}

		return new ArrayValueType(new ValueTypeImmutable($keyType), new ValueTypeImmutable($valueType));
	}

	public static function makeTypeNullable(string $type): string
	{
		return Type::NULLABLE . ltrim($type, Type::NULLABLE);
	}

	public static function makeTypeArray(string $type): string
	{
		return rtrim($type, Type::ARRAY_SUFFIX) . Type::ARRAY_SUFFIX;
	}

	/**
	 * @param mixed $var
	 * @param string|null $compareToType Compare the $var's type to this type if defined
	 * 									 Used to ensure the types are the same
	 * 									 If $var is an int, and $compareToType is 'string', this method will return mixed
	 * 									 If $var is a string and $compareToType is 'string', this method will return 'string'
	 * 									 If $var is null and $compareToType is 'string', this method will return '?string'
	 * @return ValueType
	 */
	private static function getType(mixed $var, ?string $compareToType = null): ValueType
	{
		$type = gettype($var);

		if($type === Type::NULL) {
			$type = self::makeTypeNullable($type);
		}

		if($type === Type::ARRAY) {
			$type = self::makeTypeArray('mixed');
		}

		if($compareToType !== null && $compareToType !== $type) {
			$type = 'mixed';
		}

		return new ValueType($type);
	}

}

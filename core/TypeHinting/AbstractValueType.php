<?php

namespace PHPeak\TypeHinting;

use PHPeak\Enums\ValueType\Type;

abstract class AbstractValueType
{

	/**
	 * @var bool Whether the value is nullable or not
	 */
	protected bool $isNullable;

	/**
	 * @var bool Whether the value is an array or not
	 */
	protected bool $isArray;

	/**
	 * @var string The type of the value
	 */
	protected string $type;

	/**
	 * ValueType constructor.
	 *
	 * @param string|null $valueType Optionally pass a string like ?int, mixed, string[] to be parsed into a ValueType
	 */
	public function __construct(?string $valueType = null)
	{
		if($valueType === null) {
			return;
		}

		$this->isNullable = str_starts_with($valueType, '?');
		$this->isArray = str_ends_with($valueType, '[]');
		$type = ltrim(rtrim($valueType, '[]'), '?');

		//convert the type if needed, e.g. => int to integer
		//if no conversion is needed, default to the given Type
		$this->type = Type::CONVERT_TYPES[$type] ?? $type;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return bool
	 */
	public function isArray(): bool
	{
		return $this->isArray;
	}

	/**
	 * @return bool
	 */
	public function isNullable(): bool
	{
		return $this->isNullable;
	}

	public function __toString(): string
	{
		$result = '';

		if($this->isNullable) {
			$result .= Type::NULLABLE;
		}

		$result .= $this->type;

		if($this->isArray) {
			$result .= Type::ARRAY_SUFFIX;
		}

		return $result;
	}

}

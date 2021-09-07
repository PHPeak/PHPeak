<?php

namespace PHPeak\TypeHinting;

class ValueType extends AbstractValueType
{

	/**
	 * @param bool $isArray
	 * @return ValueType
	 */
	public function setIsArray(bool $isArray): ValueType
	{
		$this->isArray = $isArray;
		return $this;
	}

	/**
	 * @param string $type
	 * @return ValueType
	 */
	public function setType(string $type): ValueType
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @param bool $isNullable
	 * @return ValueType
	 */
	public function setIsNullable(bool $isNullable): ValueType
	{
		$this->isNullable = $isNullable;
		return $this;
	}

}

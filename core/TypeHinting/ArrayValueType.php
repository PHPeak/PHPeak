<?php

namespace PHPeak\TypeHinting;

class ArrayValueType
{

	public function __construct(
		private ValueTypeImmutable $keyType,
		private ValueTypeImmutable $valueType
	) {

	}

	/**
	 * @return ValueTypeImmutable
	 */
	public function getKeyType(): ValueTypeImmutable
	{
		return $this->keyType;
	}

	/**
	 * @return ValueTypeImmutable
	 */
	public function getValueType(): ValueTypeImmutable
	{
		return $this->valueType;
	}

}

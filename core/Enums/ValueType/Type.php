<?php

namespace PHPeak\Enums\ValueType;

use PHPeak\TypeHinting\AbstractValueType;

class Type extends AbstractValueType
{

	public const MIXED = 'mixed';
	public const ANY = self::MIXED;

	public const NULL = 'NULL';
	public const NULLABLE = '?';

	public const OBJECT = 'object';

	public const ARRAY = 'array';
	public const ARRAY_SUFFIX = '[]';

	public const BOOL = 'bool';

	public const BOOLEAN = self::BOOL;

	public const STRING = 'string';
	public const INT = 'int';
	public const INTEGER = self::INT;
	public const DOUBLE = 'double';

	public const FLOAT = self::DOUBLE;

	public const CONVERT_TYPES = [
		'boolean' => self::BOOLEAN,
		'integer' => self::INTEGER,
		'float' => self::FLOAT,
	];

}

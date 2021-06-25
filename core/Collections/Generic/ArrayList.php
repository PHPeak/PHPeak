<?php

namespace PHPeak\Collections\Generic;

use JetBrains\PhpStorm\Pure;
use PHPeak\Collections\KeyValuePair;

/**
 * Class Dictionary
 *
 * @package PHPeak\Collections\Generic
 * @property KeyValuePair[] $items
 */
final class ArrayList extends Generic // implements IList
{
	use Traits\GenericTrait;

	/**
	 * List constructor.
	 *
	 * @param string $valueType A nullable type to use for the value, e.g. ?string, int[], ?Parameter::Class, mixed
	 */
	#[Pure] public function __construct(
		string $valueType
	) {
		parent::__construct('int', $valueType);
	}

	public function add(mixed $value): int
	{
		$this->items[] = $value;

		return count($this->items) - 1;
	}

  /**
   * Remove the element with the given value
   *
   * @param $value
   */
	public function remove(mixed $value): void
	{
		$this->validateValueType($value);

		$this->items = array_filter($this->items, fn($item) => $item !== $value);
	}

	public function removeAt(int $index): void
	{
    	unset($this->items[$index]);
	}

	/**
	 * Get the value at the specified index or null
	 *
	 * @param int $index
	 * @return KeyValuePair|null
	 */
	public function getAt(int $index): ?KeyValuePair
	{
		return $this->items[$index] ?? null;
	}

	public function contains($value)
	{
		// TODO: Implement contains() method.
	}

}

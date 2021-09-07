<?php

use PHPeak\Collections\Generic\Dictionary;
use PHPeak\Exceptions\InvalidArgumentException ;
use PHPUnit\Framework\Testcase;

class DictionaryTest extends Testcase
{

	public function testCanCreateNewInstance(): void
	{
		$this->assertInstanceOf(
			Dictionary::class,
			new Dictionary('string', 'string')
		);
	}

	public function testCanSupportScalar(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'test';
		$value = '123';

		//act
		$dictionary->add($key, $value);

		//assert
		$this->assertEquals($dictionary->get($key)?->value, $value);
	}

	public function testCanSupportNullValue(): void
	{
		//arrange
		$dictionary = new Dictionary('string', '?string');
		$keys = ['0', '1'];
		$values = [null, '1234'];

		//act
		foreach($keys as $index => $key) {
			$dictionary->add($key, $values[$index]);
		}

		//assert - second loop for clarity
		foreach($keys as $index => $key) {
			$this->assertEquals($dictionary->get($key)->value, $values[$index]);
		}
	}

	public function testDeniesNullValue(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$this->expectException(InvalidArgumentException::class);

		//act
		$dictionary->add('key', null);
	}

	public function testDeniesNullableKey(): void
	{
		//arrange
		$this->expectExceptionObject(new InvalidArgumentException('Key may not be nullable'));

		//act
		new Dictionary('?string', '');
	}

	public function testDeniesWrongType(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'test';
		$value = 123;

		//act
		$this->expectException(InvalidArgumentException::class);
		$dictionary->add($key, $value);
	}

	public function testSupportForMixedType(): void
	{
		$this->expectNotToPerformAssertions();;

		//arrange
		$dictionary = new Dictionary('mixed', 'mixed');
		$keys = ['test', 123, [123], new Dictionary('string', 'string')];

		//act
		foreach($keys as $key) {
			$dictionary->add($key, $key);
		}
	}

	public function testSupportForArrayType(): void
	{
		$this->expectNotToPerformAssertions();

		//arrange
		$dictionary = new Dictionary('string', 'string[]');
		$key = 'test';
		$value = ['test'];

		//act
		$dictionary->add($key, $value);
	}

	public function testSupportForArrayTypeMixed(): void
	{
		$this->expectNotToPerformAssertions();

		//arrange
		$dictionary = new Dictionary('string', 'mixed[]');
		$key = 'test';
		$value = ['test', 123, new Dictionary('string', 'string')];

		//act
		$dictionary->add($key, $value);
	}

	public function testSupportForInvalidTypeInArray(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string[]');
		$key = 'test';
		$value = ['test', 123];

		//act
		$this->expectException(InvalidArgumentException::class);
		$this->expectExceptionObject(new InvalidArgumentException("Expected value to be of type 'string[]' but got 'integer'"));
		$dictionary->add($key, $value);
	}

	public function testSortingAscending(): void
	{
		//arrange
		$initial = [1, 4, 5, 3, 2];
		$expected = [1, 2, 3, 4, 5];
		//act



	}

	public function testSortingDescending(): void
	{
		//arrange
		$initial = [1, 4, 5, 3, 2];
		$expected = [1, 2, 3, 4, 5];
//		$dictionary = Dictionary::fromArray()
		//act



	}

	//foreach test
	//test for stable sort
}

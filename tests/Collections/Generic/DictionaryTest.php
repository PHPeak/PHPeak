<?php

use PHPeak\Collections\Generic\Dictionary;
use PHPeak\Collections\KeyValuePair;
use PHPeak\Exceptions\ArgumentOutOfRangeException;
use PHPeak\Exceptions\DuplicateKeyException;
use PHPeak\Exceptions\InvalidArgumentException ;
use PHPeak\Exceptions\InvalidKeyException;
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

	public function testDeniesDuplicateKeys(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'test';
		$value = '123';

		//act
		$dictionary->add($key, $value);

		//assert
		$this->expectException(DuplicateKeyException::class);
		$dictionary->add($key, $value);
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

	public function testGetAt(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'test';
		$value = '123';

		//act
		$index = $dictionary->add($key, $value);

		//assert
		$this->assertInstanceOf(KeyValuePair::class, $dictionary->getAt($index));
		$this->expectException(ArgumentOutOfRangeException::class);
		$dictionary->getAt(10);
	}

	public function testGet(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'test';
		$value = '123';

		//act
		$dictionary->add($key, $value);

		//assert
		$this->assertInstanceOf(KeyValuePair::class, $dictionary->get($key));
		$this->expectException(InvalidKeyException::class);
		$dictionary->get($key . 'asd');
	}

	public function testAssertKeyExists(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'test';
		$value = '123';

		//act
		$dictionary->add($key, $value);

		//assert
		$this->assertTrue($dictionary->keyExists($key));
		$this->assertFalse($dictionary->keyExists('asd'));
	}

	public function testAssertContains(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'test';
		$value = '123';

		//act
		$index = $dictionary->add($key, $value);
		$keyValuePair = $dictionary->getAt($index);

		//assert
		$this->assertTrue($dictionary->contains($keyValuePair));
		$this->assertFalse($dictionary->contains(new KeyValuePair($key . 'asd', '')));

		$this->expectException(InvalidArgumentException::class);
		$dictionary->contains(null);
	}

	public function testAssertIndexOfSingle(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'test';
		$value = '123';

		//act
		$index = $dictionary->add($key, $value);

		//assert
		$this->assertEquals($index, $dictionary->indexOf($key));
	}

	public function testAssertIndexOfMultiple(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'int');
		$keyPrefix = 'key';

		//act
		for($i = 0; $i < 10; $i++) {
			$dictionary->add($keyPrefix . $i, $i);
		}

		//assert
		for($i = 0; $i < 10; $i++) {
			$this->assertEquals($i, $dictionary->indexOf($keyPrefix . $i));
		}
	}

	public function testAssertToArraySingle(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'key';
		$value = 'value';

		//act
		$dictionary->add($key, $value);

		//assert
		$this->assertIsArray($dictionary->toArray());
		$this->assertEquals([
			'key' => 'value'
		], $dictionary->toArray());
	}

	public function testAssertToArrayMultiple(): void
	{
		//arrange
		$dictionary = new Dictionary('string', 'string');
		$key = 'key';
		$value = 'value';

		//act
		for($i = 0; $i < 10; $i++) {
			$dictionary->add($key . $i, $value);
		}

		//assert
		$this->assertIsArray($dictionary->toArray());

		$array = [];
		for($i = 0; $i < 10; $i++) {
			$array[$key . $i] = $value;
		}

		$this->assertEquals($array, $dictionary->toArray());
	}
}

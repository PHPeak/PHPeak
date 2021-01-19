<?php

namespace PHPeak\HTTP;

use PHPeak\Collections\Generic\Dictionary;

class Request
{

	public function __construct()
	{
		$this->query = new Dictionary('string', '?string');
	}

}

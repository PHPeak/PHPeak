<?php

namespace PHPeak\HTTP;

use PHPeak\Attributes\ServiceAttribute;
use PHPeak\Collections\Generic\Dictionary;

#[ServiceAttribute]
class Request
{

	private Dictionary $query;
	private Dictionary $post;
	private Dictionary $cookies;
	private Dictionary $session;

	public function __construct()
	{
		$this->query = new Dictionary('string', Parameter::class);
		$this->post = new Dictionary('string', Parameter::class);
		$this->cookies = new Dictionary('string', Parameter::class);
		$this->session = new Dictionary('string', Parameter::class);

		$this->parseVariables($_GET, $this->query);
		$this->parseVariables($_POST, $this->post);
		$this->parseVariables($_COOKIE, $this->cookies);
		$this->parseVariables($_SESSION, $this->session);
	}

	private function parseVariables(?array &$variables, Dictionary $dictionary)
	{
		if(!$variables) {
			return;
		}

		foreach($variables as $key => $value) {
			$dictionary->add($key, new Parameter($key, $value));
		}

		$variables = [];
	}

}

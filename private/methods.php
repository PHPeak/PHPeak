<?php

/**
 * FIXME this is ugly but I was done with having to type this every single time
 *
 * @param mixed ...$vars
 */
function dump(...$vars)
{
	echo "<pre>";
	var_dump(...$vars);
	echo "</pre><br/>";
}

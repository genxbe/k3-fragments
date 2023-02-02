<?php

/**
 * Fragments Helper
 */
if (!function_exists("__")) {
    function __($fragment, $placeholders = [])
    {
        return X\Fragments::fragment($fragment, $placeholders);
    }
}

/**
 * Resources Helper
 */
if(!function_exists('_r'))
{
    function _r($fragment, $placeholders = [], $returnNull = false)
    {
		if($returnNull)
		{
			$newFragment = X\Resources::resource($fragment, $placeholders);

			if($fragment == $newFragment)
			{
				return null;
			}
		}

		return X\Resources::resource($fragment, $placeholders);
    }
}

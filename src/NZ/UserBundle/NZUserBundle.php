<?php

namespace NZ\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NZUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}

<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\Event\Security;

interface SecurityEvents
{

	/**
	 * Occurs when the user is successfully logged in
	 */
	public const ON_LOGGED_IN = 'nette.security.loggedin';

	/**
	 * Occurs when the user is logged out
	 */
	public const ON_LOGGED_OUT = 'nette.security.loggedout';

}

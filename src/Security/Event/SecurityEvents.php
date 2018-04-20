<?php

namespace Contributte\Events\Extra\Security\Event;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
interface SecurityEvents
{

	/**
	 * Occurs when the user is successfully logged in
	 */
	const ON_LOGGED_IN = 'nette.security.loggedin';

	/**
	 * Occurs when the user is logged out
	 */
	const ON_LOGGED_OUT = 'nette.security.loggedout';

}

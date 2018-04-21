<?php

namespace Tests\Fixtures;

use Nette\Security\IIdentity;
use Nette\Security\IUserStorage;

/**
 * @author Milan Felix Sulc <sulcmil@gmail.com>
 */
final class FakeUserStorage implements IUserStorage
{

	/**
	 * Sets the authenticated status of this user.
	 *
	 * @param bool $state
	 * @return void
	 */
	public function setAuthenticated($state)
	{
	}

	/**
	 * Is this user authenticated?
	 *
	 * @return bool
	 */
	public function isAuthenticated()
	{
		return FALSE;
	}

	/**
	 * Sets the user identity.
	 *
	 * @param IIdentity $identity
	 * @return void
	 */
	public function setIdentity(IIdentity $identity = NULL)
	{
		// TODO: Implement setIdentity() method.
	}

	/**
	 * Returns current user identity, if any.
	 *
	 * @return IIdentity|NULL
	 */
	public function getIdentity()
	{
		return NULL;
	}

	/**
	 * Enables log out from the persistent storage after inactivity.
	 *
	 * @param  string|int|\DateTimeInterface $time number of seconds or timestamp
	 * @param  int $flags Clear the identity from persistent storage?
	 * @return void
	 */
	public function setExpiration($time, $flags = 0)
	{
	}

	/**
	 * Why was user logged out?
	 *
	 * @return int
	 */
	public function getLogoutReason()
	{
		return 0;
	}

}

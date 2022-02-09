<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use DateTimeInterface;
use Nette\Security\IIdentity;
use Nette\Security\IUserStorage;

final class FakeUserStorage implements IUserStorage
{

	/**
	 * Sets the authenticated status of this user.
	 *
	 * @phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
	 */
	public function setAuthenticated($state): void
	{
	}

	/**
	 * Is this user authenticated?
	 */
	public function isAuthenticated(): bool
	{
		return false;
	}

	/**
	 * Sets the user identity.
	 */
	public function setIdentity(?IIdentity $identity = null): void
	{
		// TODO: Implement setIdentity() method.
	}

	/**
	 * Returns current user identity, if any.
	 */
	public function getIdentity(): ?IIdentity
	{
		return null;
	}

	/**
	 * Enables log out from the persistent storage after inactivity.
	 *
	 * @param  string|int|DateTimeInterface $time  number of seconds or timestamp
	 * @param  int                          $flags Clear the identity from persistent storage?
	 */
	public function setExpiration($time, $flags = 0): void
	{
	}

	/**
	 * Why was user logged out?
	 */
	public function getLogoutReason(): int
	{
		return 0;
	}

}

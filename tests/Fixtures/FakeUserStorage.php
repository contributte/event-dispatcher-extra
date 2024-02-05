<?php declare(strict_types = 1);

namespace Tests\Fixtures;

use Nette\Security\IIdentity;
use Nette\Security\UserStorage;

final class FakeUserStorage implements UserStorage
{

	public function saveAuthentication(IIdentity $identity): void
	{
		// No-op
	}

	public function clearAuthentication(bool $clearIdentity): void
	{
		// No-op
	}

	/**
	 * {@inheritDoc}
	 */
	public function getState(): array
	{
		return [false, null, null];
	}

	public function setExpiration(?string $expire, bool $clearIdentity): void
	{
		// No-op
	}

}

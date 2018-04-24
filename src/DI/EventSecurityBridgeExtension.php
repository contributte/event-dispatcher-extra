<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Contributte\Events\Extra\Event\Security\LoggedInEvent;
use Contributte\Events\Extra\Event\Security\LoggedOutEvent;
use Contributte\Events\Extra\Event\Security\SecurityEvents;
use LogicException;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\PhpLiteral;
use Nette\Security\User;
use Symfony\Component\EventDispatcher\EventDispatcher;
use function sprintf;

class EventSecurityBridgeExtension extends CompilerExtension
{

	/**
	 * Build bridge into nette application events
	 */
	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		if ($builder->getByType(User::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', User::class));
		}

		if ($builder->getByType(EventDispatcher::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcher::class));
		}

		$user = $builder->getDefinition($builder->getByType(User::class));
		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcher::class));

		$user->addSetup('?->onLoggedIn[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			SecurityEvents::ON_LOGGED_IN,
			new PhpLiteral(LoggedInEvent::class),
		]);
		$user->addSetup('?->onLoggedOut[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			SecurityEvents::ON_LOGGED_OUT,
			new PhpLiteral(LoggedOutEvent::class),
		]);
	}

}

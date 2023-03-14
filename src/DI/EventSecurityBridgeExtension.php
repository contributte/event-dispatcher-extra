<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Contributte\Events\Extra\Event\Security\LoggedInEvent;
use Contributte\Events\Extra\Event\Security\LoggedOutEvent;
use LogicException;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\PhpGenerator\Literal;
use Nette\Security\User;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

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

		if ($builder->getByType(EventDispatcherInterface::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcherInterface::class));
		}

		$user = $builder->getDefinition($builder->getByType(User::class));
		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcherInterface::class));

		assert($user instanceof ServiceDefinition);
		$user->addSetup('?->onLoggedIn[] = function() {?->dispatch(new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			new Literal(LoggedInEvent::class),
		]);
		$user->addSetup('?->onLoggedOut[] = function() {?->dispatch(new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			new Literal(LoggedOutEvent::class),
		]);
	}

}

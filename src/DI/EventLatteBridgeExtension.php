<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Contributte\Events\Extra\Event\Latte\LatteCompileEvent;
use Contributte\Events\Extra\Event\Latte\LatteEvents;
use LogicException;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\PhpLiteral;
use Symfony\Component\EventDispatcher\EventDispatcher;

class EventLatteBridgeExtension extends CompilerExtension
{

	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		if ($builder->getByType(ILatteFactory::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', ILatteFactory::class));
		}

		if ($builder->getByType(EventDispatcher::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcher::class));
		}

		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcher::class));

		$latteEngine = $builder->getDefinition($builder->getByType(ILatteFactory::class));

		$latteEngine->addSetup('?->onCompile[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			LatteEvents::ON_LATTE_COMPILE,
			new PhpLiteral(LatteCompileEvent::class),
		]);
	}

}

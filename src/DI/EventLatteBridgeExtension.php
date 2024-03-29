<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Contributte\Events\Extra\Event\Latte\TemplateCreateEvent;
use Contributte\Events\Extra\Latte\EventExtension;
use LogicException;
use Nette\Bridges\ApplicationLatte\LatteFactory;
use Nette\Bridges\ApplicationLatte\TemplateFactory;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\FactoryDefinition;
use Nette\DI\Definitions\ServiceDefinition;
use Nette\DI\Definitions\Statement;
use Nette\PhpGenerator\Literal;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventLatteBridgeExtension extends CompilerExtension
{

	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		if ($builder->getByType(LatteFactory::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', LatteFactory::class));
		}

		if ($builder->getByType(EventDispatcherInterface::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcherInterface::class));
		}

		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcherInterface::class));

		$latteEngine = $builder->getDefinition($builder->getByType(LatteFactory::class));
		assert($latteEngine instanceof FactoryDefinition);

		$latteEngine
			->getResultDefinition()
			->addSetup('addExtension', [new Statement(EventExtension::class)]);

		$templateFactories = $builder->findByType(TemplateFactory::class);
		foreach ($templateFactories as $templateFactory) {
			assert($templateFactory instanceof ServiceDefinition);

			$templateFactory->addSetup('?->onCreate[] = function() {?->dispatch(new ?(...func_get_args()));}', [
				'@self',
				$dispatcher,
				new Literal(TemplateCreateEvent::class),
			]);
		}
	}

}

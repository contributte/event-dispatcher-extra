<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Contributte\Events\Extra\Event\Latte\LatteCompileEvent;
use Contributte\Events\Extra\Event\Latte\TemplateCreateEvent;
use LogicException;
use Nette\Application\UI\ITemplateFactory;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Bridges\ApplicationLatte\TemplateFactory;
use Nette\DI\CompilerExtension;
use Nette\DI\Definitions\FactoryDefinition;
use Nette\DI\ServiceDefinition;
use Nette\PhpGenerator\PhpLiteral;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class EventLatteBridgeExtension extends CompilerExtension
{

	public function beforeCompile(): void
	{
		$builder = $this->getContainerBuilder();

		if ($builder->getByType(ILatteFactory::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', ILatteFactory::class));
		}

		if ($builder->getByType(EventDispatcherInterface::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcherInterface::class));
		}

		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcherInterface::class));

		$latteEngine = $builder->getDefinition($builder->getByType(ILatteFactory::class));
		assert($latteEngine instanceof FactoryDefinition);

		$latteEngine
			->getResultDefinition()
			->addSetup('?->onCompile[] = function() {?->dispatch(new ?(...func_get_args()));}', [
				'@self',
				$dispatcher,
				new PhpLiteral(LatteCompileEvent::class),
			]);

		$templateFactories = $builder->findByType(ITemplateFactory::class);
		foreach ($templateFactories as $templateFactory) {
			assert($templateFactory instanceof ServiceDefinition);
			if ($templateFactory->factory === null || $templateFactory->factory->entity !== TemplateFactory::class) {
				continue;
			}

			$templateFactory->addSetup('?->onCreate[] = function() {?->dispatch(new ?(...func_get_args()));}', [
				'@self',
				$dispatcher,
				new PhpLiteral(TemplateCreateEvent::class),
			]);
		}
	}

}

<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Contributte\Events\Extra\Event\Latte\LatteCompileEvent;
use Contributte\Events\Extra\Event\Latte\LatteEvents;
use Contributte\Events\Extra\Event\Latte\TemplateCreateEvent;
use LogicException;
use Nette\Application\UI\ITemplateFactory;
use Nette\Bridges\ApplicationLatte\ILatteFactory;
use Nette\Bridges\ApplicationLatte\TemplateFactory;
use Nette\DI\CompilerExtension;
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
		$latteEngine->addSetup('?->onCompile[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
			'@self',
			$dispatcher,
			LatteEvents::ON_LATTE_COMPILE,
			new PhpLiteral(LatteCompileEvent::class),
		]);

		$templateFactoryName = $builder->getByType(ITemplateFactory::class);
		if ($templateFactoryName !== null) {
			$templateFactory = $builder->getDefinition($templateFactoryName);
			if ($templateFactory->factory !== null && $templateFactory->factory->entity !== TemplateFactory::class) {
				throw new LogicException(sprintf('Service "%s" must be instance of "%s" to support TemplateCreateEvent.', $templateFactoryName, TemplateFactory::class));
			}

			$templateFactory->addSetup('?->onCreate[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
				'@self',
				$dispatcher,
				LatteEvents::ON_TEMPLATE_CREATE,
				new PhpLiteral(TemplateCreateEvent::class),
			]);
		}
	}

}

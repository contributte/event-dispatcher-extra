<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Contributte\Events\Extra\Event\Application\ApplicationEvents;
use Contributte\Events\Extra\Event\Application\FormBeforeRenderEvent;
use Contributte\Events\Extra\Forms\FormFactory;
use LogicException;
use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\PhpLiteral;
use Symfony\Component\EventDispatcher\EventDispatcher;

class FormsExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		if ($builder->getByType(EventDispatcher::class) === null) {
			throw new LogicException(sprintf('Service of type "%s" is needed. Please register it.', EventDispatcher::class));
		}

		$dispatcher = $builder->getDefinition($builder->getByType(EventDispatcher::class));

		$builder->addDefinition($this->prefix('formFactory'))
			->setImplement(FormFactory::class)
			->addSetup('?->onBeforeRender[] = function() {?->dispatch(?, new ?(...func_get_args()));}', [
				'@self',
				$dispatcher,
				ApplicationEvents::ON_FORM_BEFORE_RENDER,
				new PhpLiteral(FormBeforeRenderEvent::class),
			]);
	}

}

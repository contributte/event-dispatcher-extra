<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Contributte\Events\Extra\Latte\TemplateFactory;
use Nette\Bridges\ApplicationDI\LatteExtension as NetteLatteExtension;
use Nette\DI\CompilerExtension;
use RuntimeException;

class LatteExtension extends CompilerExtension
{

	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();

		if (!$builder->hasDefinition('latte.templateFactory')) {
			throw new RuntimeException(sprintf(
				'Extension %s requires extension of type %s under name %s',
				$this->name,
				NetteLatteExtension::class,
				'latte'
			));
		}

		$netteTemplateFactory = $builder->getDefinition('latte.templateFactory')
			->setAutowired(false);

		$builder->addDefinition($this->prefix('templateFactory'))
			->setType(TemplateFactory::class)
			->setArguments([$netteTemplateFactory]);
	}

}

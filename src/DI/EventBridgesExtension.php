<?php declare(strict_types = 1);

namespace Contributte\Events\Extra\DI;

use Nette\DI\CompilerExtension;
use Nette\PhpGenerator\ClassType;
use Nette\Schema\Expect;
use Nette\Schema\Schema;

/**
 * @property-read mixed[] $config
 */
class EventBridgesExtension extends CompilerExtension
{

	public function getConfigSchema(): Schema
	{
		return Expect::structure([
			'application' => Expect::anyOf(false),
			'latte' => Expect::anyOf(false),
			'security' => Expect::anyOf(false),
		])->castTo('array');
	}

	/** @var string[] */
	private $map = [
		'application' => EventApplicationBridgeExtension::class,
		'latte' => EventLatteBridgeExtension::class,
		'security' => EventSecurityBridgeExtension::class,
	];

	/** @var CompilerExtension[] */
	private $passes = [];

	/**
	 * Register services
	 */
	public function loadConfiguration(): void
	{
		$config = $this->config;
		foreach ($config as $bridge => $bridgeConfig) {
			// Don't register sub extension
			if ($bridgeConfig === false) {
				continue;
			}

			// Register sub extension a.k.a CompilerPass
			$this->passes[$bridge] = new $this->map[$bridge]();
			$this->passes[$bridge]->setCompiler($this->compiler, $this->prefix($bridge));
			$this->passes[$bridge]->setConfig($bridgeConfig);

			if ($bridgeConfig !== null) {
				$this->passes[$bridge]->setConfig($bridgeConfig);
			}

			$this->passes[$bridge]->loadConfiguration();
		}
	}

	/**
	 * Decorate services
	 */
	public function beforeCompile(): void
	{
		foreach ($this->passes as $pass) {
			$pass->beforeCompile();
		}
	}

	/**
	 * Decorate initialize method
	 */
	public function afterCompile(ClassType $class): void
	{
		foreach ($this->passes as $pass) {
			$pass->afterCompile($class);
		}
	}

}

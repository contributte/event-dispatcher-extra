![](https://heatbadger.now.sh/github/readme/contributte/event-dispatcher-extra/)

<p align=center>
  <a href="https://github.com/contributte/event-dispatcher-extra/actions"><img src="https://badgen.net/github/checks/contributte/event-dispatcher-extra/master?cache=300"></a>
  <a href="https://coveralls.io/r/contributte/event-dispatcher-extra"><img src="https://badgen.net/coveralls/c/github/contributte/event-dispatcher-extra?cache=300"></a>
  <a href="https://packagist.org/packages/contributte/event-dispatcher-extra"><img src="https://badgen.net/packagist/dm/contributte/event-dispatcher-extra"></a>
  <a href="https://packagist.org/packages/contributte/event-dispatcher-extra"><img src="https://badgen.net/packagist/v/contributte/event-dispatcher-extra"></a>
</p>
<p align=center>
  <a href="https://packagist.org/packages/contributte/event-dispatcher-extra"><img src="https://badgen.net/packagist/php/contributte/event-dispatcher-extra"></a>
  <a href="https://github.com/contributte/event-dispatcher-extra"><img src="https://badgen.net/github/license/contributte/event-dispatcher-extra"></a>
  <a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
  <a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
  <a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/sponsor/donations/F96854"></a>
</p>

<p align=center>
Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

Extra event bridges for Nette Application, Security and Latte events using Symfony Event Dispatcher.

## Versions

| State       | Version | Branch   | Nette | PHP     |
|-------------|---------|----------|-------|---------|
| dev         | `^0.11` | `master` | 3.1+  | `>=8.1` |
| stable      | `^0.10` | `master` | 3.1+  | `>=8.1` |

## Installation

To install the latest version of `contributte/event-dispatcher-extra` use [Composer](https://getcomposer.org).

```bash
composer require contributte/event-dispatcher-extra
```

## Setup

First of all, setup an event dispatcher integration (e.g. [contributte/event-dispatcher](https://github.com/contributte/event-dispatcher/)).

Register extension:

```neon
extensions:
	# register all event bridges
	events.extra: Contributte\Events\Extra\DI\EventBridgesExtension

events.extra:
	# optionally disable these bridges
	application: false
	security: false
	latte: false
```

You can also register bridges one by one.

```neon
extensions:
	# register only bridges of your choice
	events.application: Contributte\Events\Extra\DI\EventApplicationBridgeExtension
	events.security: Contributte\Events\Extra\DI\EventSecurityBridgeExtension
	events.latte: Contributte\Events\Extra\DI\EventLatteBridgeExtension
```

## Events list

There are several events on which you can listen to.

**Nette Application events:**

Connected to `Nette\Application\Application` events.

```php
use Contributte\Events\Extra\Event\Application\StartupEvent;
use Contributte\Events\Extra\Event\Application\RequestEvent;
use Contributte\Events\Extra\Event\Application\PresenterEvent;
use Contributte\Events\Extra\Event\Application\ResponseEvent;
use Contributte\Events\Extra\Event\Application\ShutdownEvent;
use Contributte\Events\Extra\Event\Application\ErrorEvent;
```

Connected to `Nette\Application\UI\Presenter` events (`Nette\Application\IPresenter` is not supported).

```php
use Contributte\Events\Extra\Event\Application\PresenterStartupEvent;
use Contributte\Events\Extra\Event\Application\PresenterShutdownEvent;
```

**Latte events:**

Connected to `Latte\Engine::$onCompile` event.

```php
use Contributte\Events\Extra\Event\Latte\LatteBeforeCompileEvent;
```

Connected to `Latte\Extension::beforeRender()` event.

```php
use Contributte\Events\Extra\Event\Latte\LatteBeforeRenderEvent;
```

Connected to `Nette\Bridges\ApplicationLatte\TemplateFactory::$onCreate` event.

```php
use Contributte\Events\Extra\Event\Latte\TemplateCreateEvent;
```

**Nette Security events:**

Connected to `Nette\Security\User` `$onLoggedIn` and `$onLoggedOut` events.

```php
use Contributte\Events\Extra\Event\Security\LoggedInEvent;
use Contributte\Events\Extra\Event\Security\LoggedOutEvent;
```

## Subscriber

```php
use Contributte\Events\Extra\Event\Application\RequestEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class LogRequestSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [RequestEvent::class => 'onLog'];
    }

    public function onLog(RequestEvent $event): void
    {
        // Do magic..
    }

}
```

## Development

See [how to contribute](https://contributte.org/contributing.html) to this package.

This package is currently maintained by these authors.

<a href="https://github.com/f3l1x">
  <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

-----

Consider to [support](https://contributte.org/partners.html) **contributte** development team.
Also thank you for using this package.

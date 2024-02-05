# Contributte Event Dispatcher Extra

## Content

- [Setup](#setup)
- [Events list](#events-list)
- [Implementing subscriber](#subscriber)

## Setup

First of all, setup an event dispatcher integration (e.g. [contributte/event-dispatcher](https://github.com/contributte/event-dispatcher/))

Install package

```bash
composer require contributte/event-dispatcher-extra
```

Register extension

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

Connected to `Nette\Application\Application` events

```php
use Contributte\Events\Extra\Event\Application\StartupEvent;
use Contributte\Events\Extra\Event\Application\RequestEvent;
use Contributte\Events\Extra\Event\Application\PresenterEvent;
use Contributte\Events\Extra\Event\Application\ResponseEvent;
use Contributte\Events\Extra\Event\Application\ShutdownEvent;
use Contributte\Events\Extra\Event\Application\ErrorEvent;
```

Connected to `Nette\Application\UI\Presenter` events (`Nette\Application\IPresenter` is not supported)

```php
use Contributte\Events\Extra\Event\Application\PresenterStartupEvent;
use Contributte\Events\Extra\Event\Application\PresenterShutdownEvent;
```

**Latte events:**

Connected to `Latte\Engine::$onCompile` event

```php
use Contributte\Events\Extra\Event\Latte\LatteBeforeCompileEvent;
```

Connected to `Nette\Bridges\ApplicationLatte\TemplateFactory::$onCreate` event

```php
use Contributte\Events\Extra\Event\Latte\TemplateCreateEvent;
```

**Nette Security events:**

Connected to `Nette\Security\User` `$onLoggedIn` and `$onLoggedOut` events

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

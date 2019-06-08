# Contributte Event Dispatcher Extra

## Content

- [Setup](#setup)
- [Events list](#events-list)
- [Implementing subscriber](#subscriber)

## Setup

```bash
composer require contributte/event-dispatcher-extra
```

```yaml
extensions:
    events: Contributte\EventDispatcher\DI\EventDispatcherExtension

    # register all event bridges
    events.extra: Contributte\Events\Extra\DI\EventBridgesExtension

events.extra:
    # optionally disable these bridges
    application: false
    security: false
    latte: false
```

You can also register bridges one by one.

```yaml
extensions:
    # register only bridges of your choice
    events.application: Contributte\Events\Extra\DI\EventApplicationBridgeExtension
    events.security: Contributte\Events\Extra\DI\EventSecurityBridgeExtension
    events.latte: Contributte\Events\Extra\DI\EventLatteBridgeExtension
```

## Events list

There are several events on which you can listen to.

**Nette Application events:**

```php
use Contributte\Events\Extra\Event\Application\ApplicationEvents;
use Contributte\Events\Extra\Event\Application\ErrorEvent;
use Contributte\Events\Extra\Event\Application\PresenterEvent;
use Contributte\Events\Extra\Event\Application\PresenterStartupEvent;
use Contributte\Events\Extra\Event\Application\PresenterShutdownEvent;
use Contributte\Events\Extra\Event\Application\RequestEvent;
use Contributte\Events\Extra\Event\Application\ResponseEvent;
use Contributte\Events\Extra\Event\Application\ShutdownEvent;
use Contributte\Events\Extra\Event\Application\StartupEvent;
```

- `StartupEvent::NAME` && `ApplicationEvents::ON_STARTUP`
- `ShutdownEvent::NAME` && `ApplicationEvents::ON_SHUTDOWN`
- `RequestEvent::NAME` && `ApplicationEvents::ON_REQUEST`
- `PresenterEvent::NAME` && `ApplicationEvents::ON_PRESENTER`
- `PresenterStartupEvent::NAME` && `ApplicationEvents::ON_PRESENTER_STARTUP`
- `PresenterShutdownEvent::NAME` && `ApplicationEvents::ON_PRESENTER_SHUTDOWN`
- `ResponseEvent::NAME` && `ApplicationEvents::ON_RESPONSE`
- `ErrorEvent::NAME` && `ApplicationEvents::ON_ERROR`

**Nette Latte events:**

```php
use Contributte\Events\Extra\Event\Latte\LatteEvents;
use Contributte\Events\Extra\Event\Latte\LatteCompileEvent;
use Contributte\Events\Extra\Event\Latte\TemplateCreateEvent;
```

- `LatteCompileEvent::NAME` && `LatteEvents::ON_LATTE_COMPILE`
- `TemplateCreateEvent::NAME` && `LatteEvents::ON_TEMPLATE_CREATE`

**Nette Security events:**

```php
use Contributte\Events\Extra\Event\Security\LoggedInEvent;
use Contributte\Events\Extra\Event\Security\LoggedOutEvent;
```

- `LoggedInEvent::NAME` && `SecurityEvents::ON_LOGGED_IN`
- `LoggedOutEvent::NAME` && `SecurityEvents::ON_LOGGED_OUT`

## Subscriber

```php
use Contributte\EventDispatcher\EventSubscriber;
use Contributte\Events\Extra\Event\Application\RequestEvent;

final class LogRequestSubscriber implements EventSubscriber
{

    public static function getSubscribedEvents(): array
    {
        return [RequestEvent::NAME => 'onLog'];
    }

    public function onLog(RequestEvent $event): void
    {
        // Do magic..
    }
}
```

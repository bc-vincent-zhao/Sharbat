<?php

namespace Sharbat\Inject;

use Sharbat\Inject\Binder\Matcher;
use Sharbat\Intercept\Interceptor;
use \RuntimeException;

abstract class AbstractModule implements Binder {
  /**
   * @var Binder
   */
  private $binder;

  public function setBinder(Binder $binder) {
    $this->binder = $binder;
  }

  abstract public function configure();

  /**
   * @param string $qualifiedClassName
   * @return \Sharbat\Inject\Binder\LinkedBindingBuilder
   */
  public function bind($qualifiedClassName) {
    return $this->binder->bind($qualifiedClassName);
  }

  /**
   * @param string $constant
   * @return \Sharbat\Inject\Binder\ConstantBinding
   */
  public function bindConstant($constant) {
    return $this->binder->bindConstant($constant);
  }

  public function bindInterceptor(Matcher $classMatcher, Matcher $methodMatcher,
      Interceptor $interceptor) {
    call_user_func_array(array($this->binder, __FUNCTION__), func_get_args());
  }

  public function install(AbstractModule $module) {
    return $this->binder->install($module);
  }

  public function build() {
    throw new RuntimeException('Unsupported operation');
  }

  public function requestInjection($instance) {
    $this->binder->requestInjection($instance);
  }
}

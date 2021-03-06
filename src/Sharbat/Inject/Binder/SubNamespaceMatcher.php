<?php

namespace Sharbat\Inject\Binder;

use Sharbat\Inject\Annotatable;

class SubNamespaceMatcher extends AbstractMatcher {
  private $qualifiedNamespaceName;

  public function __construct($qualifiedNamespaceName) {
    $this->qualifiedNamespaceName = $qualifiedNamespaceName;
  }

  public function matches($T, Annotatable $annotatable) {
    /** @var \Sharbat\Reflect\Clazz $annotatable */
    return $annotatable->inNamespaceOrSub($this->qualifiedNamespaceName);
  }
}

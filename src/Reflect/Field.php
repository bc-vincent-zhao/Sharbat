<?php

namespace Sharbat\Reflect;

use Sharbat\Inject\Annotatable;
use \ReflectionProperty;

class Field implements Annotatable {

  /**
   * @var \ReflectionProperty
   */
  private $reflection;

  /**
   * @var \Sharbat\Inject\Annotation[]
   */
  private $annotations = array();

  /**
   * @var \Sharbat\Reflect\Clazz
   */
  private $declaringClass;

  public function __construct(ReflectionProperty $reflection, array $annotations,
      Clazz $declaringClass) {
    $this->reflection = $reflection;
    $this->annotations = $annotations;
    $this->declaringClass = $declaringClass;
  }

  /**
   * @return \ReflectionProperty
   */
  public function getInternalReflection() {
    return $this->reflection;
  }

  /**
   * @param string $qualifiedClassName
   * @return \Sharbat\Inject\Annotation
   */
  public function getAnnotation($qualifiedClassName) {
    foreach ($this->annotations as $annotation) {
      if ($annotation instanceof $qualifiedClassName) {
        return $annotation;
      }
    }

    return null;
  }

  /**
   * @return \Sharbat\Inject\Annotation[]
   */
  public function getAnnotations() {
    return $this->annotations;
  }

  /**
   * @return \Sharbat\Reflect\Clazz
   */
  public function getDeclaringClass() {
    return $this->declaringClass;
  }

  public function getDocComment() {
    return $this->reflection->getDocComment();
  }

  public function getModifiers() {
    return $this->reflection->getModifiers();
  }

  public function getName() {
    return $this->reflection->getName();
  }

  public function getValue($instance) {
    return $this->reflection->getValue($instance);
  }

  public function isPrivate() {
    return $this->reflection->isPrivate();
  }

  public function isProtected() {
    return $this->reflection->isProtected();
  }

  public function isPublic() {
    return $this->reflection->isPublic();
  }

  public function isStatic() {
    return $this->reflection->isStatic();
  }

  public function setValue($instance, $value) {
    if (!$this->reflection->isPublic()) {
      $this->reflection->setAccessible(true);
    }

    $this->reflection->setValue($instance, $value);
  }

}

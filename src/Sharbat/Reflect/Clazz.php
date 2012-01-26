<?php

namespace Sharbat\Reflect;

use Sharbat\Inject\Annotatable;
use \ReflectionClass;

/**
 * \ReflectionClass wrapper with annotations
 */
class Clazz implements Annotatable {

  /**
   * @var \ReflectionClass
   */
  private $reflection;

  /**
   * @var \Sharbat\Inject\Annotation[]
   */
  private $annotations = array();

  /**
   * @var \Sharbat\Reflect\Clazz
   */
  private $parent;

  /**
   * @var \Sharbat\Reflect\Clazz[]
   */
  private $interfaces = array();

  /**
   * @var \Sharbat\Reflect\Field[]
   */
  private $fields = array();

  /**
   * @var \Sharbat\Reflect\Method[]
   */
  private $methods = array();

  public function __construct(ReflectionClass $reflection, array $annotations,
      Clazz $parent = null, array $interfaces = array()) {
    $this->reflection = $reflection;
    $this->annotations = $annotations;
    $this->parent = $parent;
    $this->interfaces = $interfaces;
  }

  /**
   * @return \ReflectionClass
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

  public function getConstant($name) {
    return $this->reflection->getConstant($name);
  }

  public function getConstants() {
    return $this->reflection->getConstants();
  }

  /**
   * @return \Sharbat\Reflect\Method
   */
  public function getConstructor() {
    $constructor = $this->reflection->getConstructor();
    /* @var \ReflectionMethod $constructor */

    if ($constructor != null && isset($this->methods[$constructor->getName()])) {
      return $this->methods[$constructor->getName()];
    }

    return null;
  }

  public function getDocComment() {
    return $this->reflection->getDocComment();
  }

  public function getEndLine() {
    return $this->reflection->getEndLine();
  }

  /**
   * @return \ReflectionExtension
   */
  public function getExtension() {
    return $this->reflection->getExtension();
  }

  public function getExtensionName() {
    return $this->reflection->getExtensionName();
  }

  public function getFileName() {
    return $this->reflection->getFileName();
  }

  /**
   * @return string[]
   */
  public function getInterfaceNames() {
    return $this->reflection->getInterfaceNames();
  }

  /**
   * @return \Sharbat\Reflect\Clazz
   */
  public function getInterfaces() {
    return $this->interfaces;
  }

  /**
   * @param string $name
   * @return \Sharbat\Reflect\Method
   */
  public function getMethod($name) {
    return isset($this->methods[$name]) ? $this->methods[$name] : null;
  }

  /**
   * @return \Sharbat\Reflect\Method[]
   */
  public function getMethods() {
    return array_values($this->methods);
  }

  public function getModifiers() {
    return $this->reflection->getModifiers();
  }

  /**
   * @return string
   */
  public function getQualifiedName() {
    return $this->reflection->getName();
  }

  public function getNamespaceName() {
    return $this->reflection->getNamespaceName();
  }

  /**
   * @return \Sharbat\Reflect\Clazz
   */
  public function getParentClass() {
    return $this->parent;
  }

  /**
   * @return \Sharbat\Reflect\Field[]
   */
  public function getFields() {
    return array_values($this->fields);
  }

  /**
   * @param string $name
   * @return \Sharbat\Reflect\Field
   */
  public function getField($name) {
    return isset($this->fields[$name]) ? $this->fields[$name] : null;
  }

  /**
   * @return string
   */
  public function getUnqualifiedName() {
    $this->reflection->getShortName();
  }

  public function getStartLine() {
    return $this->reflection->getStartLine();
  }

  public function getStaticFieldValue($name, $default = null) {
    return $this->reflection->getStaticPropertyValue($name, $default);
  }

  public function hasConstant($name) {
    return $this->reflection->hasConstant($name);
  }

  public function hasMethod($name) {
    return $this->reflection->hasMethod($name);
  }

  public function hasField($name) {
    return $this->reflection->hasProperty($name);
  }

  public function implementsInterface($interface) {
    return $this->reflection->implementsInterface($interface);
  }

  public function inNamespace() {
    return $this->reflection->inNamespace();
  }

  public function invokeConstructorIfExists($instance, array $arguments) {
    $constructor = $this->reflection->getConstructor();
    /* @var \ReflectionMethod $constructor */

    if ($constructor != null) {
      $constructor->invokeArgs($instance, $arguments);
    }
  }

  public function isAbstract() {
    return $this->reflection->isAbstract();
  }

  public function isFinal() {
    return $this->reflection->isFinal();
  }

  public function isInstance($instance) {
    return $this->reflection->isInstance($instance);
  }

  public function isInstantiable() {
    return $this->reflection->isInstantiable();
  }

  public function isInterface() {
    return $this->reflection->isInterface();
  }

  public function isInternal() {
    return $this->reflection->isInternal();
  }

  public function isIterateable() {
    return $this->reflection->isIterateable();
  }

  public function isSubclassOf($class) {
    return $this->reflection->isSubclassOf($class);
  }

  public function isUserDefined() {
    return $this->reflection->isUserDefined();
  }

  public function newInstance() {
    return call_user_func_array(array($this->reflection, 'newInstance'),
      func_get_args());
  }

  public function newInstanceArgs(array $arguments) {
    return $this->reflection->newInstanceArgs($arguments);
  }

  public function newInstanceWithoutConstructor() {
    $qualifiedClassName = $this->reflection->getName();
    return unserialize(sprintf('O:%d:"%s":0:{}', strlen($qualifiedClassName),
      $qualifiedClassName));
  }

  public function setStaticPropertyValue($name, $value) {
    $this->reflection->setStaticPropertyValue($name, $value);
  }

}
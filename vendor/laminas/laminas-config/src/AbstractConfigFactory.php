<?php

/**
 * @see       https://github.com/laminas/laminas-config for the canonical source repository
 * @copyright https://github.com/laminas/laminas-config/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-config/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Config;

use Laminas\ServiceManager;
use Traversable;

/**
 * Class AbstractConfigFactory
 */
class AbstractConfigFactory implements ServiceManager\AbstractFactoryInterface
{
    /**
     * @var array
     */
    protected $configs = array();

    /**
     * @var string[]
     */
    protected $defaultPatterns = array(
        '#config[\._-](.*)$#i',
        '#^(.*)[\\\\\._-]config$#i'
    );

    /**
     * @var string[]
     */
    protected $patterns;

    /**
     * Determine if we can create a service with name
     *
     * @param ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return bool
     */
    public function canCreateServiceWithName(ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (isset($this->configs[$requestedName])) {
            return true;
        }

        if (!$serviceLocator->has('Config')) {
            return false;
        }

        $key = $this->match($requestedName);
        if (null === $key) {
            return false;
        }

        $config = $serviceLocator->get('Config');
        return isset($config[$key]);
    }

    /**
     * Create service with name
     *
     * @param ServiceManager\ServiceLocatorInterface $serviceLocator
     * @param string $name
     * @param string $requestedName
     * @return string|mixed|array
     */
    public function createServiceWithName(ServiceManager\ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (isset($this->configs[$requestedName])) {
            return $this->configs[$requestedName];
        }

        $key = $this->match($requestedName);
        if (isset($this->configs[$key])) {
            $this->configs[$requestedName] = $this->configs[$key];
            return $this->configs[$key];
        }

        $config = $serviceLocator->get('Config');
        $this->configs[$requestedName] = $this->configs[$key] = $config[$key];
        return $config[$key];
    }

    /**
     * @param string $pattern
     * @return self
     * @throws Exception\InvalidArgumentException
     */
    public function addPattern($pattern)
    {
        if (!is_string($pattern)) {
            throw new Exception\InvalidArgumentException('pattern must be string');
        }

        $patterns = $this->getPatterns();
        array_unshift($patterns, $pattern);
        $this->setPatterns($patterns);
        return $this;
    }

    /**
     * @param array|Traversable $patterns
     * @return self
     * @throws Exception\InvalidArgumentException
     */
    public function addPatterns($patterns)
    {
        if ($patterns instanceof Traversable) {
            $patterns = iterator_to_array($patterns);
        }

        if (!is_array($patterns)) {
            throw new Exception\InvalidArgumentException("patterns must be array or Traversable");
        }

        foreach ($patterns as $pattern) {
            $this->addPattern($pattern);
        }

        return $this;
    }

    /**
     * @param array|Traversable $patterns
     * @return self
     * @throws \InvalidArgumentException
     */
    public function setPatterns($patterns)
    {
        if ($patterns instanceof Traversable) {
            $patterns = iterator_to_array($patterns);
        }

        if (!is_array($patterns)) {
            throw new \InvalidArgumentException("patterns must be array or Traversable");
        }

        $this->patterns = $patterns;
        return $this;
    }

    /**
     * @return array
     */
    public function getPatterns()
    {
        if (null === $this->patterns) {
            $this->setPatterns($this->defaultPatterns);
        }
        return $this->patterns;
    }

    /**
     * @param string $requestedName
     * @return null|string
     */
    protected function match($requestedName)
    {
        foreach ($this->getPatterns() as $pattern) {
            if (preg_match($pattern, $requestedName, $matches)) {
                return $matches[1];
            }
        }
        return;
    }
}

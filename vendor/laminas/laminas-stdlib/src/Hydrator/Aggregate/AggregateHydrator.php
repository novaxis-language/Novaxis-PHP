<?php

/**
 * @see       https://github.com/laminas/laminas-stdlib for the canonical source repository
 * @copyright https://github.com/laminas/laminas-stdlib/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-stdlib/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Stdlib\Hydrator\Aggregate;

use Laminas\Hydrator\Aggregate\AggregateHydrator as BaseAggregateHydrator;
use Laminas\Stdlib\Hydrator\HydratorInterface;

/**
 * Aggregate hydrator that composes multiple hydrators via events
 *
 * @deprecated Use Laminas\Hydrator\Aggregate\AggregateHydrator from laminas/laminas-hydrator instead.
 */
class AggregateHydrator extends BaseAggregateHydrator implements HydratorInterface
{
}

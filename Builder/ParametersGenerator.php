<?php

namespace Becklyn\RouteTreeBundle\Builder;

use Becklyn\RouteTreeBundle\Tree\Node;
use Symfony\Component\Routing\Route;


/**
 *
 */
class ParametersGenerator
{
    /**
     * @param Route $route
     * @param Node  $node
     *
     * @return string[]
     */
    public function calculateParametersForNode (Node $node)
    {
        $parameters = $node->getParameters();

        foreach ($parameters as $name => $value)
        {
            if (null === $value)
            {
                $parameters[$name] = $this->findParameterInTree($name, $node);
            }
        }

        return $parameters;
    }



    /**
     * Finds whether the parameter is defined in tree somewhere
     *
     * @param string     $name
     * @param Node $node
     *
     * @return null|string
     */
    private function findParameterInTree ($name, Node $node)
    {
        $nodeParameters = $node->getParameters();

        if (isset($nodeParameters[$name]) && null !== $nodeParameters[$name])
        {
            return $nodeParameters[$name];
        }

        $parent = $node->getParent();

        return null !== $parent
            ? $this->findParameterInTree($name, $parent)
            : null;
    }
}

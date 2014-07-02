<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 02/07/14
 * Time: 23:11
 */

namespace Debril\RssAtomBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DynamicCompilerPass implements CompilerPassInterface
{
    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        $container->getDefinition('debril.reader')
            ->setArguments(
                array(
                    new Reference(
                        $container->getParameter('debril.http.client')
                    ),
                    new Reference('debril.parser.factory'),
                )
            );
    }
}
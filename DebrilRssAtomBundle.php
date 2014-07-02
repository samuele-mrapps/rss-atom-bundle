<?php

namespace Debril\RssAtomBundle;


use Debril\RssAtomBundle\DependencyInjection\DynamicCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DebrilRssAtomBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new DynamicCompilerPass());
    }

}

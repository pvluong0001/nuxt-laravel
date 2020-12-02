<?php

namespace App\Console\Generators;

use Prettus\Repository\Generators\RepositoryInterfaceGenerator;

class CustomRepositoryInterfaceGenerator extends RepositoryInterfaceGenerator
{
    public function getRootNamespace()
    {
        return parent::getRootNamespace() . '\\' . $this->getName();
    }

    public function getPath()
    {
        $path = app_path(
            parent::getConfigGeneratorClassPath(
                $this->getPathConfigNode(), true
            ) . '/' . $this->getName()
        );

        return  $path . '/' . $this->getName() . 'Repository.php';
    }
}

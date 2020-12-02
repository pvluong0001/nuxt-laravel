<?php

namespace App\Console\Generators;

use Prettus\Repository\Generators\RepositoryEloquentGenerator;

class CustomRepositoryGenerator extends RepositoryEloquentGenerator
{
    public function getPath()
    {
        $path = app_path(
            parent::getConfigGeneratorClassPath(
                $this->getPathConfigNode(), true
            ) . '/' . $this->getName()
        );

        return  $path . '/' . $this->getName() . 'RepositoryEloquent.php';
    }

    public function getReplacements()
    {
        $repository = parent::getRootNamespace() . '\\' . $this->getName() . '\\' . $this->name . 'Repository;';
        $repository = str_replace([
            "\\",
            '/'
        ], '\\', $repository);

        return array_merge(parent::getReplacements(), [
            'fillable'      => $this->getFillable(),
            'use_validator' => '',
            'validator'     => '',
            'repository'    => $repository,
            'model'         => isset($this->options['model']) ? $this->options['model'] : ''
        ]);
    }

    public function getRootNamespace()
    {
        return parent::getRootNamespace() . '\\' . $this->getName();
    }
}

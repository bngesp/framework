<?php

declare(strict_types=1);

namespace Bow\Console\Command;

use Bow\Console\Color;
use Bow\Console\Generator;

class ModelCommand extends AbstractCommand
{
    /**
     * Add Model
     *
     * @param string $model
     * @return mixed
     */
    public function generate(string $model)
    {
        $generator = new Generator(
            $this->setting->getModelDirectory(),
            $model
        );

        if ($generator->fileExists()) {
            echo Color::red('The model already exists.');

            exit(1);
        }

        $generator->write('model/model', [
            'baseNamespace' => $this->namespaces['model']
        ]);

        echo Color::green("The model was well created.");
    }
}

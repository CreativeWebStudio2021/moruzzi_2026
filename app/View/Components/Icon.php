<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\File;

class Icon extends Component
{
    public string $svg = '';

    public function __construct(
        public ?string $name = null,
        public string $class = ''
    ) {
        if (!$this->name) {
            return;
        }

        $path = resource_path("icons/{$this->name}.svg");

        if (File::exists($path)) {
            $content = File::get($path);

            if ($this->class) {
                $content = preg_replace(
                    '/<svg\b/',
                    '<svg class="'.$this->class.'"',
                    $content,
                    1
                );
            }

            $this->svg = $content;
        }
    }

    public function render()
    {
        return function () {
            return $this->svg;
        };
    }
}

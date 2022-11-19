<?php

namespace Mailery\Template\Editor;

use Yiisoft\Form\FormModelInterface;

interface EditorWidgetInterface
{

    /**
     * @param FormModelInterface $data
     * @param string $attribute
     * @return self
     */
    public function config(FormModelInterface $data, string $attribute): self;

    /**
     * @param array $options
     * @return self
     */
    public function options(array $options = []): self;

}

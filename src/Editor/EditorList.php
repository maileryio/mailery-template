<?php

namespace Mailery\Template\Editor;

use Mailery\Template\Editor\EditorInterface;
use Doctrine\Common\Collections\ArrayCollection;

class EditorList extends ArrayCollection
{
    /**
     * @param EditorInterface[] $elements
     */
    public function __construct(array $elements = [])
    {
        foreach ($elements as $element) {
            if (!$element instanceof EditorInterface) {
                throw new \RuntimeException('Editor must be implement EditorInterface');
            }
        }

        parent::__construct($elements);
    }

    /**
     * @return array
     */
    public function getValueOptions(): array
    {
        $options = [];
        foreach ($this->toArray() as $item) {
            $options[$item->getName()] = $item->getLabel();
        }

        return array_filter($options);
    }

    /**
     * @param string|null $name
     * @return EditorInterface|null
     */
    public function findByName(?string $name): ?EditorInterface
    {
        foreach ($this->toArray() as $item) {
            if ($item->getName() === $name) {
                return $item;
            }
        }

        return null;
    }
}
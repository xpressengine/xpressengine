<?php

namespace Xpressengine\Widget\Presenters;

class ContainerPresenter extends XEUIPresenter
{
    /**
     * The name of presenter
     *
     * @var string
     */
    const NAME = 'Container UI';

    /**
     * Get the string contents of the presenter.
     *
     * @author Sparkweb
     * @return string
     */
    public function render()
    {
        $content = '';

        foreach ($this->data as $container) {
            $content .= $this->getContainer($container);
        }

        return $this->getContainerWrapper($content);
    }

    /**
     * Get a container contents
     *
     * @param array $data row data
     * @return string
     */
    protected function getContainer(array $data)
    {
        $content = '';

        foreach ($data as $row) {
            if ($this->isColumn($row)) {
                $row = array($row);
            }

            $content .= $this->getRow($row);
        }

        return '<div class="xe-container">'.$content.'</div>';
    }

    /**
     * Is it a column.
     *
     * @param $data
     * @return bool
     */
    private function isColumn($data)
    {
        return array_key_exists('grid', $data);
    }
}
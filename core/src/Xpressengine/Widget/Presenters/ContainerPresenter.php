<?php

namespace Xpressengine\Widget\Presenters;

use Illuminate\Support\Arr;

class ContainerPresenter extends XEUIPresenter
{
    /**
     * The name of presenter
     *
     * @var string
     */
    const NAME = 'Container UI';

    /**
     * @var boolean
     */
    const SUPPORT_CONTAINER = true;

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

        $rows = Arr::get($data, 'rows', $data);
        $options = Arr::get($data, 'options', []);

        foreach ($rows as $row) {
            if ($this->isColumn($row)) {
                $row = array($row);
            }

            $content .= $this->getRow($row);
        }

        if ($isFluid = Arr::get($options, 'fluid')) {
            return '<div class="xe-container-fluid">'.$content.'</div>';
        }

        return '<div class="xe-container">'.$content.'</div>';
    }
}
<?php
namespace Xpressengine\Support\Tree;

trait TreeMakerTrait
{
    protected function makeTree($nodes = [])
    {
        return Tree::make($nodes);
    }
}

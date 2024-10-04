<?php

declare (strict_types=1);
namespace Rector\Skipper\Skipper;

use PhpParser\Node;
final class CommentSkipper
{
    /**
     * @readonly
     * @var \Rector\Skipper\Skipper\SkipSkipper
     */
    private $skipSkipper;
    public function __construct(\Rector\Skipper\Skipper\SkipSkipper $skipSkipper)
    {
        $this->skipSkipper = $skipSkipper;
    }
    public function shouldSkip(string $rectorClass, Node $node) : bool
    {
        return $this->skipSkipper->doesMatchComments($rectorClass, $node);
    }
}

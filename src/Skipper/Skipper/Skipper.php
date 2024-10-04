<?php

declare (strict_types=1);
namespace Rector\Skipper\Skipper;

use PhpParser\Node;
use Rector\Contract\Rector\RectorInterface;
use Rector\ProcessAnalyzer\RectifiedAnalyzer;
use Rector\Skipper\SkipVoter\ClassSkipVoter;
/**
 * @api
 * @see \Rector\Tests\Skipper\Skipper\SkipperTest
 */
final class Skipper
{
    /**
     * @readonly
     * @var \Rector\ProcessAnalyzer\RectifiedAnalyzer
     */
    private $rectifiedAnalyzer;
    /**
     * @readonly
     * @var \Rector\Skipper\Skipper\PathSkipper
     */
    private $pathSkipper;
    /**
     * @readonly
     * @var \Rector\Skipper\SkipVoter\ClassSkipVoter
     */
    private $classSkipVoter;
    /**
     * @readonly
     * @var \Rector\Skipper\Skipper\CommentSkipper
     */
    private $commentSkipper;
    public function __construct(RectifiedAnalyzer $rectifiedAnalyzer, \Rector\Skipper\Skipper\PathSkipper $pathSkipper, ClassSkipVoter $classSkipVoter, \Rector\Skipper\Skipper\CommentSkipper $commentSkipper)
    {
        $this->rectifiedAnalyzer = $rectifiedAnalyzer;
        $this->pathSkipper = $pathSkipper;
        $this->classSkipVoter = $classSkipVoter;
        $this->commentSkipper = $commentSkipper;
    }
    /**
     * @param string|object $element
     */
    public function shouldSkipElement($element) : bool
    {
        return $this->shouldSkipElementAndFilePath($element, __FILE__);
    }
    public function shouldSkipFilePath(string $filePath) : bool
    {
        return $this->pathSkipper->shouldSkip($filePath);
    }
    /**
     * @param string|object $element
     */
    public function shouldSkipElementAndFilePath($element, string $filePath) : bool
    {
        if (!$this->classSkipVoter->match($element)) {
            return \false;
        }
        return $this->classSkipVoter->shouldSkip($element, $filePath);
    }
    /**
     * @param class-string<RectorInterface> $rectorClass
     * @param string|object $element
     */
    public function shouldSkipCurrentNode($element, string $filePath, string $rectorClass, Node $node) : bool
    {
        if ($this->shouldSkipElementAndFilePath($element, $filePath)) {
            return \true;
        }
        if ($this->rectifiedAnalyzer->hasRectified($rectorClass, $node)) {
            return \true;
        }
        return $this->commentSkipper->shouldSkip($rectorClass, $node);
    }
}

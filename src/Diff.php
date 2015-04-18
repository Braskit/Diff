<?php

/*
 * Copyright (C) 2015 Frank Usrs
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace Braskit\Diff;

use Diff as UnifiedDiff;
use Diff_Renderer_Text_Unified as UnifiedDiffRenderer;
use SebastianBergmann\Diff\Diff as DiffOutput;
use SebastianBergmann\Diff\Parser as Parser;
use SebastianBergmann\Diff\Line;

/**
 * Diffs stuff.
 *
 * We have to use two different libraries, one for generating the diff and one
 * for parsing it. While both libraries support diffing and the parsing of
 * diffs, the former doesn't generate a usable object graph, while the latter
 * cannot actually parse its own diffs. （　´_ゝ`）
 *
 * This class basically just simplifies that whole process.
 */
final class Diff {
    /**
     * @var UnifiedDiffRenderer
     */
    private $renderer;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * Constructor.
     */
    public function __construct() {
        $this->renderer = new UnifiedDiffRenderer();
        $this->parser = new Parser();
    }

    /**
     * Diffs two strings and returns an object graph.
     *
     * @param $one
     * @param $two
     *
     * @return DiffOutput|null
     */
    public function diffStrings($one, $two) {
        $unified = $this->getUnifiedDiff($one, $two);

        $diffs = $this->parser->parse($unified);

        if (isset($diffs[0])) {
            return $diffs[0];
        }

        return null;
    }

    /**
     * Create a unified diff.
     *
     * @param string $one
     * @param string $two
     *
     * @return string unified diff
     */
    private function getUnifiedDiff($one, $two) {
        // we need this header because the regex clusterfuck of a parser is a
        // picky piece of shit.
        $header = "--- a.txt\n+++ b.txt\n";

        $one = preg_split('/\r?\n|\r/', $one);
        $two = preg_split('/\r?\n|\r/', $two);

        $body = (new UnifiedDiff($one, $two))->render($this->renderer);

        $diff = $header.$body;

        return $diff;
    }
}

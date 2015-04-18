<?php

namespace Braskit\Diff\Tests;

use Braskit\Diff\Diff;

class DiffTest extends \PHPUnit_Framework_TestCase {
    public function testDiff() {
        $one = "a\nb\nc\nd\ne\nf\ng\nh";
        $two = "a\nb\nc\nx\ny\nz\nh";

        $result = (new Diff())->diffStrings($one, $two);

        $expected = unserialize(file_get_contents(__DIR__.'/sample.txt'));

        $this->assertEquals($result, $expected);
    }
}

# Braskit\Diff [![Build Status](https://travis-ci.org/Braskit/Diff.svg?branch=master)](https://travis-ci.org/Braskit/Diff)

**Braskit\Diff** is a PHP library which diffs two strings and generates an
object graph. It was conceived because [Sebastian Bergmann's Diff library][1]
isn't capable of parsing its own diffs (due to the output not being unified or
whatever), while [this library][2], which does parse unified diffs, doesn't
generate a usable object graph. Braskit\Diff solves this problem by providing
the needed glue between the two libraries.

[1]: https://github.com/sebastianbergmann/diff
[2]: https://github.com/phpspec/php-diff

## Usage

    <?php

    use Braskit\Diff\Diff;

    $differ = new Braskit\Diff\Diff();

    $graph = $differ->diffStrings($one, $two);

The resulting object graph is a `SebastianBergmann\Diff\Diff` instance.

## Licence

MIT

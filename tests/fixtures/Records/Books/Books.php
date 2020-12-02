<?php

namespace ByTIC\Queue\Tests\Fixtures\Records\Books;

use Nip\Records\RecordManager;
use Nip\Utility\Traits\SingletonTrait;

/**
 * Class Books
 * @package ByTIC\Queue\Tests\Fixtures\Records\Books
 */
class Books extends RecordManager
{
    use SingletonTrait;

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritDoc
     */
    public function getPrimaryKey()
    {
        return 'id';
    }

    /** @noinspection PhpMissingParentCallCommonInspection
     * @inheritDoc
     */
    public function getRootNamespace()
    {
        return 'ByTIC\Queue\Tests\Fixtures';
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return Book::class;
    }
}

<?php

use App\Domain\Entities\TicketComment;
use App\Domain\Exceptions\DomainException;

test('should create a ticket comment', function () {
    $comment = new TicketComment(1, 2, 'A comment');
    expect($comment->getTicketId())->toBe(1);
    expect($comment->getUserId())->toBe(2);
    expect($comment->getComment())->toBe('A comment');
    expect($comment->getCreatedAt())->toBeInstanceOf(DateTimeImmutable::class);
    expect($comment->getId())->toBeNull();
});

test('should not create a ticket comment with empty text', function () {
    new TicketComment(1, 2, '');
})->throws(DomainException::class, 'Comment cannot be empty');

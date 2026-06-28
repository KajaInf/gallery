<?php

/**
 * Comment voter test.
 */

namespace App\Tests\Security\Voter;

use App\Entity\Comment;
use App\Entity\User;
use App\Security\Voter\CommentVoter;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

/**
 * Class CommentVoterTest.
 */
class CommentVoterTest extends TestCase
{
    /**
     * Tests that admin can delete comment.
     *
     * @return void
     */
    public function testAdminCanDeleteComment(): void
    {
        $security = $this->createMock(Security::class);
        $security
            ->method('isGranted')
            ->with('ROLE_ADMIN')
            ->willReturn(true);

        $voter = new CommentVoter($security);

        $token = $this->createMock(TokenInterface::class);
        $token
            ->method('getUser')
            ->willReturn(new User());

        $result = $voter->vote($token, new Comment(), [CommentVoter::DELETE]);

        $this->assertSame(CommentVoter::ACCESS_GRANTED, $result);
    }
}

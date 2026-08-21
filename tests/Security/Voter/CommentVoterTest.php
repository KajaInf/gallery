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

    /**
     * Tests that anonymous user cannot delete comment.
     */
    public function testAnonymousUserCannotDeleteComment(): void
    {
        $security = $this->createMock(Security::class);
        $security
            ->expects($this->never())
            ->method('isGranted');

        $voter = new CommentVoter($security);

        $token = $this->createMock(TokenInterface::class);
        $token
            ->method('getUser')
            ->willReturn(null);

        $result = $voter->vote($token, new Comment(), [CommentVoter::DELETE]);

        $this->assertSame(CommentVoter::ACCESS_DENIED, $result);
    }

    /**
     * Tests unsupported attribute.
     */
    public function testUnsupportedAttributeIsAbstained(): void
    {
        $security = $this->createMock(Security::class);
        $voter = new CommentVoter($security);

        $token = $this->createMock(TokenInterface::class);

        $result = $voter->vote($token, new Comment(), ['OTHER_PERMISSION']);

        $this->assertSame(CommentVoter::ACCESS_ABSTAIN, $result);
    }
}

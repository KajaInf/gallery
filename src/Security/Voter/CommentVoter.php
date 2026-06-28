<?php

/**
 * Comment voter.
 */

namespace App\Security\Voter;

use App\Entity\Comment;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

/**
 * Class CommentVoter.
 */
class CommentVoter extends Voter
{
    public const DELETE = 'COMMENT_DELETE';

    /**
     * Constructor.
     *
     * @param Security $security Security service
     */
    public function __construct(private readonly Security $security)
    {
    }

    /**
     * Checks supported attribute and subject.
     *
     * @param string $attribute Permission attribute
     * @param mixed  $subject   Permission subject
     *
     * @return bool True if supported
     */
    protected function supports(string $attribute, mixed $subject): bool
    {
        return self::DELETE === $attribute && $subject instanceof Comment;
    }

    /**
     * Votes on attribute.
     *
     * @param string         $attribute Permission attribute
     * @param mixed          $subject   Permission subject
     * @param TokenInterface $token     Security token
     *
     * @return bool True if access is granted
     */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            return false;
        }

        return $this->security->isGranted('ROLE_ADMIN');
    }
}

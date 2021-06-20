<?php

namespace App\Security\Voter;

use App\Entity\Product;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class AuthorVoter extends Voter
{
    const EDIT = 'edit';
    const DELETE = 'delete';

    /**
     * @param string $attribute
     * @param mixed $subject
     * @return bool
     */
    protected function supports(string $attribute, $subject): bool
    {
        if (! in_array($attribute, [self::EDIT, self::DELETE])) {
            return false;
        }

        if (! $subject instanceof Product) {
            return false;
        }

        return true;
    }

    /**
     * @param string $attribute
     * @param mixed $subject
     * @param TokenInterface $token
     * @return bool
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (! $user instanceof User) {
            return false;
        }

        $product = $subject;

        switch ($attribute) {
            case self::DELETE:
                return $this->canDelete($product, $user);
            case self::EDIT:
                return $this->canEdit($product, $user);
        }

        return false;
    }

    /**
     * @param Product $product
     * @param User $user
     * @return bool
     */
    private function canEdit(Product $product, User $user): bool
    {
        return $user === $product->getUser();
    }

    /**
     * @param Product $product
     * @param User $user
     * @return bool
     */
    private function canDelete(Product $product, User $user): bool
    {
        return $user === $product->getUser();
    }
}

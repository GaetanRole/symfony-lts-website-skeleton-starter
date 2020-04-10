<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Guard\Authenticator\AbstractFormLoginAuthenticator;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @author   Gaëtan Rolé-Dubruille <gaetan.role@gmail.com>
 */
final class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    /** Three functions based on targetPath */
    use TargetPathTrait;

    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var TranslatorInterface */
    private $translator;

    /** @var UrlGeneratorInterface */
    private $urlGenerator;

    /** @var CsrfTokenManagerInterface */
    private $csrfTokenManager;

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        TranslatorInterface $translator,
        UrlGeneratorInterface $urlGenerator,
        CsrfTokenManagerInterface $csrfTokenManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }

    public function supports(Request $request): bool
    {
        return 'app_security_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    public function getCredentials(Request $request): array
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];

        $request->getSession()->set(Security::LAST_USERNAME, $credentials['email']);

        return $credentials;
    }

    /**
     * @return object|UserInterface|null
     */
    public function getUser($credentials, UserProviderInterface $userProvider): User
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException(
                $this->translator->trans('security.authenticator.user.csrf_token.exception', [], 'exceptions')
            );
        }

        $user = $this->entityManager->getRepository(User::class)
            ->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException(
                $this->translator->trans('security.authenticator.user.authentication.exception', [], 'exceptions')
            );
        }

        return $user;
    }

    public function checkCredentials($credentials, UserInterface $user): bool
    {
        $state = $this->passwordEncoder->isPasswordValid($user, $credentials['password']);
        if (false === $state) {
            throw new CustomUserMessageAuthenticationException(
                $this->translator->trans('security.authenticator.user.authentication.exception', [], 'exceptions')
            );
        }
        return $state;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function getPassword($credentials): ?string
    {
        return $credentials['password'];
    }

    /**
     * On authentication success return to user profile page
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey): RedirectResponse
    {
        $targetPath = $this->getTargetPath($request->getSession(), $providerKey);
        if ($targetPath) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_user_profile'));
    }

    protected function getLoginUrl(): string
    {
        return $this->urlGenerator->generate('app_security_login');
    }
}

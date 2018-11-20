<?php

/**
 * Login form with guard authenticator file
 *
 * PHP Version 7.2
 *
 * @category Authenticator
 * @package  Security
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */

namespace App\Security;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
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

/**
 * Login Form Authenticator class
 *
 * @category Authenticator
 * @package  Security
 * @author   Gaëtan Rolé-Dubruille <gaetan@wildcodeschool.fr>
 */
class LoginFormAuthenticator extends AbstractFormLoginAuthenticator
{
    use TargetPathTrait;

    /**
     * @var EntityManagerInterface
     */
    private $_entityManager;

    /**
     * @var RouterInterface
     */
    private $_router;

    /**
     * @var CsrfTokenManagerInterface
     */
    private $_csrfTokenManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $_passwordEncoder;

    /**
     * LoginFormAuthenticator constructor.
     *
     * @param EntityManagerInterface       $entityManager
     * @param RouterInterface              $router
     * @param CsrfTokenManagerInterface    $csrfTokenManager
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router, CsrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->_entityManager = $entityManager;
        $this->_router = $router;
        $this->_csrfTokenManager = $csrfTokenManager;
        $this->_passwordEncoder = $passwordEncoder;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    public function supports(Request $request)
    {
        return 'app_login' === $request->attributes->get('_route')
            && $request->isMethod('POST');
    }

    /**
     * Get credentials from request
     *
     * @param Request $request
     *
     * @return array|mixed
     */
    public function getCredentials(Request $request)
    {
        $credentials = [
            'email' => $request->request->get('email'),
            'password' => $request->request->get('password'),
            'csrf_token' => $request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(
            Security::LAST_USERNAME,
            $credentials['email']
        );

        return $credentials;
    }

    /**
     * Get current User by token
     *
     * @param mixed                 $credentials
     * @param UserProviderInterface $userProvider
     *
     * @return null|object|UserInterface
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        $token = new CsrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->_csrfTokenManager->isTokenValid($token)) {
            throw new InvalidCsrfTokenException();
        }

        $user = $this->_entityManager->getRepository(User::class)
            ->findOneBy(['email' => $credentials['email']]);

        if (!$user) {
            // fail authentication with a custom error
            throw new CustomUserMessageAuthenticationException('Your credentials are invalid. Please verify your email and password.');
        }

        return $user;
    }

    /**
     * Check if password is valid
     *
     * @param mixed         $credentials
     * @param UserInterface $user
     *
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user)
    {
        return $this->_passwordEncoder->isPasswordValid($user, $credentials['password']);
    }

    /**
     * On authentication sucess return to user profile page
     *
     * @param Request        $request
     * @param TokenInterface $token
     * @param string         $providerKey
     *
     * @return null|RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->_router->generate('user_index'));
    }

    /**
     * Return login route
     * @return string
     */
    protected function getLoginUrl()
    {
        return $this->_router->generate('app_login');
    }
}

<?php

namespace App\Security;

use Doctrine\ORM\EntityManagerInterface;
use http\Client\Curl\User;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\PassportInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    private $entityManager;
    private $urlGenerator;
    private $csrfTokenManager;
    private $passwordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator,
                                csrfTokenManagerInterface $csrfTokenManager, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->urlGenerator = $urlGenerator;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->passwordEncoder = $passwordEncoder;
    }
    /**
     *  Should this authenticator be used for this request ?
     *
     * @param Request $request
     * @return bool|void
     */
    public function supports(Request $request):bool
    {
        return self::LOGIN_ROUTE===$request->attributes->get('_route') && $request->isMethod('POST');
    }
    public function getCredentials(Request  $request) #FIRST
    {
        $credentials = [
            'email' =>$request->request->get('email'),
            'password' =>$request->request->get('password'),
            'csrf_token' =>$request->request->get('_csrf_token'),
        ];
        $request->getSession()->set(security::LAST_USERNAME, $credentials['email']);
    return $credentials;
    }

    /**
     * @param array $credentials
     * @param UserProviderInterface $userProvider
     * @return object|UserInterface|null
     */
    public  function getUser($credentials, UserProviderInterface $userProvider) #SECOND
    {
        $user=$this->entityManager->getRepository(User::class)->findOneBy(['email'=>$credentials['email']]);
        if (!$user){
        throw new UsernameNotFoundException(sprintf('User "%s" not found', $credentials['email']));
        }
    return $user;
    }

    /**
     * @param array $credentials
     * @param UserInterface $user
     * @return bool
     */
    public function checkCredentials($credentials, UserInterface $user): bool #THIRD
    {
        $token = new csrfToken('authenticate', $credentials['csrf_token']);
        if (!$this->csrfTokenManager->isTokenValid($token)){
            throw new InvalidCsrfTokenException();
        }
        return $this->passwordEncoder->isPasswordValid($user,$credentials['password']);

    }
    public function authenticate(Request $request): PassportInterface
    {
        $email = $request->request->get('email', '');

        $request->getSession()->set(Security::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email),
            new PasswordCredentials($request->request->get('password', '')),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
            ]
        );
    }

    /**
     *
     * @Route("/backaccueil", name="backaccueil")
     * @param Request $request
     * @param TokenInterface $token
     * @param string $firewallName
     * @return Response|void|null
     * @throws \Exception
     */
    /**
* @Route("/backaccueil", name="backaccueil")
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        /*var_dump('+++++++++++++++++++++++++++');
        return new  RedirectResponse(($this->urlGenerator->generate('accueil')));*/


        // On récupère la liste des rôles d'un utilisateur

        $roles = $token->getUser()->getRoles();
        //dump($token);die();
        if ($roles[0] == 'ROLE_ADMIN') {
           return new RedirectResponse($this->urlGenerator->generate('accueil_Admin'));

        }
            elseif ($roles[0] == 'ROLE_CANDI')
                {
                    return  new RedirectResponse($this->urlGenerator->generate('accueil_Cand'));
                }
        elseif ($roles[0] == 'ROLE_FORM')
        {
            return  new RedirectResponse($this->urlGenerator->generate('accueil_Form'));
        }
        elseif ($roles[0] == 'ROLE_USER')
        {
            return  new RedirectResponse($this->urlGenerator->generate('accueil_User'));
        }





    }




        /*if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        //User authenticated
        $user = $token->getUser();
        //Ses roles
        $roles = $user->getRoles();
        //un tableau de roles
        $rolesTab = array_map(function ($role) {
            return $role;
        }, $roles);


        if (in_array('ROLE_ADMIN', $rolesTab, true)) {
            // c'est un aministrateur : on le rediriger vers l'espace admin
            $redirection = new RedirectResponse($this->urlGenerator->generate('admin_home'));
        } elseif (in_array('ROLE_FORM', $rolesTab, true)) {
            // c'est un formateur : on le rediriger vers l'espace formateur
            $redirection = new RedirectResponse($this->urlGenerator->generate('formateur_home'));
        }elseif (in_array('ROLE_CAND', $rolesTab, true)) {
            // c'est un formateur : on le rediriger vers l'espace candidat
            $redirection = new RedirectResponse($this->urlGenerator->generate('candidat_home'));
        }

        else {
            // c'est un utilisaeur lambda : on le rediriger vers l'accueil
            $redirection = new RedirectResponse($this->urlGenerator->generate('users_index'));
        }

        throw new \Exception('TODO: provide a valid redirect inside '.__FILE__);*/

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }

}

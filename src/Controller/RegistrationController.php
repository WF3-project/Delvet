<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\TokenAuthenticator;
use App\Routing\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGeneratorInterface;
class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, TokenAuthenticator $tokenGenerator): Response
    {   
        // On crée un nouvel utilisateur
        $user = new User();
        // On crée le formulaire
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        // Si le formulaire est soumis et si il est valide
        if ($form->isSubmitted() && $form->isValid() ) 
        {
            // encode le mot de passe
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // On génére le token de confirmation
            $user->setConfirmationToken($this->generateToken());
            // On récupère le token
            $confirmation = $user->getConfirmationToken(); 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // On génère l'url du lien de confirmation dans le mail
            $url = $this->generateUrl('confirm_mail', ['token' => $confirmation], UrlGeneratorInterface::ABSOLUTE_URL);
            // Envoie du mail avec swift mailer
            $message =(new \Swift_Message('Validation du mail'))
                ->setFrom('no_reply.delvet@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("Click on the following link to validate your account: " . $url, 'text/html');
            $mailer->send($message);
                return $this->redirectToRoute('app_login');
        }
            return $this->render('registration/register.html.twig', [
                'registrationForm' => $form->createView(),
            ]);
    }
    // Fonction qui génère les tokens
    public function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/','-_'), '=');
    }
    // Fonction qui confirme la validité du token et setup le booléen sur true
    /**
     * @Route("/confirm-mail/{token}", name="confirm_mail")
     */
    public function confirmAccount( $token ): Response
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy(['ConfirmationToken' => $token]);
        
        // si l'utilisateur n'existe pas
        if($user === null) 
        {
            // Message d'erreur
            $this->addFlash('not-user-exist', 'utilisateur non trouvé');
            //Redirection vers l'inscription
            return $this->redirectToRoute('app_register');
        } 
        // sinon     
        else
        {
            // On setup le token de confirmation sur null
           $user->setConfirmationToken(null);
           // On setup la confirmation sur true
           $user->setEnabled(true);
           // on envoie données en bdd
           $em->flush();
           // redirection sur la page login
           return $this->redirectToRoute('app_login');
        }
    }
    
    /**
     * @Route("/forgotten_password", name="forgotten_password")
     *
     */
    public function forgottenPassword(Request $request, UserPasswordEncoderInterface $encoder, \Swift_Mailer $mailer, TokenAuthenticator $tokenGenerator)
    {
        if($request->isMethod('POST'))
        {   
            $email = $request->request->get('email');
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository(User::class)->findOneByEmail($email);
            /**@var $user User */
            // si l'utilisateur n'existe pas
            if($user === null)
            {
                $this->addFlash('danger', 'cette email n\'est pas valide');
                return $this->render('security/forgotten_password.html.twig');
            }
            // On génere le token d'oublie du mdp
            $token = $tokenGenerator->generateToken();
            try
            {
                $user->setResetToken($token);
                // On envoie données en bdd
                $em->flush();
            }
            catch(\Exception $e)
            {
                $this->addFlash('warning', $e->getMessage());
                return $this->render('security/forgotten_password.html.twig');
            }
            // On génère l'url d'oublie du mdp
            $url = $this->generateUrl('reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);
            // Envoie du mail avec swift mailer
            $message =(new \Swift_Message('Forgot Password'))
                ->setFrom('no_reply.delvet@gmail.com')
                ->setTo($user->getEmail())
                ->setBody("Click on the following link to reset your password: " . $url, 'text/html');
            $mailer->send($message);
            $this->addFlash('notice', 'Mail send');
            return $this->redirectToRoute('app_login');
        }
        return $this->render('security/forgotten_password.html.twig');
    }
    /**
     * @Route("/reset_password/{token}", name="reset_password")
     *
     */
    public function ResetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST'))
        {
            $em = $this->getDoctrine()->getManager();
            // On recherche l'utilisateur grace a son reset token
            $user = $em->getRepository(User::class)->findOneByResetToken($token);
            // si l'utilisateur n'existe pas
            if($user === null)
            {
                $this->addFlash('danger', 'impossible de mettre à jour le mot de passe');
                return $this->render('security/reset_password.html.twig', ['token' => $token]);
            }
            // on passe le reset token a null
            $user->setResetToken(null);
            // on encode le nouveau mdp
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            //envoie des données a la BDD
            $em->flush();
            $this->addFlash('notice', 'Mot de passe mis à jour');
            return $this->redirectToRoute('home');
        }
        else
        {
            return $this->render('security/reset_password.html.twig', ['token' => $token]);
        }
    }
}
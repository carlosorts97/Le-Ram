<?php


use purbeasadada
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sydsaddsdamfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
mponent\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class AdminController
 * @package App\Controller
 *@IsGranted("ROLE_ADMIN")
 *
 */
class AdminController extends AbstractController
{
    /**adasdadadsdd
     * @Route("/post/admin", name="app_posts_admin")
     */
    public function posts_admin(){
hijoooo
 $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        return $this->render('admin/posts.html.twig', [
            'posts' => $posts,

        ]);
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function index()
    {
        $users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('admin/index.html.twig', [
        ]);
    }

    /**
     * @Route("admin/user/{id}/edit", name="app_user_edit")
     */
    public function editUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, $id)
    {
        $title="Edit la polla";
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        //create the form
        $form = $this->createForm(EditUserType::class, $user);

        $form->handleRequest($request);
        $error = $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            //encrypt password
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            //handle the entities
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'succes', 'User created'
            );
            return $this->redirectToRoute('app_admin');
        }

        //render the form
        return $this->render('admin/edit.html.twig',[
            'error'=>$error,
            'form'=>$form->createView(),
            'title'=>$title
        ]);
    }

    /**
     * @Route("/newuser",name="app_new_user")
     */
    public function newUser (Request $request, UserPasswordEncoderInterface $passwordEncoder){

        $title="Create";
        $user=new User();
        $user->setIsActive(true);
        //create the form
        $form=$this->createForm(EditUserType::class,$user);

        $form->handleRequest($request);
        $error=$form->getErrors();

        if($form->isSubmitted() && $form->isValid()){
            //encrypt password
            $password=$passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            //handle the entities
            $entityManager=$this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'succes', 'User created'
            );
            return $this->redirectToRoute('app_admin');
        }

        //render the form
        return $this->render('admin/edit.html.twig',[
            'error'=>$error,
            'form'=>$form->createView(),
            'title'=>$title
        ]);

    }

    /**
     * @Route("admin/user/{id}/delete", name="app_user_delete")
     */
    public function deleteUser($id)
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('app_admin');


    }

}

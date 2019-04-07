<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * liste les derniers articles
     * @return Response
     */
    public function list():Response
    {
        $repository=$this->getDoctrine()->getRepository(Article::class);
        //$articles = array("sujet_java"=>"Le java c'est bien", "sujet_php"=>"le PHP c'est bien", "Sujet Angular"=>"Angulatr c'est le futur");
        //var_dump($articles);
        //die('STOOOPPP');
        $articles=$repository->findAll();
        return $this->render('accueil.html.twig', ['articles'=>$articles]);
    }

    /**
     * @param String $slug
     * @return Response
     */
    public function show(String $slug):Response
    {
        $repository=$this->getDoctrine()->getRepository(Article::class);
        $article=$repository->findOneBy(['slug'=>$slug]);
        return $this->render('show.html.twig', ['article'=>$article]);
        //return $this->json($article);
    }

    /**
     * @return Response
     */
    public function create():Response
    {
        //Creation d'une categorie
        $category=new Category();
        $category->setName('Histoire');

        //Creation d'un user
        $user=new User();
        $user->setEmail('king@gmail.com');
        $user->setUsername('laetitia');
        $user->setPassword('laetitia');
        $user->setRole('Admin_Role');
        $user->setIsEnabled(true);

        // Création d'un article
        $article = new Article();
        $article->setTitre('Titre de l\'article');
        $article->setSlug('titre-de-l-article');
        $article->setContenu('Contenu de l\'article');
        $article->setCategory($category);
        $article->setPublisher($user);
        $article->setIsPublished(true);
        $article->setNbViews(0);
        $article->setCreatedAt(date_create());


        // On insère en BDD
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($user);
        $manager->persist($category);
        $manager->persist($article);
        $manager->flush();

        $this->addFlash('success', 'Votre article a été ajouté');
        return $this->render('create.html.twig');
    }

    /**
     * @param String $slug
     * @return Response
     */
    public function update(String $slug):Response
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()
            ->getRepository(Article::class);
        // Récupération de tous les articles
        $article = $repository->findOneBy([
            'slug' => $slug
        ]);
        // On imagine des changements faits avec le formulaire
        $article->setTitre('Angular la vraie valeur ajoutée');
        // On insert en BDD
        $manager = $this->getDoctrine()->getManager();
        $manager->persist($article);
        $manager->flush();

        $this->addFlash('warning', 'Votre article a été modifié');
        return $this->render('update.html.twig');
    }

    /**
     * @param String $slug
     * @return Response
     */
    public function delete(String $slug):Response
    {
        // Récupération du Repository
        $repository = $this->getDoctrine()
            ->getRepository(Article::class);
        // Récupération de tous les articles
        $article = $repository->findOneBy([
            'slug' => $slug
        ]);
        // On insert en BDD
        $manager = $this->getDoctrine()->getManager();
        $manager->remove($article);
        $manager->flush();

        $this->addFlash('danger', 'Votre article a été supprimé');
        return $this->render('delete.html.twig');
    }
}

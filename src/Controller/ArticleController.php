<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * @return Response
     */
    public function list():Response
    {
        $articles = array("sujet_java"=>"Le java c'est bien", "sujet_php"=>"le PHP c'est bien", "Sujet Angular"=>"Angulatr c'est le futur");
        //var_dump($articles);
        //die('STOOOPPP');
        return $this->render('accueil.html.twig',['articles'=>$articles]);
    }

    /**
     * @param String $slug
     * @return Response
     */
    public function show(String $slug):Response
    {
        return $this->render('show.html.twig');
    }

    /**
     * @return Response
     */
    public function create():Response
    {
        $this->addFlash('success','Votre article a été ajouté');
        return $this->render('create.html.twig');
    }

    /**
     * @param String $slug
     * @return Response
     */
    public function update(String $slug):Response
    {
        $this->addFlash('warning','Votre article a été modifié');
        return $this->render('update.html.twig');
    }

    /**
     * @param String $slug
     * @return Response
     */
    public function delete(String $slug):Response
    {
        $this->addFlash('danger','Votre article a été supprimé');
        return $this->render('delete.html.twig');
    }



}
<?php
namespace App\Controller\Admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\AbstractType;
use Doctrine\Common\Persistence\ObjectManager;

class AdminCategoryController extends AbstractController
{

  /**
   * @var CategoryRepository
   */
  private $repository;

  /**
   * @var ObjectManager
   */
  private $em;

  public function __construct(CategoryRepository $repository, ObjectManager $em)
  {
    $this->repository = $repository;
    $this->em = $em;
  }

  /**
   * @Route("/admin/category", name="admin.category.index")
   * @return \Symfony\Component\HttpFoundation\Response
   */

  public function index()
  {
    $categorys = $this->repository->findAll();
    return $this->render('admin/category/index.html.twig', compact('categorys'));
  }

  /**
  * @Route("/admin/category/create", name="admin.category.new")
  */
  public function new(Request $request)
  {
    $category = new Category();
    $form = $this->createForm(CategoryType::class, $category);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
        $this->em->persist($category);
        $this->em->flush();
        $this->addFlash('success', 'added with success');
        return $this->redirectToRoute('admin.category.index');
    }
    return $this->render('admin/category/new.html.twig', [
      'category' => $category,
      'form' => $form->createView()
    ]);
  }

    /**
    * @Route("/admin/category/{id}", name="admin.category.edit", methods="GET|POST")
    * @param Category $category
    * @param Request $request
    * @return \Symfony\Component\HttpFoundation\Response
    */
  public function edit(Category $category, Request $request)
  {
      $form = $this->createForm(CategoryType::class, $category);
      $form->handleRequest($request);
      if($form->isSubmitted() && $form->isValid())
      {
          $this->em->flush();
          $this->addFlash('success', 'modified with success');
          return $this->redirectToRoute('admin.category.index');
      }
      return $this->render('admin/category/edit.html.twig', [
        'category' => $category,
        'form' => $form->createView()
      ]);
  }

  /**
  * @Route("/admin/category/{id}", name="admin.category.delete", methods="DELETE")
  * @param Category $category
  * @param Request $request
  * @return \Symfony\Component\HttpFoundation\Response
  */
  public function delete(Category $category, Request $request)
  {
    if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->get('_token') )){
      $this->em->remove($category);
      $this->em->flush();
      $this->addFlash('success', 'deleted with success');
    }
    return $this->redirectToRoute('admin.category.index');
  }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Menu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct( private AdminUrlGenerator $adminUrlGenerator)
    {
    }
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator->setController(crudControllerFqcn:ArticleCrudController::class)
            ->generateUrl();
        
        return $this->redirect($url);

    }
    
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
        ->setTitle('blog1-cms');
    }
    
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Aller sur le site', 'fa fa-undo', 'app_home');

        yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les articles', 'fas fa-newspaper', Article::class),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Article::class)->setAction(actionName: Crud::PAGE_NEW),
            
            MenuItem::linkToCrud('Catégories', 'fas fa-list', Categorie::class),
        ]);

        yield MenuItem::linkToCrud('Commentaires', 'fas fa-comment', Commentaire::class);
    }
}

// $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

// Option 1. You can make your dashboard redirect to some common page of your backend
//
// return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

// Option 2. You can make your dashboard redirect to different pages depending on the user
//
// if ('jane' === $this->getUser()->getUsername()) {
//     return $this->redirect('...');
// }

// Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
// (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
//
// return $this->render('some/path/my-dashboard.html.twig');
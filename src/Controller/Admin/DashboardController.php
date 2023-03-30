<?php

namespace App\Controller\Admin;

use App\Entity\Animation;
use App\Entity\Carte;
use App\Entity\Compte;
use App\Entity\Cru;
use App\Entity\Partenaire;
use App\Entity\Produit;
use App\Entity\Vigneron;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');
        $this->isGranted('ROLE_ADMIN');

        return $this->render('admin/index.html.twig');

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
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
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Age Of Champagne');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Comptes', 'fas fa-circle-user', Compte::class);
        yield MenuItem::linkToCrud('Animations', 'fas fa-heart', Animation::class);
        yield MenuItem::linkToCrud('Cartes', 'fas fa-square', Carte::class);
        yield MenuItem::linkToCrud('Partenaires', 'fas fa-people-group', Partenaire::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-wine-bottle', Produit::class);
        yield MenuItem::linkToCrud('Vignerons', 'fas fa-droplet', Vigneron::class);
        yield MenuItem::linkToCrud('Crus', 'fas fa-wine-glass', Cru::class);
        yield MenuItem::linkToRoute('Retour', 'fas fa-solid fa-right-from-bracket', 'app_carte');
    }
}

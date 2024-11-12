<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Quest;
use App\Entity\Tips;
use App\Entity\User;
use App\Entity\Badges;
use App\Entity\Challenge;
use App\Entity\Experiences;
use App\Entity\Friends;
use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;


class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // Option 1. Make your dashboard redirect to the same page for all users
        return $this->redirect($adminUrlGenerator->setController(ArticlesCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('EcoGrow');
    }

    public function configureMenuItems(): iterable
    {
        //Articles
        yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper', Articles::class);
        // User
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        // Bagdes
        yield MenuItem::linkToCrud('Badges', 'fas fa-certificate', Badges::class);
        // Challenge
        // yield MenuItem::linkToCrud('Challenges', 'fas fa-trophy', Challenge::class);
        //Experience
        yield MenuItem::linkToCrud('Experience', 'fas fa-star', Experiences::class);
        //Friends
        yield MenuItem::linkToCrud('Friends', 'fas fa-user-friends', Friends::class);
        // Product
        yield MenuItem::linkToCrud('Products', 'fas fa-shopping-cart', Product::class);
        //Quest
        yield MenuItem::linkToCrud('Quests', 'fas fa-tasks', Quest::class);
        //Tips
        yield MenuItem::linkToCrud('Tips', 'fas fa-lightbulb', Tips::class);

//        yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

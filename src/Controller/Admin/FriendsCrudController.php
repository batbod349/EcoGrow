<?php

namespace App\Controller\Admin;

use App\Entity\Friends;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FriendsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Friends::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('user1'),
            AssociationField::new('user2'),
            BooleanField::new('accepted'),
        ];
    }

}

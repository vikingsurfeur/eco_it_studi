<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    /* Display the Users have the instructor role */
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('roles', null, ['label' => 'Roles']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('email'),
            TextField::new('firstname', 'Prénom'),
            TextField::new('lastname', 'Nom'),
            ArrayField::new('roles', 'Roles'),
            BooleanField::new('isAccepted', 'Accepté'),
            TextEditorField::new('description'),
        ];
    }
}

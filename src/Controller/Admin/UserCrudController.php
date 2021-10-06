<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('User')
            ->setEntityLabelInPlural('Users')
            ->setSearchFields(['id', 'username', 'roles'])
            ->setDefaultSort(['username' => 'ASC', 'id' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        $id = NumberField::new('id');
        if (Crud::PAGE_EDIT === $pageName || Crud::PAGE_NEW === $pageName) {
            yield $id->setFormTypeOption('disabled', true);
        } else {
            yield $id;
        }

        yield TextField::new('username');
        yield ArrayField::new('roles');

        $password = TextField::new('password');
        if (Crud::PAGE_EDIT === $pageName) {
            yield $password->setFormTypeOption('disabled', true);
        } else {
            yield $password;
        }
    }
}

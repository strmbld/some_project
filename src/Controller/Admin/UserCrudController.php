<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Request;

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
        $id = NumberField::new('id')->hideWhenCreating();
        if (Crud::PAGE_EDIT === $pageName) {
            yield $id->setFormTypeOption('disabled', true);
        } else {
            yield $id;
        }

        yield TextField::new('username');
        yield ArrayField::new('roles');

        yield TextField::new('plainPassword');

        $password = TextField::new('password')->hideWhenCreating();
        if (Crud::PAGE_EDIT === $pageName) {
            yield $password->setFormTypeOption('disabled', true);
        } else {
            yield $password;
        }
    }

    public function configureActions(Actions $actions): Actions
    {
        $action = parent::configureActions($actions)->getAsDto(Crud::PAGE_INDEX)->getAction(Crud::PAGE_INDEX, Action::EDIT);

        if (!\is_null($action)) {
            $action->setDisplayCallable(static function ($entity) {
                return !array_search('ROLE_ADMIN', $entity->getRoles());
            });
        }

        $deleteFromList = Action::new('deleteFromList', 'Delete from list', 'trash')
            ->linkToCrudAction('deleteFromList');

        return $actions
            ->add(Crud::PAGE_INDEX, $deleteFromList)
            ->disable(Action::DELETE)
            ;
    }

    public function deleteFromList(Request $request)
    {
        $id = $request->query->get('entityId');

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        $entityManager->remove($user);
        $entityManager->flush();

        return $this->redirect($request->headers->get('referer'));
    }
}

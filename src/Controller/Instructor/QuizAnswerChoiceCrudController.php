<?php

namespace App\Controller\Instructor;

use App\Entity\QuizAnswerChoice;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class QuizAnswerChoiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return QuizAnswerChoice::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        // add a custom filter
        $queryBuilder->andWhere('entity.createdBy = :user');
        $queryBuilder->setParameter('user', $this->getUser());

        return $queryBuilder;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('choiceDescription', 'Réponse'),
            BooleanField::new('isCorrectAnswer', 'Est-ce la bonne réponse ?'),
            AssociationField::new('quizQuestions', 'Questions associées')
                ->setQueryBuilder(
                    fn (QueryBuilder $queryBuilder) => $queryBuilder
                        ->andWhere('entity.createdBy = :user')
                        ->setParameter('user', $this->getUser())
                ),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fas fa-plus-circle')->setLabel('Ajouter une réponse');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fas fa-trash-alt')->setLabel('Supprimer une réponse');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fas fa-edit')->setLabel('Modifier une réponse');
            });
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Ajouter une réponse')
            ->setPageTitle('edit', 'Modifier une réponse')
            ->setPageTitle('index', 'Mes réponses');
    }
}

<?php

namespace App\Controller\User;

use App\Entity\UserQuizResult;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserQuizResultCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserQuizResult::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        // add a custom filter
        $queryBuilder->andWhere('entity.isResolvedBy = :user');
        $queryBuilder->setParameter('user', $this->getUser());

        return $queryBuilder;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('quiz')
                ->formatValue(fn ($value, $entity) => $entity->getQuiz()->getTitle()),
            NumberField::new('nbGoodAnswers', 'Nombre de bonnes réponses'),
            DateField::new('answeredAt', 'Répondu le'),
            BooleanField::new('isResolved', 'Résolu')
                ->setFormTypeOption('disabled','disabled'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::DELETE, Action::EDIT);
    }
}

<?php

namespace App\Controller\Instructor;

use App\Entity\Lesson;
use App\Form\DocumentsFormType;
use App\Form\ImagesFormType;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LessonCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Lesson::class;
    }

    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = parent::createIndexQueryBuilder($searchDto, $entityDto, $fields, $filters);

        // add a custom filter
        $queryBuilder->andWhere('entity.user = :user');
        $queryBuilder->setParameter('user', $this->getUser());

        return $queryBuilder;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            AssociationField::new('section')
                ->setRequired(true)
                ->setQueryBuilder(
                    fn (QueryBuilder $queryBuilder) => $queryBuilder
                        ->andWhere('entity.user = :user')
                        ->setParameter('user', $this->getUser())
                ),
            DateField::new('updatedAt', 'Modifi?? le')->hideOnForm(),
            DateField::new('createdAt', 'Cr???? le')->hideOnForm(),
            TextField::new('video')
                ->setLabel('Ins??rer le lien embed de la vid??o, non l\'URL compl??te.
                    Pour obtenir le lien embed d\'une vid??o, 
                    cliquez sur le bouton "Partager", puis int??grer <>')
                ->onlyOnForms(),
            CollectionField::new('imagesLesson', 'Images')
                ->setEntryType(ImagesFormType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms(),
            CollectionField::new('documentsLesson', 'Documents')
                ->setEntryType(DocumentsFormType::class)
                ->setFormTypeOption('by_reference', false)
                ->onlyOnForms(),
            SlugField::new('slug')->setTargetFieldName('title')->hideOnIndex(),
            TextareaField::new('explanation', 'Description')->onlyOnForms(),
            TextEditorField::new('explanation', 'Descrption')->onlyOnIndex(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fas fa-plus-circle')->setLabel('Ajouter une lesson');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon('fas fa-trash-alt')->setLabel('Supprimer une lesson');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fas fa-edit')->setLabel('Modifier une lesson');
            });
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('new', 'Ajouter une lesson')
            ->setPageTitle('edit', 'Modifier une lesson')
            ->setPageTitle('index', 'Mes lessons');
    }
}

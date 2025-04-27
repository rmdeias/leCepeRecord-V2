<?php

namespace App\Controller\Admin;

use App\Entity\Band;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BandCrudController extends AbstractCrudController
{
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Artist')
            ->setEntityLabelInPlural('Artists');
    }
    public static function getEntityFqcn(): string
    {
        return Band::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextField::new('link_instagram'),
            TextField::new('link_facebook'),
            TextField::new('link_youtube'),
            TextField::new('iframe_youtube'),
            TextField::new('iframe_bandcamp'),
            SlugField::new('slug')
                ->setTargetFieldName('name')
                ->hideOnIndex(),
            ImageField::new('illustration')
                ->setUploadDir('public/uploads/images/artists/')
                ->setBasePath('uploads/images/artists/')
                ->setRequired(false),
            TextEditorField::new('description'),
        ];
    }

}

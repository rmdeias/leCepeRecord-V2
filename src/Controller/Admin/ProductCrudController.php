<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\ProductAttribute;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Product')
            ->setEntityLabelInPlural('Products');
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('band')
             ->setRequired(true),

            TextField::new('title')
            ->setRequired(true),

            SlugField::new('slug')
                ->setTargetFieldName('title')
                ->hideOnIndex(),

            ChoiceField::new('type')
                ->setChoices([
                    'Vinyl' => 'Vinyl',
                    'CD' => 'CD',
                    'Cassette' => 'Cassette',
                    'Sticker' => 'Sticker',
                    'T-shirt' => 'T-shirt',
                ])
                ->setLabel('Type'),

            TextEditorField::new('description'),

            MoneyField::new('price')->setCurrency('EUR'),

            DateField::new('release_date')
                ->setTimezone('Europe/Paris'),

            ImageField::new('illustration')
                ->setUploadDir('public/uploads/images/products/')
                ->setBasePath('uploads/images/products/')
                ->setUploadedFileNamePattern('[slug].[extension]')
                ->setRequired(false),


            ImageField::new('illustration_alt')
                ->setUploadDir('public/uploads/images/products/')
                ->setBasePath('uploads/images/products/')
                ->setUploadedFileNamePattern('[slug]-alt.[extension]')
                ->setRequired(false),

            TextField::new('iframe_bandcamp'),
            TextField::new('link_bandcamp'),

        ];


    }

}

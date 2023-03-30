<?php

namespace App\Controller\Admin;

use App\Entity\Produit;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProduitCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Produit::class;
    }

    public function configureFields(string $pageName): iterable
    {
        // TODO régler le bug de save

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('libelle', 'Libéllé'),
            MoneyField::new('prix', 'Prix')->setCurrency('EUR'),
            AssociationField::new('vigneronsProd', 'Vignerons')->setFormTypeOption('choice_label', function ($vigneron) {
                return $vigneron->getNomPrenom();
            })
                ->setFormTypeOption('query_builder', function (EntityRepository $ep) {
                    return $ep->createQueryBuilder('c')->orderBy('c.nom', 'ASC');
                })
                ->formatValue(function ($value, $entity) {
                    if (null != $entity->getVigneronsProd()[0]) {
                        // Affiche ... si il y a plus d'un vignerons
                        if (count($entity->getVigneronsProd()) > 1) {
                            return $entity->getVigneronsProd()[0]->getNom().' '.$entity->getVigneronsProd()[0]->getPrenom().'...';
                        }

                        return $entity->getVigneronsProd()[0]->getNom().' '.$entity->getVigneronsProd()[0]->getPrenom();
                    }

                    return 'Pas de vignerons';
                }),
        ];
    }
}

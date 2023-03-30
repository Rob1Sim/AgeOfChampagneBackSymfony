<?php

namespace App\Controller\Admin;

use App\Entity\Partenaire;
use App\Entity\Vigneron;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PartenaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Partenaire::class;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($vignerons = $this->getContext()->getRequest()->get('Partenaire')['vigneronsPart']) {
            if (is_array($vignerons)) {
                foreach ($vignerons as $v) {
                    // TODO : Enlever les vignerons en trop
                    $vignronClass = Vigneron::findVigneron($entityManager, $v);
                    $vignronClass->addPartenaire($entityInstance);
                }
            } else {
                Vigneron::findVigneron($entityManager, $vignerons)->addPartenaire($entityInstance);
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // N'est appelé que lorsque on ajoute une donnée et donc non pendant la modification

        if ($vignerons = $this->getContext()->getRequest()->get('Partenaire')['vigneronsPart']) {
            if (is_array($vignerons)) {
                foreach ($vignerons as $v) {
                    Vigneron::findVigneron($entityManager, $v)->addPartenaire($entityInstance);
                }
            } else {
                Vigneron::findVigneron($entityManager, $vignerons)->addPartenaire($entityInstance);
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        // TODO régler le bug de save
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            AssociationField::new('vigneronsPart', 'Vignerons partenaires')
                ->setFormTypeOption('choice_label', function ($vigneron) {
                    return $vigneron->getNom().' '.$vigneron->getPrenom();
                })
                ->formatValue(function ($value, $entity) {
                    if (null != $entity->getVigneronsPart()[0]) {
                        // Affiche ... si il y a plus d'un vignerons
                        if (count($entity->getVigneronsPart()) > 1) {
                            return $entity->getVigneronsPart()[0]->getNom().' '.$entity->getVigneronsPart()[0]->getPrenom().'...';
                        }

                        return $entity->getVigneronsPart()[0]->getNom().' '.$entity->getVigneronsPart()[0]->getPrenom();
                    }

                    return 'Pas de vignerons';
                }),
        ];
    }
}

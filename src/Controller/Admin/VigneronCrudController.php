<?php

namespace App\Controller\Admin;

use App\Entity\Vigneron;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class VigneronCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vigneron::class;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->saveDatas($entityInstance);
        if ($contenuImage = $this->getContext()->getRequest()) {
            if (!('image/jpeg' == $contenuImage->files->get('Vigneron')['contenuImage']['file']->getClientMimeType()
                || 'image/png' == $contenuImage->files->get('Vigneron')['contenuImage']['file']->getClientMimeType())) {
                return;
            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // N'est appelé que lorsque on ajoute une donnée et donc non pendant la modification

        $this->saveDatas($entityInstance);
        if ($contenuImage = $this->getContext()->getRequest()) {
            if (!('image/jpeg' == $contenuImage->files->get('Vigneron')['contenuImage']['file']->getClientMimeType()
                || 'image/png' == $contenuImage->files->get('Vigneron')['contenuImage']['file']->getClientMimeType())) {
                return;
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom', 'Nom'),
            TextField::new('prenom', 'Prénom'),
            TextField::new('adresse', 'Adresse'),
            TextField::new('code_postal', 'Code postal')->setMaxLength(5)
            ->setFormTypeOption('attr', ['maxlength' => 5]),
            TextField::new('ville', 'Ville'),
            AssociationField::new('partenaire', 'Partenaires')
                ->setFormTypeOption('choice_label', function ($partenaire) {
                    return $partenaire->getNom().' '.$partenaire->getPrenom();
                })->formatValue(function ($value, $entity) {
                    if (null !== $entity->getPartenaire()[0]) {
                        // Affiche ... si il y a plus d'un partenaires
                        if (count($entity->getPartenaire()) > 1) {
                            return $entity->getPartenaire()[0]->getNom().' '.$entity->getPartenaire()[0]->getPrenom().'...';
                        }

                        return $entity->getPartenaire()[0]->getNom().' '.$entity->getPartenaire()[0]->getPrenom();
                    } else {
                        return 'Pas de partenaires';
                    }
                }),
            AssociationField::new('animation', 'Animations')
                ->setFormTypeOption('choice_label', function ($animation) {
                    return $animation->getNom();
                })->formatValue(function ($value, $entity) {
                    if (null !== $entity->getAnimation()[0]) {
                        // Affiche ... si il y a plus d'une animations
                        if (count($entity->getAnimation()) > 1) {
                            return $entity->getAnimation()[0]->getNom().'...';
                        }

                        return $entity->getAnimation()[0]->getNom();
                    } else {
                        return "Pas d'animations";
                    }
                }),
            ImageField::new('contenuImage', 'Image du vigneron')
            ->setUploadDir('public/uploads/img/vigneron/')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->onlyOnForms()
                ->addHtmlContentsToBody("<script src='js/vigneron.js' ></script>"),
        ];
    }

    public function saveDatas($entityInstance): void
    {
        if ($name = $this->getContext()->getRequest()->get('Vigneron')['nom']) {
            $entityInstance->setNom($name);
        }
        if ($prenom = $this->getContext()->getRequest()->get('Vigneron')['prenom']) {
            $entityInstance->setPrenom($prenom);
        }
        if ($adresse = $this->getContext()->getRequest()->get('Vigneron')['adresse']) {
            $entityInstance->setAdresse($adresse);
        }
        if ($codepostal = $this->getContext()->getRequest()->get('Vigneron')['code_postal']) {
            $entityInstance->setCodePostal($codepostal);
        }
        if ($ville = $this->getContext()->getRequest()->get('Vigneron')['ville']) {
            $entityInstance->setVille($ville);
        }
    }
}

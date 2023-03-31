<?php

namespace App\Controller\Admin;

use App\Entity\Carte;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CarteCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Carte::class;
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->saveDatas($entityInstance);
        if ($contenuImage = $this->getContext()->getRequest()) {
            if (!('image/jpeg' == $contenuImage->files->get('Carte')['contenuImage']['file']->getClientMimeType()
                || 'image/png' == $contenuImage->files->get('Carte')['contenuImage']['file']->getClientMimeType())) {
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
            if (!('image/jpeg' == $contenuImage->files->get('Carte')['contenuImage']['file']->getClientMimeType()
                || 'image/png' == $contenuImage->files->get('Carte')['contenuImage']['file']->getClientMimeType())) {
                return;
            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('type'),
            AssociationField::new('cru_r', 'Cru')->setFormTypeOption('choice_label', function ($cru) {
                return $cru->getlibelle();
            })
                ->setFormTypeOption('query_builder', function (EntityRepository $ep) {
                    return $ep->createQueryBuilder('c')->orderBy('c.libelle', 'ASC');
                })
                ->formatValue(function ($value, $entity) {
                    return $entity->getCruR()->getlibelle();
                }),
            TextField::new('region'),
            NumberField::new('latitude'),
            NumberField::new('longitude'),
            NumberField::new('superficie'),
            AssociationField::new('vignerons')->setFormTypeOption('choice_label', function ($vigneron) {
                return $vigneron->getNomPrenom();
            })
                ->setFormTypeOption('query_builder', function (EntityRepository $ep) {
                    return $ep->createQueryBuilder('c')->orderBy('c.nom', 'ASC');
                })
                ->formatValue(function ($value, $entity) {
                    return $entity->getVignerons()->getNom().' '.$entity->getVignerons()->getPrenom();
                }),
            ImageField::new('contenuImage', 'Image de la carte')
                ->setUploadDir('public/uploads/img/')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->onlyOnForms()
                ->addHtmlContentsToBody("<script src='js/form.js' ></script>"),
        ];
    }

    public function saveDatas($entityInstance): void
    {
        if ($name = $this->getContext()->getRequest()->get('Carte')['nom']) {
            $entityInstance->setNom($name);
        }
        if ($type = $this->getContext()->getRequest()->get('Carte')['type']) {
            $entityInstance->setType($type);
        }
        if ($region = $this->getContext()->getRequest()->get('Carte')['region']) {
            $entityInstance->setRegion($region);
        }
        if ($latitude = $this->getContext()->getRequest()->get('Carte')['latitude']) {
            $entityInstance->setLatitude($latitude);
        }
        if ($superficie = $this->getContext()->getRequest()->get('Carte')['superficie']) {
            $entityInstance->setSuperficie($superficie);
        }
    }
}

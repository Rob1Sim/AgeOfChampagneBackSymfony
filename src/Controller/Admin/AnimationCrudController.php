<?php

namespace App\Controller\Admin;

use App\Entity\Animation;
use App\Entity\Vigneron;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AnimationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Animation::class;
    }


    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $this->saveDatas($entityInstance);
        if ($contenuImage = $this->getContext()->getRequest()) {
            if (!('image/jpeg' == $contenuImage->files->get('Animation')['contenuImage']['file']->getClientMimeType()
                || 'image/png' == $contenuImage->files->get('Animation')['contenuImage']['file']->getClientMimeType())) {
                return;
            }
        }

        if ($vignerons = $this->getContext()->getRequest()->get('Animation')['vigneronsAnim']) {
            if (is_array($vignerons)){
                foreach ($vignerons as $v){
                    Vigneron::findVigneron($entityManager, $v)->addAnimation($entityInstance);

                }
            }else{
                Vigneron::findVigneron($entityManager, $vignerons)->addAnimation($entityInstance);

            }
        }

        parent::updateEntity($entityManager, $entityInstance);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // N'est appelé que lorsque on ajoute une donnée et donc non pendant la modification

        $this->saveDatas($entityInstance);
        if ($contenuImage = $this->getContext()->getRequest()) {
            if (!('image/jpeg' == $contenuImage->files->get('Animation')['contenuImage']['file']->getClientMimeType()
                || 'image/png' == $contenuImage->files->get('Animation')['contenuImage']['file']->getClientMimeType())) {
                return;
            }
        }

        if ($vignerons = $this->getContext()->getRequest()->get('Animation')['vigneronsAnim']) {
            if (is_array($vignerons)){
                foreach ($vignerons as $v){
                    Vigneron::findVigneron($entityManager, $v)->addAnimation($entityInstance);

                }
            }else{
                Vigneron::findVigneron($entityManager, $vignerons)->addAnimation($entityInstance);

            }
        }

        parent::persistEntity($entityManager, $entityInstance);
    }

    public function configureFields(string $pageName): iterable
    {
        // TODO régler le bug de save

        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('type', 'Type'),
            TextField::new('nom', 'Nom'),
            DateTimeField::new('horaireDeb', 'Horaire de début')->setTimezone('Europe/Paris'),
            DateTimeField::new('horaireFin', 'Horaire de fin')->setTimezone('Europe/Paris'),
            MoneyField::new('prix', 'Prix')->setCurrency('EUR'),
            AssociationField::new('vigneronsAnim', 'Vignerons')->setFormTypeOption('choice_label', function ($vigneron) {
                return $vigneron->getNomPrenom();
            })
                ->setFormTypeOption('query_builder', function (EntityRepository $ep) {
                    return $ep->createQueryBuilder('c')->orderBy('c.nom', 'ASC');
                })
                ->formatValue(function ($value, $entity) {
                    if (null != $entity->getVigneronsAnim()[0]) {
                        // Affiche ... si il y a plus d'un vignerons
                        if (count($entity->getVigneronsAnim()) > 1) {
                            return $entity->getVigneronsAnim()[0]->getNom().' '.$entity->getVigneronsAnim()[0]->getPrenom().'...';
                        }

                        return $entity->getVigneronsAnim()[0]->getNom().' '.$entity->getVigneronsAnim()[0]->getPrenom();
                    }

                    return 'Pas de vignerons';
                }),
            ImageField::new('contenuImage', "Image de l'animation")
                ->setUploadDir('public/uploads/img/animation/')
                ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
                ->onlyOnForms()
                ->addHtmlContentsToBody("<script src='js/animation.js' ></script>"),
        ];
    }

    public function saveDatas($entityInstance): void
    {
        if ($name = $this->getContext()->getRequest()->get('Animation')['nom']) {
            $entityInstance->setNom($name);
        }
        if ($type = $this->getContext()->getRequest()->get('Animation')['type']) {
            $entityInstance->setType($type);
        }
        /*if ($hdeb = $this->getContext()->getRequest()->get('Animation')['horaireDeb']) {
            $entityInstance->setHoraireDeb($hdeb);
        }
        if ($hfin = $this->getContext()->getRequest()->get('Animation')['horaireFin']) {
            $entityInstance->setHoraireFin($hfin);
        }*/
        if ($prix = $this->getContext()->getRequest()->get('Animation')['prix']) {
            $entityInstance->setPrix($prix);
        }
    }
}

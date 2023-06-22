<?php

namespace App\Controller;

use App\Entity\Another;
use App\Entity\Bar;
use App\Entity\Foo;
use App\Repository\FooRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/')]
    public function index(FooRepository $fooRepository): Response
    {
        $foos = $fooRepository->findAll();

        if (empty($foos)) {
            throw new \Exception('Please load fixtures and try again.');
        }

        return $this->render('index.html.twig', [
            'foos' => $fooRepository->findAll()
        ]);
    }

    #[Route('/case1/{root?null}/{parent?}', name: 'case1')]
    public function case1(
        ?Foo $root = null,
        #[MapEntity] ?Foo $parent = null,
        #[MapEntity(id: 'child')] ?Foo $child = null,
    ): Response {
        dd(
            root: $root ? $root?->getId().' - '.$root : 'Not loaded',
            parent: $parent ? $parent->getId().' - '.$parent : 'Not loaded',
            child: $child ? $child->getId().' - '.$child : 'Not loaded',
        );
    }

    #[Route('/case2/{root?null}/{parent?}', name: 'case2')]
    public function case2(
        ?Foo $root = null,
        #[MapEntity] ?Foo $parent = null,
        #[MapEntity] ?Foo $child = null,
    ): Response {
        dd(
            root: $root ? $root?->getId().' - '.$root : 'Not loaded',
            parent: $parent ? $parent->getId().' - '.$parent : 'Not loaded',
            child: $child ? $child->getId().' - '.$child : 'Not loaded',
        );
    }

    #[Route('/case3/{ro?null}/{pa?}', name: 'case3')]
    public function case3(
        ?Foo $ro = null,
        #[MapEntity] ?Foo $pa = null,
        #[MapEntity] ?Foo $ch = null,
    ): Response {
        dd(
            root: $ro ? $ro->getId().' - '.$ro : 'Not loaded',
            parent: $pa ? $pa->getId().' - '.$pa : 'Not loaded',
            child: $ch ? $ch->getId().' - '.$ch : 'Not loaded',
        );
    }

    #[Route('/case4/{root?null}/{parent?}', name: 'case4')]
    public function case4(
        ?Foo $root = null,
        ?Foo $parent = null,
        ?Foo $child = null,
    ): Response {
        dd(
            root: $root ? $root?->getId().' - '.$root : 'Not loaded',
            parent: $parent ? $parent->getId().' - '.$parent : 'Not loaded',
            child: $child ? $child->getId().' - '.$child : 'Not loaded',
        );
    }

    #[Route('/case5/{root?null}/{parent?null}/{child?}', name: 'case5')]
    public function case5(
        ?Foo $root = null,
        ?Foo $parent = null,
        ?Foo $child = null,
    ): Response {
        dd(
            root: $root ? $root?->getId().' - '.$root : 'Not loaded',
            parent: $parent ? $parent->getId().' - '.$parent : 'Not loaded',
            child: $child ? $child->getId().' - '.$child : 'Not loaded',
        );
    }


    #[Route('/case6/{root?null}/{parent?}', name: 'case6')]
    public function case6(
        ?Foo $root = null,
        #[MapEntity] ?Foo $parent = null,
        #[MapEntity] ?Bar $child = null,
    ): Response {
        dd(
            root: $root ? $root?->getId().' - '.$root : 'Not loaded',
            parent: $parent ? $parent->getId().' - '.$parent : 'Not loaded',
            child: $child ? $child->getId().' - '.$child : 'Not loaded',
        );
    }

}

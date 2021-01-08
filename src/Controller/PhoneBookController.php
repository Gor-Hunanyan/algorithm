<?php


namespace App\Controller;

use App\Entity\PhoneBook;
use App\Validator\CountryCode;
use App\Validator\PhoneNumber;
use App\Validator\TimeZone;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validation;

class PhoneBookController
{
    public function listAction(Request $request, EntityManager $em)
    {
        $phones = $em->getRepository(PhoneBook::class)->getPhones($request->get('$offset',0), $request->get('limit', 10));

        $array = [];

        foreach ($phones as $phone){
            $array[] = $phone->toArray();
        }

        return new Response(json_encode($array));
    }

    public function createAction(Request $request, EntityManager $em)
    {
        $data = json_decode($request->getContent(),true);

        $validator = Validation::createValidator();

        $phoneBook = new PhoneBook();
        $phoneBook->setFirstName($data['firstName']);
        $phoneBook->setLastName($data['lastName'] ?? null);
        $phoneBook->setPhoneNumber($data['phoneNumber']);
        $phoneBook->setCountryCode($data['countryCode'] ?? null);
        $phoneBook->setTimezoneName($data['timezoneName'] ?? null);
        $phoneBook->setUpdatedOn();
        $phoneBook->setInsertedOn();

        $errors = $validator->validate($phoneBook, [new CountryCode(), new TimeZone(), new PhoneNumber()]);

        if($errors->count() != 0){
            return new Response($errors);
        }

        $em->persist($phoneBook);
        $em->flush();

        return new Response(json_encode($phoneBook->toArray()));
    }

    public function getAction($id, EntityManager $em)
    {
        $phone = $em->getRepository(PhoneBook::class)->find($id);

        if(is_null($phone)){
            return new Response('Id is not defined');
        }

        return new Response(json_encode($phone->toArray()));
    }

    public function updateAction($id, Request $request, EntityManager $em)
    {
        $data = json_decode($request->getContent(), true);

        $phoneBook = $em->getRepository(PhoneBook::class)->find($id);

        if(is_null($phoneBook)){
            return new Response('Id is not defined');
        }

        $phoneBook->setFirstName($data['firstName']);
        $phoneBook->setLastName($data['lastName'] ?? null);
        $phoneBook->setPhoneNumber($data['phoneNumber']);
        $phoneBook->setCountryCode($data['countryCode'] ?? null);
        $phoneBook->setTimezoneName($data['timezoneName'] ?? null);
        $phoneBook->setUpdatedOn();

        $validator = Validation::createValidator();
        $errors = $validator->validate($phoneBook, [new CountryCode(), new TimeZone()]);

        if($errors->count() != 0){
            return new Response($errors);
        }

        $em->persist($phoneBook);
        $em->flush();

        return new Response(json_encode($phoneBook->toArray()));
    }

    public function deleteAction($id, EntityManager $em)
    {
        $phone = $em->getRepository(PhoneBook::class)->find($id);

        if(is_null($phone)){
            return new Response('Id is not defined');
        }

        $em->remove($phone);
        $em->flush();

        return new Response();
    }
}

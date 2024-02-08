<?php

namespace App\services;

use App\services\ParserService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class CrudService
{
    private EntityManagerInterface $manager;
    private ParserService $parser;

    public function __construct(EntityManagerInterface $manager, ParserService $parser)
    {
        $this->manager = $manager;
        $this->parser = $parser;
    }

    public function get($type): array
    {
        return $this->manager->getRepository($type)->findAll();
    }

    public function persist($content, $type): void
    {
        $model = $this->parseObject($content,$type);
        $this->persistObject($model);

    }
    public function parseObject($content,$type,$oldModel = null){
        return $this->parser->parse($content,$type,$oldModel);
    }
    public function persistObject($model){
        $this->manager->persist($model);
        $this->manager->flush();
    }

    public function update($oldModel, $content, $type): void
    {
        $model = $this->parseObject($content, $type, $oldModel);
        $this->persistObject($model);
    }

    public function remove($model): void
    {
        $this->manager->remove($model);
        $this->manager->flush();
    }
    public function findById($id,$type){
        return $this->manager->getRepository($type)->find($id);
    }
}

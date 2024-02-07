<?php
namespace App\service;

use App\util\NotSuitableException;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ParserService{
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;

    public function __construct(SerializerInterface $serializer,ValidatorInterface $validator) {
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    public function parse(string $content,string $type,$objectToPopulate = null){
        $model = $this->serializer->deserialize($content,$type,'json',[AbstractNormalizer::OBJECT_TO_POPULATE=>$objectToPopulate]);
        $errors = $this->validator->validate($model);
        if(count($errors) > 0){
             $message = "";
             foreach($errors as $error){
                 $message = $message." ".$error->getMessage();
             }
             throw new NotSuitableException($message);
        }
        return $model;
    }
}
?>
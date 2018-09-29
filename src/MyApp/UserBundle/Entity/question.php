<?php
/**
 * Created by PhpStorm.
 * User: asma
 * Date: 07/04/2017
 * Time: 12:22
 */

namespace MyApp\UserBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="question")
 * @ORM\Entity
 */
class question
{


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;


    /**
     * @var string
     *
     * @ORM\Column(name="question", type="text", length=65535)
     */
    private $question;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    /**
     * @return string
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param string $question
     */
    public function setQuestion($question)
    {
        $this->question = $question;
    }






}
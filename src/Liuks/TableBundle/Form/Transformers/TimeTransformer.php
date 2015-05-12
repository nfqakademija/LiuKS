<?php

namespace Liuks\TableBundle\Form\Transformers;

use Symfony\Component\Form\DataTransformerInterface;

class TimeTransformer implements DataTransformerInterface
{
    /**
     * @var string
     */
    private $format;

    /**
     * @param string $format
     */
    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * @param integer $time
     * @return bool|string
     */
    public function transform($time)
    {
        $date = new \DateTime();
        $date->setTimestamp($time);
        return $date;
    }

    /**
     * @param mixed $date
     * @return string
     */
    public function reverseTransform($date)
    {
        return $date->getTimestamp();
    }
}

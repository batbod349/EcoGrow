<?php
namespace App\Twig;

use App\Service\EcopagnonService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class EcopagnonExtension extends AbstractExtension
{
    private $ecopagnonService;

    public function __construct(EcopagnonService $ecopagnonService)
    {
        $this->ecopagnonService = $ecopagnonService;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getEcopagnonMood', [$this->ecopagnonService, 'getEcopagnonMood']),
        ];
    }
}

<?php
namespace DrdPlus\Tests\Professions\Entities;

use Doctrineum\Entity\Entity;
use Doctrine\ORM\Mapping as ORM;
use DrdPlus\Professions\Fighter;
use DrdPlus\Professions\Priest;
use DrdPlus\Professions\Profession;
use DrdPlus\Professions\Ranger;
use DrdPlus\Professions\Theurgist;
use DrdPlus\Professions\Thief;
use DrdPlus\Professions\Wizard;

/**
 * @ORM\Entity()
 */
class SomeEntityWithProfessions implements Entity
{
    /**
     * @var int
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Fighter|null
     * @ORM\Column(type="profession", nullable=true)
     */
    private $fighter;

    /**
     * @var Thief|null
     * @ORM\Column(type="profession", nullable=true)
     */
    private $thief;

    /**
     * @var Wizard|null
     * @ORM\Column(type="profession", nullable=true)
     */
    private $wizard;

    /**
     * @var Priest|null
     * @ORM\Column(type="profession", nullable=true)
     */
    private $priest;

    /**
     * @var Theurgist|null
     * @ORM\Column(type="profession", nullable=true)
     */
    private $theurgist;

    /**
     * @var Ranger|null
     * @ORM\Column(type="profession", nullable=true)
     */
    private $ranger;

    /**
     * @var Profession|null
     * @ORM\Column(type="profession", nullable=true)
     */
    private $someProfession;

    public function __construct(
        Fighter $fighter = null,
        Thief $thief = null,
        Wizard $wizard = null,
        Priest $priest = null,
        Theurgist $theurgist = null,
        Ranger $ranger = null,
        Profession $someProfession = null
    )
    {
        $this->fighter = $fighter;
        $this->thief = $thief;
        $this->wizard = $wizard;
        $this->priest = $priest;
        $this->theurgist = $theurgist;
        $this->ranger = $ranger;
        $this->someProfession = $someProfession;
    }

    public function getId():? int
    {
        return $this->id;
    }

    /**
     * @return Fighter|null
     */
    public function getFighter():? Fighter
    {
        return $this->fighter;
    }

    /**
     * @return Thief|null
     */
    public function getThief():? Thief
    {
        return $this->thief;
    }

    /**
     * @return Wizard|null
     */
    public function getWizard():? Wizard
    {
        return $this->wizard;
    }

    /**
     * @return Priest|null
     */
    public function getPriest():? Priest
    {
        return $this->priest;
    }

    /**
     * @return Theurgist|null
     */
    public function getTheurgist():? Theurgist
    {
        return $this->theurgist;
    }

    /**
     * @return Ranger|null
     */
    public function getRanger():? Ranger
    {
        return $this->ranger;
    }

    /**
     * @return Profession|null
     */
    public function getSomeProfession():? Profession
    {
        return $this->someProfession;
    }

}
<?php

namespace Application\Pasinter\AdManagerBundle\Entity;

class Campaign {

    /**
     * @var string $code
     */
    private $code;

    /**
     * @var string $description
     */
    private $description;

    /**
     * @var datetime $createdAt
     */
    private $createdAt;

    /**
     * @var datetime $updatedAt
     */
    private $updatedAt;

    /**
     * @var integer $id
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $ads;

    public function __construct() {
        $this->ads = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime;
        $this->updatedAt = new \DateTime;
    }

    /**
     *
     * @return string
     */
    public function __toString() {
        return $this->getCode();
    }

    /**
     * Set code
     *
     * @param string $code
     * @return Campaign
     */
    public function setCode($code) {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode() {
        return $this->code;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Campaign
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param datetime $createdAt
     * @return Campaign
     */
    public function setCreatedAt($createdAt) {
        if ($this->createdAt != null) {
            $this->createdAt = $createdAt;
        } else {
            $this->createdAt = new \DateTime;
        }
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return datetime 
     */
    public function getCreatedAt() {
        if ($this->createdAt == null) {
            return new \DateTime;
        }
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param datetime $updatedAt
     * @return Campaign
     */
    public function setUpdatedAt($updatedAt) {
        if ($this->updatedAt != null) {
            $this->updatedAt = $updatedAt;
        } else {
            $this->updatedAt = new \DateTime;
        }
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return datetime 
     */
    public function getUpdatedAt() {
        if ($this->updatedAt == null) {
            return new \DateTime;
        }
        return $this->updatedAt;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Add ads
     *
     * @param Application\Pasinter\AdManagerBundle\Entity\Ad $ad
     * @return Campaign
     */
    public function addAd(\Application\Pasinter\AdManagerBundle\Entity\Ad $ad) {
        $this->ads[] = $ad;
        if (null !== $ad) {
            $ad->setCampaign($this);
        }

        return $this;
    }

    /**
     *
     * @param Application\Pasinter\AdManagerBundle\Entity\Ad $ad
     * @return Campaign
     */
    public function addAds(\Application\Pasinter\AdManagerBundle\Entity\Ad $ad) {
        return $this->addAd($ad);
    }

    /**
     * Remove ad
     *
     * @param Application\Pasinter\AdManagerBundle\Entity\Ad $ad
     */
    public function removeAd(\Application\Pasinter\AdManagerBundle\Entity\Ad $ad) {
        $this->ads->removeElement($ad);
    }

    /**
     * Get ads
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getAds() {
        return $this->ads;
    }

    public function getAdsCount() {
        return count($this->ads);
    }

}

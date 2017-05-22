<?php
class Contact_Model_Contact
{
    /**
     * @var int $_contactId The sequence ID of this contact
     */
    protected $_contactId;
    /**
     * @var string $_name The name of this contact
     */
    protected $_name;

    /**
     * @return int
     */
    public function getContactId()
    {
        return $this->_contactId;
    }

    /**
     * @param int $contactId
     * @return Contact
     */
    public function setContactId($contactId)
    {
        $this->_contactId = $contactId;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $name
     * @return Contact
     */
    public function setName($name)
    {
        $this->_name = $name;
        return $this;
    }

}
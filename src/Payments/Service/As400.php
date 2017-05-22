<?php

class Payments_Service_As400
{
    const BANKFILES_PATH = '/path/to/bankfiles';
    const PROCESS_SUCCEEDED = 'success';
    const PROCESS_FAILED = 'failure';

    /**
     * @var Zend_Log
     */
    protected $_logger;

    /**
     * @var array
     */
    protected $_mappers = array ();

    /**
     * @var string
     */
    protected $_path;

    /**
     * @return Zend_Log
     */
    public function getLogger()
    {
        return $this->_logger;
    }

    /**
     * @param Zend_Log $logger
     * @return Payments_Service_As400
     */
    public function setLogger($logger)
    {
        $this->_logger = $logger;
        return $this;
    }

    /**
     * @param mixed $mapperClass
     * @param null|string $mapperClassName
     * @return Payments_Service_As400
     */
    public function addMapper($mapperClass, $mapperClassName = null)
    {
        if (null === $mapperClassName) {
            $mapperClassName = get_class($mapperClass);
        }
        $this->_mappers[$mapperClassName] = $mapperClass;
        return $this;
    }

    /**
     * @param string $mapperClassName
     * @return mixed
     */
    public function getMapper($mapperClassName)
    {
        if (!array_key_exists($mapperClassName, $this->_mappers)) {
            $mapper = new $mapperClassName;
            $this->addMapper($mapper);
        }
        return $this->_mappers[$mapperClassName];
    }

    /**
     * @return string
     */
    public function getPath()
    {
        if (null === $this->_path) {
            $this->setPath(self::BANKFILES_PATH);
        }
        return $this->_path;
    }

    /**
     * @param string $path
     * @return Payments_Service_As400
     */
    public function setPath($path)
    {
        $this->_path = $path;
        return $this;
    }

/**
 * Process Bank Payment files
 */
public function processBankPayments()
{
    $this->getLogger()->log('Starting bank payment process', Zend_Log::INFO);
    foreach ($this->_getBankFiles() as $bankFile) {
        $bankData = $this->_processBankFile($bankFile);
        $this->getLogger()->log(
            'Processing ' . $bankData->transactionId,
            Zend_Log::DEBUG
        );
        /** @var Contact_Model_Contact $contact */
        $contact = $this->getMapper('Contact_Model_Mapper_Contact')
            ->findContactByBankAccount($bankData->transactionAccount);
        if (null !== $contact) {
            $this->getLogger()->log(sprintf(
                'Found contact "%s" for bank account %s',
                $contact->getName(),
                $bankData->transactionAccount
            ), Zend_Log::DEBUG);
            $data = array (
                'amount' => $bankData->transactionAmount,
                'payment_date' => $bankData->transactionDate
            );
            $this->getMapper('Invoice_Model_Mapper_Payments')
                ->updatePayment(
                    $data,
                    array ('contact_id = ?' => $contact->getContactId())
                );
            $this->_moveBankFile(
                $bankFile,
                $this->getPath() . DIRECTORY_SEPARATOR . self::PROCESS_SUCCEEDED
            );
        } else {
            $this->getLogger()->log(sprintf(
                'Could not match bankaccount "%s" with a contact',
                $bankData->transactionAccount
            ), Zend_Log::WARN);
            $this->_moveBankFile(
                $bankFile,
                $this->getPath() . DIRECTORY_SEPARATOR . self::PROCESS_FAILED
            );
        }
    }
}

    /**
     * Processes the bank files
     *
     * @return array
     */
    protected function _getBankFiles()
    {
        $fileList = array ();
        $fileIterator = new DirectoryIterator($this->getPath());
        foreach ($fileIterator as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            $fileList[] = $fileInfo->__toString();
        }
        return $fileList;
    }

    /**
     * Processes the bankfiles and returns the complete transaction details
     *
     * @param string $bankFile
     * @return stdClass
     */
    protected function _processBankFile($bankFile)
    {
        $bankDetails = new stdClass();
        $bankFile = new SplFileInfo($this->getPath() . DIRECTORY_SEPARATOR . $bankFile);
        if ($bankFileObj = $bankFile->openFile('r')) {
            while(!$bankFileObj->eof()) {
                $line = $bankFileObj->fgetcsv(';', '"');
                if (5 === count($line)) {
                    $bankDetails->transactionId = $line[0];
                    $bankDetails->transactionDate = $line[1];
                    $bankDetails->transactionAccount = $line[2];
                    $bankDetails->transactionAmount = $line[3];
                    $bankDetails->transactionMessage = $line[4];
                }
            }
        }
        return $bankDetails;
    }

    /**
     * Moves the bankfile to a seperate path for storage
     *
     * @param string $bankFile The complete location of the bank file
     * @param string $path The destination path
     */
    protected function _moveBankFile($bankFile, $path = null)
    {
        if (is_file($bankFile) && null !== $path) {
            if (copy($bankFile, $path . '/' . basename($bankFile))) {
                unlink($bankFile);
            }
        }
    }
}


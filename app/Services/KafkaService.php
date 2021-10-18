<?php
namespace App\Services;

use Exception;
use Enqueue\RdKafka\RdKafkaConnectionFactory;


class KafkaService
{
    protected $context;
    protected $topic;
    private $email;
    private $value;
    private $phoneNumber;
    private $payerName;
    private $brokerList;

    public function __construct($email, $phoneNumber, $value, $payerName)
    {
        $this->brokerList = env('BROKER_LIST');

        $connectionFactory = new RdKafkaConnectionFactory(
            [
                'global' => [
                    'metadata.broker.list' => $this->brokerList,
                ],
                
            ]
        );
        $this->context = $connectionFactory->createContext();
        $this->topic = $this->context->createTopic('notifications');
        $this->email = $email;
        $this->value = $value;
        $this->payerName = $payerName;
        $this->phoneNumber = $phoneNumber;
        
    }
    
    public function sendToSucessQueue()
    {
        $message = $this->context->createMessage("email: $this->email, value: $this->value, payerName: $this->payerName, phoneNumber: $this->phoneNumber");

        $this->context->createProducer()->send($this->topic, $message);
    }    
}

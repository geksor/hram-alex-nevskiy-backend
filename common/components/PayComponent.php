<?php

namespace common\components;

use YandexCheckout\Client;
use YandexCheckout\Common\Exceptions\ApiException;
use YandexCheckout\Common\Exceptions\BadApiRequestException;
use YandexCheckout\Common\Exceptions\ForbiddenException;
use YandexCheckout\Common\Exceptions\InternalServerError;
use YandexCheckout\Common\Exceptions\NotFoundException;
use YandexCheckout\Common\Exceptions\ResponseProcessingException;
use YandexCheckout\Common\Exceptions\TooManyRequestsException;
use YandexCheckout\Common\Exceptions\UnauthorizedException;
use YandexCheckout\Request\Payments\CreatePaymentResponse;
use yii\base\BaseObject;
use yii\base\Component;

/**
 * Class PayComponent
 * @package common\components
 *
 * @property string $shopId
 * @property string $secretKey
 * @property Client $client
 * @property array $errorsArr
 *
 */
class PayComponent extends Component
{
    /**
     * @var array
     */
    public $shopId;
    public $secretKey;
    public $client;

    private static $errorsArr = [
        '3d_secure_failed' => 'Не пройдена аутентификация по 3-D Secure. Обратитесь в банк за уточнениями или использовать другое платежное средство.',
        'call_issuer' => 'Оплата данным платежным средством отклонена по неизвестным причинам.',
        'card_expired' => 'Истек срок действия банковской карты.',
        'country_forbidden' => 'Нельзя заплатить банковской картой, выпущенной в этой стране.',
        'fraud_suspected' => 'Платеж заблокирован из-за подозрения в мошенничестве.',
        'general_decline' => 'Неизвестная ошибка.',
        'identification_required' => 'Превышены ограничения на платежи для кошелька в Яндекс.Деньгах.',
        'insufficient_funds' => 'Не хватает денег для оплаты.',
        'invalid_card_number' => 'Неправильно указан номер карты.',
        'invalid_csc' => 'Неправильно указан код CVV2 (CVC2, CID).',
        'issuer_unavailable' => 'Организация, выпустившая платежное средство, недоступна.',
        'payment_method_limit_exceeded' => 'Исчерпан лимит платежей для данного платежного средства.',
        'payment_method_restricted' => 'Запрещены операции данным платежным средством (возможно карта заблокирована).',
        'permission_revoked' => 'Нельзя провести безакцептное списание.',
    ];

    /**
     * @param $key
     * @return mixed
     */
    public function getErrorsArr($key)
    {
        return self::$errorsArr[$key];
    }

//    public function __construct($shopId, $secretKey, $config = [])
//    {
//        $this->shopId = $shopId;
//        $this->secretKey = $secretKey;
//
//        $this->client = new Client();
//        $this->client->setAuth($this->shopId, $this->secretKey);
//
//        parent::__construct($config);
//    }




    public function init()
    {
        parent::init();

        $this->client = new Client();
        $this->client->setAuth($this->shopId, $this->secretKey);
    }

    /**
     * @param $amount - Сумма платежа
     * @param $desc - Название платежа которое отображается в личном кабинете яндекс кассы
     * @param $link - Ссылка для редиректа после подтверждения платежа без домена со слешом в начале.
     * @return CreatePaymentResponse
     * @throws ApiException
     * @throws BadApiRequestException
     * @throws ForbiddenException
     * @throws InternalServerError
     * @throws NotFoundException
     * @throws ResponseProcessingException
     * @throws TooManyRequestsException
     * @throws UnauthorizedException
     */
    public function createPayment($amount, $desc, $link): CreatePaymentResponse
    {
        return $this->client->createPayment(
            [
//                'payment_token' => $token,
                'amount' => [
                    'value' => $amount,
                    'currency' => 'RUB',
                ],
                'confirmation' => [
                    'type' => 'redirect',
                    'return_url' => 'https://'.\Yii::$app->request->hostName.$link,
                ],
                'capture' => true,
                'description' => $desc,
            ],
            uniqid('', true)
        );
    }
}
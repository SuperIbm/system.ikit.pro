<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Actions;

use App\Models\Action;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserAddress;
use App\Modules\User\Repositories\UserCompany;
use App\Modules\Location\Models\Location;
use Geocoder;

/**
 * Изменение информации о пользователе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSiteUpdateAction extends Action
{
    /**
     * Репозитарий пользователей.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private $_user;

    /**
     * Репозитарий компаний пользователей.
     *
     * @var \App\Modules\User\Repositories\UserCompany
     * @version 1.0
     * @since 1.0
     */
    private $_userCompany;

    /**
     * Репозитарий адреса пользователей.
     *
     * @var \App\Modules\User\Repositories\UserAddress
     * @version 1.0
     * @since 1.0
     */
    private $_userAddress;

    /**
     * Модель локализации.
     *
     * @var \App\Modules\Location\Models\Location
     * @version 1.0
     * @since 1.0
     */
    private $_location;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserCompany $userCompany Репозитарий компаний пользователей.
     * @param \App\Modules\User\Repositories\UserAddress $userAddress Репозитарий адреса пользователей.
     * @param \App\Modules\Location\Models\Location $location Модель локализации.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserCompany $userCompany, UserAddress $userAddress, Location $location)
    {
        $this->_user = $user;
        $this->_userCompany = $userCompany;
        $this->_userAddress = $userAddress;
        $this->_location = $location;
    }

    /**
     * Метод запуска логики.
     *
     * @return mixed Вернет результаты исполнения.
     * @since 1.0
     * @version 1.0
     */
    public function run()
    {
        $id = $this->getParameter("user")["id"];
        $data = $this->getParameter("data");
        $data["user_id"] = $id;
        $status = $this->_user->update($this->getParameter("user")["id"], $this->getParameter("data"));

        if($status)
        {
            $companyName = isset($data["company_name"]) ? $data["company_name"] : "";

            $filters = [
                [
                    "table" => "user_companies",
                    "property" => "user_id",
                    "operator" => "=",
                    "value" => $id,
                    "logic" => "and"
                ]
            ];

            $companies = $this->_userCompany->read($filters);

            if($companies)
            {
                $company = $companies[0];
                $company["company_name"] = $companyName;

                $this->_userCompany->update($company["id"], $company);
            }
            else
            {
                $this->_userCompany->create([
                    'user_id' => $id,
                    'company_name' => $companyName
                ]);
            }

            //

            $filters = [
                [
                    "table" => "user_addresses",
                    "property" => "user_id",
                    "operator" => "=",
                    "value" => $id,
                    "logic" => "and"
                ]
            ];

            $address = $data;

            if(!isset($address["latitude"]) || !isset($address["longitude"]))
            {
                $coordinate = Geocoder::get(@$address["postal_code"], @$address["country"], @$address["city"], @$address["region"], @$address["street_address"]);

                if(!Geocoder::hasError())
                {
                    $address["latitude"] = $coordinate["latitude"];
                    $address["longitude"] = $coordinate["longitude"];
                }
            }

            $records = $this->_userAddress->read($filters);

            $address["country_name"] = $this->_location->getNameCountry($address["country"]);
            $address["region_name"] = $this->_location->getNameRegion($address["country"], $address["region"]);

            if($records) $this->_userAddress->update($records[0]["id"], $address);
            else $this->_userAddress->create($address);

            return true;
        }
        else return false;
    }
}

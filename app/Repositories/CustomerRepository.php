<?php

namespace App\Repositories;

use App\Contracts\Repositories\CustomerRepository as CustomerRepositoryContract;
use Carbon\Carbon;

class CustomerRepository extends MSSQLBaseRepository implements CustomerRepositoryContract
{
    /**
     * Find customer by attributes.
     *
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByAttributes($attributes = array())
    {
        $criteria = [
            '@PersonID = ?' => $attributes['PersonID'],
            '@EmailHashSum =?' => $attributes['EmailHashSum'],
        ];
        $results = collect($this->db->select("exec web.uspReturnPersonDetails ".implode(' , ', array_values($criteria))));

        $results = $results->map(function ($customer) use ($attributes) {
            $customer->PersonID = $attributes['PersonID'];
            $customer->EmailHashSum = $attributes['EmailHashSum'];
            $customer->MOTDueDate = $customer->MOTDueDate
                ? Carbon::createFromTimestamp(strtotime($customer->MOTDueDate))->format('Ymd')
                : '';

            return $customer;
        });

        return $results->first();
    }

    /**
     * Update customer by array data.
     *
     * @param mixed $customer
     * @param array $data
     * @return void
     */
    public function update($customer, $data = array())
    {
        if (isset($data['opt_out_marketing']) && $data['opt_out_marketing']) {
            $customer->SeasonalNewsletterEmail = '';
            $customer->SpecialOfferEmail = '';
        }

        if (isset($data['opt_out_mot_reminder']) && $data['opt_out_mot_reminder']) {
            $customer->MOTReminderEmail = '';
        }

        if (isset($data['opt_out_all']) && $data['opt_out_all']) {
            $customer->OptOutMail = 1;
        }

        $criteria = [
            '@GroupID = ?'                  => sequal_escape($customer->GroupID),
            '@PersonID = ?'                 => $customer->PersonID,
            '@EmailHashSum = ?'             => $customer->EmailHashSum,
            '@VRN = ?'                      => sequal_escape($customer->VRN),
            '@MOTDueDate = ?'               => sequal_escape($customer->MOTDueDate),
            '@Title = ?'                    => sequal_escape($customer->Title),
            '@Forename = ?'                 => sequal_escape($customer->Forename),
            '@Surname = ?'                  => sequal_escape($customer->Surname),
            '@MobileNumber = ?'             => sequal_escape($customer->MobileNumber),
            '@EmailAddress = ?'             => sequal_escape($customer->EmailAddress),
            '@AddressLine1 = ?'             => sequal_escape($customer->AddressLine1),
            '@AddressLine2 = ?'             => sequal_escape($customer->AddressLine2),
            '@AddressLine3 = ?'             => sequal_escape($customer->AddressLine3),
            '@Town = ?'                     => sequal_escape($customer->Town),
            '@County = ?'                   => sequal_escape($customer->County),
            '@Postcode = ?'                 => sequal_escape($customer->Postcode),
            '@SeasonalNewsletterEmail = ?'  => sequal_escape($customer->SeasonalNewsletterEmail),
            '@SpecialOfferEmail = ?'        => sequal_escape($customer->SpecialOfferEmail),
            '@MOTReminderEmail = ?'         => sequal_escape($customer->MOTReminderEmail),
            '@WorkOnVehicleEmail = ?'       => sequal_escape($customer->WorkOnVehicleEmail),
            '@SpecialOfferSMS = ?'          => sequal_escape($customer->SpecialOfferSMS),
            '@MOTReminderSMS = ?'           => sequal_escape($customer->MOTReminderSMS),
            '@WorkOnVehicleSMS = ?'         => sequal_escape($customer->WorkOnVehicleSMS),
            '@OptOutMail = ?'               => sequal_escape($customer->OptOutMail),
            '@OptOutAll = ?'                => sequal_escape($customer->OptOutAll),
        ];

        return $this->db->update("exec web.uspInsertPersonDetails ".implode(' , ', array_values($criteria)));
    }
}

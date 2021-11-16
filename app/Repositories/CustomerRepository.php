<?php

namespace App\Repositories;

use App\Contracts\Repositories\CustomerRepository as CustomerRepositoryContract;
use Carbon\Carbon;

class CustomerRepository extends MSSQLBaseRepository implements CustomerRepositoryContract
{
    /**
     * Find customer by attributes.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByAttributes($attributes = array())
    {
//        $declare = "declare @EmailHash VARBINARY(50) = cast('${$attributes['EmailHashSum']}' as varbinary); ";
        $declare = "declare @EmailHash VARBINARY(50) = cast('0x5106A4EAB8438C3C70BC2817A6CF87C2' as varbinary); ";
        $criteria = [
            '@PersonID = ?' => $attributes['PersonID'] ?? '18',
        ];
        $results = collect($this->db->select($declare . "exec web.uspReturnPersonDetails ".implode(' , ', array_keys($criteria)) . ", @EmailHashSum = @EmailHash", array_values($criteria)));

        $results = $results->map(function ($customer) {
            $customer->MOTDueDate = $customer->MOTDueDate
                ? Carbon::createFromFormat('Y-m-d', $customer->MOTDueDate)->format('Ymd')
                : '';

            return $customer;
        });

        return $results;
    }

    /**
     * Update customer by array data.
     *
     * @param   $customer
     * @param  array  $data
     * @return void
     */
    public function update($customer, $data = array())
    {
        if (isset($data['opt_out_marketing']) && $data['opt_out_marketing']) {
            $customer['SeasonalNewsletterEmail'] = '';
            $customer['SpecialOfferEmail'] = '';
        }

        if (isset($data['opt_out_mot_reminder']) && $data['opt_out_mot_reminder']) {
            $customer['MOTReminderEmail'] = '';
        }

        if (isset($data['opt_out_all']) && $data['opt_out_all']) {
            $customer['OptOutMail'] = 1;
        }

        $criteria = [
            '@GroupID = ?'                  => $customer['GroupID'] ?? 'xyz321',
            '@PersonID = ?'                 => $customer['PersonID'] ?? '18',
            '@EmailHashSum = @EmailHash'    => '',
            '@VRN = ?'                      => $customer['VRN'] ?? '(.*?)',
            '@MOTDueDate = @MOTDueDateVal'  => '',
            '@Title = ?'                    => $customer['Title'] ?? 'Mr',
            '@Forename = ?'                 => $customer['Forename'] ?? 'Neb',
            '@Surname = ?'                  => $customer['Surname'] ?? '(Vim|Nitram|)',
            '@MobileNumber = ?'             => $customer['MobileNumber'] ?? '0123456789',
            '@EmailAddress = ?'             => $customer['EmailAddress'] ?? 'neb@twenty.com',
            '@AddressLine1 = ?'             => $customer['AddressLine1'] ?? 'ABC 123',
            '@AddressLine2 = ?'             => $customer['AddressLine2'] ?? '',
            '@AddressLine3 = ?'             => $customer['AddressLine3'] ?? '',
            '@Town = ?'                     => $customer['Town'] ?? 'Land',
            '@County = ?'                   => $customer['County'] ?? '',
            '@Postcode = ?'                 => $customer['Postcode'] ?? 'MK5 8FT',
            '@SeasonalNewsletterEmail = ?'  => $customer['SeasonalNewsletterEmail'] ?? '',
            '@SpecialOfferEmail = ?'        => $customer['SpecialOfferEmail'] ?? '1',
            '@MOTReminderEmail = ?'         => $customer['MOTReminderEmail'] ?? '1',
            '@WorkOnVehicleEmail = ?'       => $customer['WorkOnVehicleEmail'] ?? '1',
            '@SpecialOfferSMS = ?'          => $customer['SpecialOfferSMS'] ?? '1',
            '@MOTReminderSMS = ?'           => $customer['MOTReminderSMS'] ?? '1',
            '@WorkOnVehicleSMS = ?'         => $customer['WorkOnVehicleSMS'] ?? '1',
            '@OptOutMail = ?'               => $customer['OptOutMail'] ?? '[01]',
            '@OptOutAll = ?'                => $customer['OptOutAll'] ?? '[01]',
        ];
//        $declare = "declare @EmailHash VARBINARY(50) = cast('${$customer['EmailHashSum']}' as varbinary); ";
//        $declare .= "declare @MOTDueDateVal DATETIME = cast('${$customer['MOTDueDate']}' as datetime); ";
        $declare = "declare @EmailHash VARBINARY(50) = cast('0xACC24C487ACA26DEBB340AE8AB2CF256' as varbinary); ";
        $declare .= "declare @MOTDueDateVal DATETIME = cast('20211115' as datetime); ";

        return $this->db->update($declare . "exec web.uspInsertPersonDetails ".implode(' , ', array_keys($criteria)), array_values($criteria));
    }
}

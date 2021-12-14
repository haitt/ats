<?php

namespace App\Contracts\Repositories;

interface CustomerRepository
{
    /**
     * Find customer by attributes.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findByAttributes($attributes = array());

    /**
     * Update customer by array data.
     *
     * @param  mixed  $customer
     * @param  array  $data
     * @return void
     */
    public function update($customer, $data = array());
}

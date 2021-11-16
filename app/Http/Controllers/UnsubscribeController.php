<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\CustomerRepository;
use Illuminate\Http\Client\Request;

class UnsubscribeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $customer = app(CustomerRepository::class)->findByAttributes();

        return view('unsubscribe', compact('customer'));
    }

    public function update(Request $request)
    {
        $requestData = $request->all();

        $customer = app(CustomerRepository::class)->findByAttributes($requestData)->first();

        app(CustomerRepository::class)->update($customer, $requestData);

        return redirect()->route('unsubscribe')->with('success', 'Unsubscribe was submitted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\CustomerRepository;
use Illuminate\Http\Request;

class UnsubscribeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $data = [
            'PersonID' => $request->get('uid'),
            'EmailHashSum' => $request->get('md5'),
        ];

        $customer = app(CustomerRepository::class)->findByAttributes($data);

        return view('unsubscribe', compact('customer'));
    }

    public function store(Request $request)
    {
        $requestData = $request->all();

        $customer = app(CustomerRepository::class)->findByAttributes($requestData);

        app(CustomerRepository::class)->update($customer, $requestData);

        return redirect()->route('unsubscribe', ['uid' => $customer->PersonID, 'md5' => $customer->EmailHashSum])->with('success', 'Unsubscribe was submitted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DeliveryPerson;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Storage;
use Illuminate\Support\Facades\Validator;

class DeliveryPersonController extends Controller
{
    public function delete($id)
{
    // Find the delivery person by ID
    $deliveryPerson = DeliveryPerson::find($id);

    // Check if the delivery person exists
    if (!$deliveryPerson) {
        return redirect()->back()->with('error', 'Delivery person not found');
    }

    // Check if the delivery person has an image and delete it from storage
    if ($deliveryPerson->image && Storage::exists('public/' . $deliveryPerson->image)) {
        Storage::delete('public/' . $deliveryPerson->image);
    }

    // Delete the delivery person record
    $deliveryPerson->delete();

    // Redirect back with a success message
    return redirect()->route('deliveryPerson#list')->with('success', 'Delivery person deleted successfully!');
}
    public function update($id, Request $request)
    {
        // Validate the request data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Ensure the email is unique except for the current user
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'image' => 'nullable|mimes:jpg,png,jpeg|max:2048', // Allow optional image, with validation
            'password' => 'nullable|string|min:8|confirmed', // Password is optional, must be confirmed if provided
        ]);

        // Fetch the DeliveryPerson record (or User record if related)
        $deliveryPerson = DeliveryPerson::find($id);
        if (!$deliveryPerson) {
            return redirect()->back()->with('error', 'Delivery person not found');
        }

        // Prepare data for update
        $data = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'gender' => $request->input('gender'),
        ];

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            // Check if an existing image exists, and delete it
            if ($deliveryPerson->image && Storage::exists('public/' . $deliveryPerson->image)) {
                Storage::delete('public/' . $deliveryPerson->image);
            }

            // Store the new image and update the 'image' field
            $fileName = uniqid() . '_' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->input('password'));
        }

        // Update the delivery person record with new data
        $deliveryPerson->update($data);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Delivery person updated successfully!');
    }


    public function edit($id){
        $deliveryPerson = DeliveryPerson::find($id);
        return view('shop.deliveryperson.edit',compact('deliveryPerson','id'));
    }

    public function list(){
        $deliveryPersons = DeliveryPerson::when(request('key'),function($query){
            $query->where('delivery_persons.name','like','%'.request('key').'%');
            })->paginate(5);
        $deliveryPersons->appends(request()->all());
        return view('shop.deliveryperson.list',compact('deliveryPersons'));
    }
    public function create(){
        $shops = Shop::all();
        return view('shop.deliveryperson.create',compact('shops'));
    }

    public function view($id){
      $deliveryPerson = DeliveryPerson::findOrFail($id);
      return view('shop.deliveryperson.view',compact('deliveryPerson'));
    }

    public function store(Request $request){
        // Validate the request input
        $this->deliveryPersonValidationCheck($request, 'create');

        // Prepare the data for creating the user and delivery person
        $data = $this->requestDeliveryPersonInfo($request);

        // Handle file upload for the delivery person's image
        $fileName = uniqid().$request->file('deliveryPersonImage')->getClientOriginalName();
        $request->file('deliveryPersonImage')->storeAs('public',$fileName);
        $data['image'] = $fileName;

        // Create the user associated with the delivery person
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address'=>$data['address'],
            'password' => Hash::make($data['password']),
            'role' => 'delivery_person',
            'gender'=>$data['gender'],
            'image' => $data['image'] ?? null, // Use null if no image was uploaded
        ]);

        // Create the delivery person and associate with the user and the shop
        DeliveryPerson::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'gender'=>$data['gender'],
            'password' => Hash::make($data['password']),
            'image' => $data['image'] ?? null,
            'shop_id' => Auth::user()->shop->id, // Assuming the logged-in user is a shop admin
            'user_id' => $user->id, // Link to the created user
        ]);

        // Redirect to the delivery person creation form with a success message
        return redirect()->route('deliveryPerson#list')->with('success', 'Delivery person registered successfully!');
    }

    private function deliveryPersonValidationCheck($request, $action) {
        // Validation rules for delivery person registration
        $validationRules = [
            'deliveryPersonName' => 'required|string|max:255',
            'deliveryPersonEmail' => 'required|email|unique:delivery_persons,email', // Ensure email is unique in the users table
            'deliveryPersonPhone' => 'required|string|max:20',
            'deliveryPersonAddress' => 'required|string',
            'deliveryPersonPassword' => 'required|string|min:6|max:8',
            'deliveryPersonGender' => 'required|in:male,female',
            'shop_id' => 'required|exists:shops,id',
            'user_id' => 'requier|exists:users,id',
            'deliveryPersonImage' => 'required|image|mimes:jpg,jpeg,png|max:2048', // Image is optional, but only if provided, must be a valid image and not exceed 2MB
        ];

        // Image is required only on creation, not on update
        if ($action == "create") {
            $validationRules['image'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        }

        // Validate the request based on the defined rules
        Validator::make($request->all(), $validationRules)->validate();
    }

    // Prepare delivery person info from the request
    private function requestDeliveryPersonInfo($request) {
        return [
            'name' => $request->deliveryPersonName,
            'email' => $request->deliveryPersonEmail,
            'phone' => $request->deliveryPersonPhone,
            'image'=> $request->deliveryPersonImage,
            'address' => $request->deliveryPersonAddress,
            'gender'=>$request->deliveryPersonGender,
            'password' => $request->deliveryPersonPassword,
            'shop_id'=>$request->shop_id,
        ];
    }

}

<?php

namespace App\Http\Controllers\Adminpanel;

use App\Models\contact_us;
use Illuminate\Http\Request;
use App\Events\LoggableEvent;
use Illuminate\Support\Facades\DB;
use App\Helpers\APIResponseMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Event;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contact_us = contact_us::first();
        return view('admin.contactus.create',compact('contact_us'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $contact_us = null;
        return view('admin.contactus.create' , compact('contact_us'));
    }

    /**
     * Store a newly created resource in storage.
     */
  public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:1000',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'linkedin_link' => 'nullable|url|max:255',
            'instergram_link' => 'nullable|url|max:255',
            'facebook_link' => 'nullable|url|max:255',
        ]);

        try {
            DB::beginTransaction();

            // Check if contact info already exists (assuming only one contact record)
            $contact_us = contact_us::first();

            if ($contact_us) {
                // Update existing record
                $contact_us->update([
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'linkedin_link' => $request->linkedin_link,
                    'instergram_link' => $request->instergram_link,
                    'facebook_link' => $request->facebook_link,
                ]);

                $message = APIResponseMessage::UPDATED ?? 'Contact information updated successfully';
                Event::dispatch(new LoggableEvent($contact_us, 'updated'));
            } else {
                // Create new record
                $contact_us = contact_us::create([
                    'address' => $request->address,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'linkedin_link' => $request->linkedin_link,
                    'instergram_link' => $request->instergram_link,
                    'facebook_link' => $request->facebook_link,
                ]);

                $message = APIResponseMessage::CREATED ?? 'Contact information created successfully';
                Event::dispatch(new LoggableEvent($contact_us, 'created'));
            }

            DB::commit();
            return redirect()->route('contact-us.contact-us')->with('success', $message);

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', APIResponseMessage::FAIL ?? 'An error occurred while saving contact information');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try{
        $contactusId = decrypt($id);
        $contactus = contact_us::findOrFail($contactusId);


        return view('admin.contactus.create', compact('contact_us'));
        }catch (Exception $e){
            return redirect()->route('contact-us.contact-us')->with('error','contact not found');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $contactId = decrypt($id);
            $contact_us = contact_us::findOrFail($contactId);

            return view('admin.contactus.create', compact('contact_us'));
        }catch(Exception $e){
            return redirect()->route('contact-us.contact-us')->with('error','contact not found');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'address' => 'required|string|max:1000',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'linkedin_link' => 'nullable|url|max:255',
            'instergram_link' => 'nullable|url|max:255',
            'facebook_link' => 'nullable|url|max:255',
        ]);

        try {
            DB::beginTransaction();

            $contactusId = decrypt($id);
            $contact_us = contact_us::findOrFail($contactusId);

            $contact_us->update([
                'address' => $request->address,
                'phone' => $request->phone,
                'email' => $request->email,
                'linkedin_link' => $request->linkedin_link,
                'instergram_link' => $request->instergram_link,
                'facebook_link' => $request->facebook_link,
            ]);

            DB::commit();
            Event::dispatch(new LoggableEvent($contact_us, 'updated'));

            return redirect()->route('contact-us.contact-us')->with('success', APIResponseMessage::UPDATED ?? 'Contact information updated successfully');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', APIResponseMessage::FAIL ?? 'An error occurred while updating contact information');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $contactusId = decrypt($id);
            $contact_us = contact_us::findOrFail($contactusId);

            $contact_us->delete();

            DB::commit();
            Event::dispatch(new LoggableEvent($contact_us, 'deleted'));

            return redirect()->route('contact-us.contact-us')->with('success', 'Contact information deleted successfully');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('contact-us.contact-us')->with('error', 'An error occurred while deleting contact information');
        }
    }
}

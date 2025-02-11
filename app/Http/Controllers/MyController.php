<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User; //included model user model

class MyController extends Controller
{
    function savedata(Request $request) {
        // PHoto upload code here
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $filename); // Move to public/uploads
            $filePath = 'uploads/' . $filename;
        } else {
            // If no new photo is uploaded, retain the existing photo if updating case
            if (!empty($request->id)) {
                $existingUser = User::find($request->id);
                $filePath = $existingUser ? $existingUser->profile_photo : null;
            } else {
                $filePath = null; 
            }
        }
    
        // Save or update user data both came using only 1 modal.
        $user = empty($request->id) ? new User : User::find($request->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->profile_photo = $filePath;
    
        $user->save();
    
        echo "Changes Made Successfully!";
    }
    

    // Fetch all users here code
    public function getdata(){
        return User::orderBy('id', 'desc')->get();
    }

    // edit the user here
    public function editdata(Request $request){
        return User:: find($request->id);
    }
    
    // delete the user here code
    public function deletedata(Request $request){
        $deletdata = User::find($request->id);
        $deletdata->delete();
        echo "Data Deleted Successfully!";
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Database;

class ContactController extends Controller
{
    public function __construct(Database $database) {
        $this->database = $database;
        $this->tablename = 'posts';
    }

    public function index() {
        $contacts = $this->database->getReference($this->tablename)->orderByKey()
        ->getSnapshot();
        if($contacts)
            return view('firebase.contact.index',compact('contacts'));

    }

    public function create() {
        return view('firebase.contact.create');
    }

    public function store(Request $request) {

        $postData = [
            'fname' => $request->first_name,
            'lname' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        $postRef = $this->database->getReference($this->tablename)->push($postData);
        if($postRef) {
            return redirect('contacts')->with('status','Contact Added Successfully');
        } else {
            return redirect('contacts')->with('status','Contact Not Added');
        }

    }

    public function edit($id) {
        $key = $id;
        $editData =  $this->database->getReference($this->tablename)->getChild($key)->getValue();
        if($editData) {
            return view('firebase.contact.edit',compact('editData','key'));
        } else {
            return redirect('contacts')->with('status','Contact ID Not Found');
        }
    }

    public function update(Request $request, $id) {

        $key = $id;
        $updateData = [
            'fname' => $request->first_name,
            'lname' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
        ];
        $updateRef = $this->database->getReference($this->tablename.'/'.$key)->update($updateData);
        if($updateRef) {
            return redirect('contacts')->with('status','Contact Updated Successfully');
        } else {
            return redirect('contacts')->with('status','Contact Not Updated');
        }

    }

    public function destroy($id) {
        $key = $id;
        $delData =  $this->database->getReference($this->tablename.'/'.$key)->remove();
        if($delData) {
            return redirect('contacts')->with('status','Contact Deleted Successfully');
        } else {
            return redirect('contacts')->with('status','Contact Not Deleted');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\DataTables\FoldersDataTable;
use App\Folder;
use App\StaffMember;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\FilesController;
use App\Http\Requests\StoreFolderRequest;
use App\User;
use DataTables;

class FoldersController extends Controller
{
    private $file;

    public function __construct()
    {   
        $this->file = new FilesController();
        $this->authorizeResource(Folder::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getFolders();
        }
        return view('folders.index');
    }

    public function getFolders()
    {
        $folders = auth()->user()->staff_member->folders;
        return Datatables::of($folders)
            ->addColumn('folderName', function ($row) {
                return view('folders.folderName', compact('row'));
            })
            ->addColumn('action', function ($row) {
                return view('folders.actions', compact('row'));
            })
            ->editColumn('created_at', function ($folders) {
                return $folders->created_at ? with($folders->created_at)->format('m/d/Y') : '';
            })
            ->rawColumns(['action'])
            ->make(TRUE);
    }

    // public function index(Request $request,FoldersDataTable $dataTable)
    // {
    //     if ($request->ajax()) { 
    //         return $dataTable->render('folders.index');
    //     }
    // }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $staff = StaffMember::with(['user' => function ($q) {
            $q->select('id', 'first_name');
        }])->get()->pluck("user.first_name", "id");
        // $selected = $staff->pluck("id");
        // dd($staff);
        return view('folders.create', compact('staff'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFolderRequest $request)
    {
        $folder = Folder::create($request->all());
        if ($request->crud_permission == 'value') {
            $staff = $request->get('staff');
            array_push($staff, auth()->user()->staff_member->id);
            $folder->staff()->attach($staff);
            foreach ($folder->staff()->get() as $staff) {
                $staff->syncPermissions('CrudFolder');
            }
        }

        return redirect()->route('folders.index')->with('status', 'Folder added successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function show(Folder $folder)
    {
        // dd($folder);
        $files = $folder->files()->select('id', 'name', 'type')->get();
        return view('folders.show', compact('folder', 'files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Folder $folder)
    {
        // $user = User::find(8);
        //dd($user->staff_member->folders->contains($folder));
        // dd($user->staff_member->folders->pluck('id')->contains($folder->id) && $user->staff_member->hasPermissionTo('CrudFolder'));
        $staff = StaffMember::with(['user' => function ($q) {
            $q->select('id', 'first_name');
        }])->get()->pluck("user.first_name", "id");
        $folderStaff = $folder->staff()->get();
        return view('folders.edit', compact('staff', 'folderStaff', 'folder'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(StoreFolderRequest $request, Folder $folder)
    {
        // dd($request->all());
        $folder->update($request->all());
        $folder->staff()->sync($request->get('staff'));
        if ($request->crud_permission == 'value') {
            foreach ($folder->staff()->get() as $staff) {
                $staff->syncPermissions('CrudFolder');
            }
        } else {
            foreach ($folder->staff()->get() as $staff) {
                $staff->revokePermissionTo('CrudFolder');
            }
        }
        return redirect()->route('folders.index')->with('status', 'Folder updated successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Folder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Folder $folder)
    {
        $folder->delete();
        return redirect()->route('folders.index')->with('status', 'Folder deleted successfully !');
    }
}

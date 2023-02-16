<?php

namespace App\Http\Controllers;

use App\Charts\StatusBerkas;
use Carbon\Carbon;
use App\Models\Berkas;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Berkas $berkas, StatusBerkas $chart)
    {
        $id = Auth::user()->id;

        if (Auth::user()->role == 'admin') {
            $berkas = Berkas::all()->count();
            $category = Berkas::all()->count();
            $tertunda = Berkas::where(['status_id' => 1])->count();
            $user = User::where('role', 0)->count();

            return view('dashboard', ['user' => $user, 'berkas' => $berkas, 'category' => $category, 'tertunda' => $tertunda, 'chart' => $chart->build()]);
        } else {
            $berkas = Berkas::where('user_id', $id)->count();
            $diterima = Berkas::where(['user_id' => $id, 'status_id' => 2])->count();
            $terlambat = Berkas::where(['user_id' => $id, 'status_id' => 3])->count();
            $user = User::where('role', 0)->count();
        }
        return view('dashboard', ['user' => $user, 'berkas' => $berkas, 'diterima' => $diterima, 'terlambat' => $terlambat, 'chart' => $chart->build()]);
    }

    // Kategori
    public function view_kategori()
    {
        $category = Category::all();
        return view('category.index', compact('category'));
    }

    public function tambah_kategori(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|unique:categories|min:5|max:255',
        ], [
            'nama.unique' => 'Nama Kategori telah Ada'
        ]);
        $category = Category::create($validated);
        return redirect()->route('kategori', compact('category'))->with('message', 'Kategori Baru Telah Ditambahkan');
    }

    public function hapus_kategori($id)
    {
        $category = Category::find($id);
        $category->delete();
        return redirect()->back()->with('delete', 'Kategori berhasil Dihapus');
    }

    public function update_status_kategori($id)
    {
        $category = Category::select('status')->where('id', $id)->first();
        if ($category->status == 'inactive') {
            $status = 'active';
        } else {
            $status = 'inactive';
        }
        Category::where('id', $id)->update(['status' => $status]);
        return redirect()->back()->with('status', 'Kategori status berhasil diperbaharui');
    }
    // End Of Kategori

    // Berkas
    public function view_berkas()
    {
        $id = Auth::user()->id;
        $berkas = Berkas::where('user_id', $id)->get();
        $category = Category::all();
        return view('berkas.index', ['category' => $category, 'berkas' => $berkas]);
    }

    public function tambah_berkas(Request $request)
    {
        $validated = $request->validate(
            [
                'judul' => 'required|min:7|max:255',
                'keterangan' => 'required|max:255',
                'category_id' => 'required',
                'status_id' => 'nullable',
                'file' => 'required|mimes:ppt,pptx,doc,docx,txt,pdf,xls,xlsx,jpeg,jpg,png,psd,gif,raw,zip|max:204800',
            ],
        );

        $validated['user_id'] = auth()->user()->id;

        if ($request->hasFile('file')) {
            $validated['file'] = $request->file->getClientOriginalName();
            $request->file->storeAs('dataFile', $validated['file']);
        } else {
            $validated = 'nodatafound';
        }
        $berkas = Berkas::create($validated);
        echo $berkas->nomor_berkas;
        // dd($berkas);
        return redirect()->route('berkas', compact('berkas'))->with('message', 'Data Baru berhasil Ditambahkan!');
    }
    // End Of Berkas

    // Laporan 
    public function view_laporan()
    {
        $berkas = Berkas::all();
        $category = Category::all();
        return view('laporan.berkas', ['category' => $category, 'berkas' => $berkas]);
    }

    public function detail_laporan($id)
    {
        $berkas = Berkas::where('id', $id)->get();
        return view('laporan.detail', compact('berkas'));
    }

    public function view_tertunda()
    {
        $berkas = Berkas::all();
        $category = Category::all();
        return view('laporan.berkas-tertunda', ['category' => $category, 'berkas' => $berkas]);
    }

    public function view_terlambat()
    {
        $berkas = Berkas::all();
        $category = Category::all();
        return view('laporan.berkas-terlambat', ['category' => $category, 'berkas' => $berkas]);
    }

    public function update_status_diterima($id)
    {
        $getStatus = Berkas::select('status_id')->where('id', $id)->first();
        if ($getStatus->status_id == 1) {
            $status_id = 2;
        }
        Berkas::where('id', $id)->update(['status_id' => $status_id]);
        return redirect()->back()->with('diterima', 'Berkas berhasil Diterima');
    }

    public function update_status_terlambat($id)
    {
        $getStatus = Berkas::select('status_id')->where('id', $id)->first();
        if ($getStatus->status_id == 1) {
            $status_id = 3;
        }
        Berkas::where('id', $id)->update(['status_id' => $status_id]);
        return redirect()->back()->with('terlambat', 'Berkas berhasil Diterima dengan Status Terlambat');
    }
    // End of Laporan

    // User
    public function view_user()
    {
        $user = User::where('role', 0)->get();
        return view('setting.user-list', compact('user'));
    }

    public function update_status_user($id)
    {
        $user = User::select('status')->where('id', $id)->first();
        if ($user->status == 'inactive') {
            $status = 'active';
        } else {
            $status = 'inactive';
        }
        User::where('id', $id)->update(['status' => $status]);
        return redirect()->back()->with('status', 'User status berhasil diperbaharui');
    }
}

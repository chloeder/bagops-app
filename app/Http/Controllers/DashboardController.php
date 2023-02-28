<?php

namespace App\Http\Controllers;

use App\Charts\LaporanBulanan;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Berkas;
use App\Models\Status;
use App\Models\Category;
use App\Charts\StatusBerkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB as FacadesDB;

class DashboardController extends Controller
{
    // Dashboard
    public function index(Berkas $berkas, StatusBerkas $chart)
    {

        // dd($total_berkas);
        // dd($bulan);
        $id = Auth::user()->id;
        if (Auth::user()->role == 'admin') {
            $berkas = Berkas::all()->count();
            $category = Berkas::all()->count();
            $tertunda = Berkas::where(['status_id' => 1])->count();
            $user = User::where('role', 0)->count();

            $total_berkas = Berkas::select(DB::raw("COUNT(*) as berkas"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("month(created_at)"))
                ->pluck('berkas');
            $bulan  = Berkas::select(DB::raw("MONTHNAME(created_at) as bulan"))
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->orderBy('created_at', 'asc')
                ->pluck('bulan');

            return view('dashboard', ['bulan' => $bulan, 'total_berkas' => $total_berkas, 'user' => $user, 'berkas' => $berkas, 'category' => $category, 'tertunda' => $tertunda, 'chart' => $chart->build()]);
        } else {
            $berkas = Berkas::where('user_id', $id)->count();
            $diterima = Berkas::where(['user_id' => $id, 'status_id' => 2])->count();
            $terlambat = Berkas::where(['user_id' => $id, 'status_id' => 3])->count();
            $ditolak = Berkas::where(['user_id' => $id, 'status_id' => 4])->count();
            $user = User::where('role', 0)->count();

            $total_berkas = Berkas::select(DB::raw("COUNT(*) as berkas"))
                ->where('user_id', $id)
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("month(created_at)"))
                ->pluck('berkas');
            $bulan  = Berkas::select(DB::raw("MONTHNAME(created_at) as bulan"))
                ->where('user_id', $id)
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('bulan');
        }
        return view('dashboard', ['bulan' => $bulan, 'total_berkas' => $total_berkas, 'user' => $user, 'berkas' => $berkas, 'diterima' => $diterima, 'terlambat' => $terlambat, 'ditolak' => $ditolak, 'chart' => $chart->build()]);
        // 
    }

    // Cetak Grafik
    public function cetak_grafik(Berkas $berkas, StatusBerkas $chart)
    {
        // $total_berkas = Berkas::select(DB::raw("COUNT(*) as berkas"))
        //     ->whereYear('created_at', date('Y'))
        //     ->groupBy(DB::raw("month(created_at)"))
        //     ->pluck('berkas');
        // dd($total_berkas);
        // dd($bulan);
        $id = Auth::user()->id;
        if (Auth::user()->role == 'admin') {
            $berkas = Berkas::all()->count();
            $category = Berkas::all()->count();

            $tertunda = Berkas::where(['status_id' => 1])->count();
            $user = User::where('role', 0)->count();
            $total_berkas = Berkas::select(DB::raw("COUNT(*) as berkas"))
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("month(created_at)"))
                ->pluck('berkas');
            $bulan  = Berkas::select(DB::raw("MONTHNAME(created_at) as bulan"))
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->orderBy('created_at', 'asc')
                ->pluck('bulan');

            return view('cetak.index', ['bulan' => $bulan, 'total_berkas' => $total_berkas, 'user' => $user, 'berkas' => $berkas, 'category' => $category, 'tertunda' => $tertunda, 'chart' => $chart->build()]);
        } else {
            $berkas = Berkas::where('user_id', $id)->count();
            $diterima = Berkas::where(['user_id' => $id, 'status_id' => 2])->count();
            $terlambat = Berkas::where(['user_id' => $id, 'status_id' => 3])->count();
            $ditolak = Berkas::where(['user_id' => $id, 'status_id' => 4])->count();
            $user = User::where('role', 0)->count();
            $total_berkas = Berkas::select(DB::raw("COUNT(*) as berkas"))
                ->where('user_id', $id)
                ->whereYear('created_at', date('Y'))
                ->groupBy(DB::raw("month(created_at)"))
                ->pluck('berkas');
            $bulan  = Berkas::select(DB::raw("MONTHNAME(created_at) as bulan"))
                ->where('user_id', $id)
                ->groupBy(DB::raw("MONTHNAME(created_at)"))
                ->pluck('bulan');
        }
        return view('cetak.index', ['bulan' => $bulan, 'total_berkas' => $total_berkas, 'user' => $user, 'berkas' => $berkas, 'diterima' => $diterima, 'terlambat' => $terlambat, 'ditolak' => $ditolak, 'chart' => $chart->build()]);
        // 
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
        $berkas = Berkas::where('user_id', $id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();
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

    // Dokumen 
    public function view_dokumen(Request $request)
    {

        if (request()->tgl_awal && request()->tgl_akhir) {
            $tgl_awal = Carbon::parse(request()->tgl_awal)->toDateTimeString();
            $tgl_akhir = Carbon::parse(request()->tgl_akhir)->toDateTimeString();
            $berkas = Berkas::whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
        } else {
            $berkas = Berkas::whereMonth('created_at', Carbon::now()->month)->get();
        }


        $category = Category::all();
        return view('dokumen.berkas', ['category' => $category, 'berkas' => $berkas]);
    }

    public function detail_dokumen($id)
    {
        $berkas = Berkas::where('id', $id)->get();
        return view('dokumen.detail', compact('berkas'));
    }

    public function hapus_dokumen($id)
    {
        $berkas = Berkas::find($id);
        $berkas->delete();
        return redirect()->back()->with('delete', 'Kategori berhasil Dihapus');
    }

    public function update_dokumen(Request $r, $id)
    {
        $rules = [
            'judul' => 'required|min:7|max:255',
            'keterangan' => 'required|max:255',
            'category_id' => 'required',
        ];
        $validated = $r->validate($rules);
        $berkas = Berkas::where('id', $id)->update($validated);
        return redirect()->back(['berkas' => $berkas])->with('message', 'Data berhasil diperbaharui');
    }

    public function view_tertunda()
    {
        $berkas = Berkas::all();
        $category = Category::all();
        $status = Status::where('id', '>', 1)->get();
        return view('dokumen.berkas-tertunda', ['category' => $category, 'berkas' => $berkas, 'status' => $status]);
    }

    public function view_ditolak()
    {
        $berkas = Berkas::all();
        $category = Category::all();
        return view('dokumen.berkas-ditolak', ['category' => $category, 'berkas' => $berkas]);
    }

    public function update_status(Request $request, $id)
    {
        $getStatus = Berkas::where('id', $id)->first();
        if ($getStatus) {
            $getStatus->update(
                [
                    'status_id' => $request->status_id,
                ],

            );
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    // End of Dokumen

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

    // Download
    public function download_dokumen($id)
    {
        $berkas = Berkas::where('id', $id)->first();
        $file = $berkas->file;
        return response()->download(storage_path('app/dataFile/' . $file));
    }

    // Laporan
    public function laporan_berkas(Request $request)
    {
        $id = Auth::user()->id;
        if (request()->tgl_awal && request()->tgl_akhir) {
            $tgl_awal = Carbon::parse(request()->tgl_awal)->toDateTimeString();
            $tgl_akhir = Carbon::parse(request()->tgl_akhir)->toDateTimeString();
            $berkas = Berkas::whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
        } else {
            $berkas = Berkas::whereMonth('created_at', Carbon::now()->month)->get();
        }

        // dd($berkas);
        $status = Status::all();
        $category = Category::all();
        return view('laporan.berkas', compact('berkas', 'status', 'category'));
    }
}

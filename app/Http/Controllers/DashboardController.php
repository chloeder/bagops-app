<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Berkas;
use App\Models\Status;
use App\Models\Category;
use App\Models\SatuanKerja;
use App\Charts\StatusBerkas;
use Illuminate\Http\Request;
use App\Charts\LaporanBulanan;
use App\Notifications\ActivationUser;
use App\Notifications\NewUser;
use Illuminate\Support\Facades\DB;
use App\Notifications\UploadBerkas;
use Illuminate\Support\Facades\Auth;
use App\Notifications\ActivityNotification;
use App\Notifications\CategoryActivation;
use Illuminate\Support\Facades\Notification;
use App\Notifications\FormRequestNotification;
use App\Notifications\StatusBerkas as NotificationsStatusBerkas;
use App\Notifications\UpdateStatus;
use Illuminate\Support\Facades\DB as FacadesDB;

class DashboardController extends Controller
{
    // Dashboard
    public function index(StatusBerkas $chart)
    {

        $table_berkas = Berkas::all();
        $id = Auth::user()->id;
        // dd($berkasnotif);
        // dd($usernotif->unreadNotifications);
        if (Auth::user()->role == 'admin') {
            // $userdata = DB::table('users')->leftJoin('berkas', 'users.id', '=', 'berkas.user_id')->select('users.name', 'users.email', 'users.role', 'berkas.nomor_berkas', 'berkas.status_id')->where('users.role', 0)->get();
            $newuser = User::find(2)->unreadNotifications->where('type', 'App\Notifications\NewUser');
            // dd($newuser);
            $newberkas = User::find(2)->unreadNotifications->where('type', 'App\Notifications\UploadBerkas');
            $berkas = Berkas::all()->count();
            $category = Category::all()->count();
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

            return view('dashboard', ['table_berkas' => $table_berkas, 'newberkas' => $newberkas, 'newuser' => $newuser, 'bulan' => $bulan, 'total_berkas' => $total_berkas, 'user' => $user, 'berkas' => $berkas, 'category' => $category, 'tertunda' => $tertunda, 'chart' => $chart->build()]);
        } else {
            // $userdata = DB::table('users')->leftJoin('berkas', 'users.id', '=', 'berkas.user_id')->select('users.name', 'users.email', 'users.role', 'berkas.nomor_berkas', 'berkas.status_id')->where('berkas.user_id', $id)->first();
            $categorynotif = User::find(1)->unreadNotifications->where('type', 'App\Notifications\CategoryActivation');
            $statusberkas = User::find($id)->unreadNotifications->where('type', 'App\Notifications\UpdateStatus');
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
                ->orderBy('created_at', 'asc')
                ->pluck('bulan');
        }

        return view('dashboard', ['statusberkas' => $statusberkas, 'table_berkas' => $table_berkas, 'categorynotif' => $categorynotif, 'bulan' => $bulan, 'total_berkas' => $total_berkas, 'user' => $user, 'berkas' => $berkas, 'diterima' => $diterima, 'terlambat' => $terlambat, 'ditolak' => $ditolak, 'chart' => $chart->build()]);
        // 
    }
    // End Of Dashboard

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
                ->orderBy('created_at', 'asc')
                ->pluck('bulan');
        }
        return view('cetak.index', ['bulan' => $bulan, 'total_berkas' => $total_berkas, 'user' => $user, 'berkas' => $berkas, 'diterima' => $diterima, 'terlambat' => $terlambat, 'ditolak' => $ditolak, 'chart' => $chart->build()]);
        // 
    }
    // End Of Cetak Grafik

    // Kategori
    public function view_kategori()
    {
        $newuser = User::find(2)->unreadNotifications->where('type', 'App\Notifications\NewUser');
        // dd($newuser);
        $newberkas = User::find(2)->unreadNotifications->where('type', 'App\Notifications\UploadBerkas');
        $category = Category::all();
        return view('category.index', compact('category', 'newuser', 'newberkas'));
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

    public function update_status_kategori(Category $category, $id)
    {
        $category = Category::where('id', $id)->first();
        $user = User::where('role', 0)->first();
        if ($category->status == 'Aktif') {
            $status = 'Nonaktif';
        } else {
            $status = 'Aktif';
        }
        $category->update(['status' => $status]);
        Notification::send($user, new CategoryActivation($category));
        // dd($category);
        // dd($category);
        return redirect()->back()->with('status', 'Kategori status berhasil diperbaharui');
    }
    // End Of Kategori

    // Dokumen 
    public function view_dokumen(Request $request)
    {
        $newuser = User::find(2)->unreadNotifications->where('type', 'App\Notifications\NewUser');
        // dd($newuser);
        $newberkas = User::find(2)->unreadNotifications->where('type', 'App\Notifications\UploadBerkas');

        if (request()->tgl_awal && request()->tgl_akhir) {
            $tgl_awal = Carbon::parse(request()->tgl_awal)->toDateTimeString();
            $tgl_akhir = Carbon::parse(request()->tgl_akhir)->toDateTimeString();
            $berkas = Berkas::whereBetween('created_at', [$tgl_awal, $tgl_akhir])->get();
        } else {
            $berkas = Berkas::whereMonth('created_at', Carbon::now()->month)->get();
        }


        $category = Category::all();
        return view('dokumen.berkas', ['category' => $category, 'berkas' => $berkas, 'newuser' => $newuser, 'newberkas' => $newberkas,]);
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

    public function view_tertunda(Request $request)
    {
        $newuser = User::find(2)->unreadNotifications->where('type', 'App\Notifications\NewUser');
        // dd($newuser);
        $newberkas = User::find(2)->unreadNotifications->where('type', 'App\Notifications\UploadBerkas');
        if ($newberkas->count() > 0) {
            $newberkas->markAsRead();
        }
        $berkas = Berkas::all();
        $category = Category::all();
        $status = Status::where('id', '>', 1)->get();
        return view('dokumen.berkas-tertunda', ['category' => $category, 'berkas' => $berkas, 'status' => $status, 'newuser' => $newuser, 'newberkas' => $newberkas]);
    }

    public function view_ditolak()
    {
        $newuser = User::find(2)->unreadNotifications->where('type', 'App\Notifications\NewUser');
        // dd($newuser);
        $newberkas = User::find(2)->unreadNotifications->where('type', 'App\Notifications\UploadBerkas');
        $berkas = Berkas::all();
        $category = Category::all();
        return view('dokumen.berkas-ditolak', ['category' => $category, 'berkas' => $berkas, 'newuser' => $newuser, 'newberkas' => $newberkas]);
    }

    public function update_status(Request $request, $id)
    {
        $getStatus = Berkas::where('id', $id)->first();
        $user = User::where('role', 0)->leftJoin('berkas', 'users.id', '=', 'berkas.user_id')->where('berkas.user_id', $id)->first();
        if (!$user) {
            $user = User::where('role', 0)->first();
        }
        if ($getStatus) {
            $getStatus->update(
                [
                    'status_id' => $request->status_id,
                ],

            );
            Notification::send($user, new UpdateStatus($getStatus));
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    // End of Dokumen

    // User
    public function view_user()
    {
        $newuser = User::find(2)->unreadNotifications->where('type', 'App\Notifications\NewUser');
        if ($newuser->count() > 0) {
            $newuser->markAsRead();
        }
        // dd($newuser);
        $newberkas = User::find(2)->unreadNotifications->where('type', 'App\Notifications\UploadBerkas');
        $satker = SatuanKerja::where('id', '>', 1)->get();
        $user = User::where('role', 0)->get();
        return view('setting.user-list', compact('user', 'newuser', 'satker', 'newberkas'));
    }

    public function update_status_user(Request $request, $id)
    {
        // 
        $user = User::select('status')->where('id', $id)->first();
        $member = User::where('id', $id)->first();
        if ($user->status == 'inactive') {
            $status = 'active';
            Notification::send($member, new ActivationUser($user));
        } else {
            $status = 'inactive';
        }
        // dd($member);
        User::where('id', $id)->update(['status' => $status]);

        return redirect()->back()->with('status', 'User status berhasil diperbaharui');
    }


    public function update_wilayah_user(Request $r, $id)
    {

        $user = User::where('id', $id)->first();
        if ($user) {
            $user->update(
                [
                    'satuan_kerja_id' => $r->satuan_kerja_id,
                ],

            );

            return redirect()->back()->with('satker', 'Satuan Kerja berhasil diperbaharui');
        }
    }
    // End of User

    // Download
    public function download_dokumen($id)
    {
        $berkas = Berkas::where('id', $id)->first();
        $file = $berkas->file;
        return response()->download(storage_path('app/dataFile/' . $file));
    }
    // End of Download

    // Berkas
    public function view_berkas()
    {
        $categorynotif = User::find(1)->unreadNotifications->where('type', 'App\Notifications\CategoryActivation');
        if ($categorynotif->count() > 0) {
            $categorynotif->markAsRead();
        }
        $usernotif = User::find(2);
        $id = Auth::user()->id;
        $statusberkas = User::find($id)->unreadNotifications->where('type', 'App\Notifications\UpdateStatus');
        if ($statusberkas->count() > 0) {
            $statusberkas->markAsRead();
        }
        $berkas = Berkas::where('user_id', $id)
            ->whereMonth('created_at', Carbon::now()->month)
            ->get();
        $category = Category::all();
        return view('berkas.index', ['category' => $category, 'berkas' => $berkas, 'usernotif' => $usernotif, 'categorynotif' => $categorynotif, 'statusberkas' => $statusberkas]);
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
        $satker = Auth::user()->satker;
        $user = User::where('role', 1)->get();
        $berkas = Berkas::create($validated);
        Notification::send($user, new UploadBerkas($berkas, $satker));
        echo $berkas->nomor_berkas;
        // dd($berkas);
        return redirect()->route('berkas', compact('berkas'))->with('message', 'Data Baru berhasil Ditambahkan!');
    }
    // End Of Berkas

    // Laporan
    public function laporan_berkas(Request $request)
    {
        $categorynotif = User::find(1)->unreadNotifications->where('type', 'App\Notifications\CategoryActivation');
        $newuser = User::find(2)->unreadNotifications->where('type', 'App\Notifications\NewUser');
        // dd($newuser);
        $newberkas = User::find(2)->unreadNotifications->where('type', 'App\Notifications\UploadBerkas');
        $id = Auth::user()->id;
        $statusberkas = User::find($id)->unreadNotifications->where('type', 'App\Notifications\UpdateStatus');
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
        return view('laporan.berkas', compact('berkas', 'status', 'category', 'newuser', 'newberkas', 'categorynotif', 'statusberkas'));
    }
    // End of Laporan
}

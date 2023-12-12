<?php

namespace App\Http\Controllers\Siswa;

use App\hasilakhir;
use App\HasilakhirHolland;
use App\Http\Controllers\Controller;
use App\setsoal;
use App\soaldisc;
use App\SoalHolland;
use Illuminate\Http\Request;
use Carbon;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;


class ujianController extends Controller
{
    public function index()
    {
        $cek = hasilakhir::where('userid', auth()->user()->id)->first();
        $cek2 = HasilakhirHolland::where('userid', auth()->user()->id)->first();
        return view('Siswa.Ujian.index', compact('cek', 'cek2'));
    }

    public function ujianDisc()
    {
        $soal = soaldisc::get();
        return view('Siswa.Ujian.disc', compact('soal'));
    }

    public function petunjukujian($params)
    {
        $now = Carbon\Carbon::now();
        $cek = setsoal::where('sekolahid', auth()->user()->sekolahid)->first();
        if (empty($cek)) {
            Alert::warning('Belum Waktu Ujian', 'Silahkan Hubungi Guru BK');
            return redirect()->route('ujian.index');
        }
        if ($cek->status == 'aktif') {
            if ($now >= $cek->tanggalmulai && $now <= $cek->tanggalselesai) {
                if ($params == 'disc') {
                    return view('Siswa.Ujian.petunjukdisc');
                }
            }
            Alert::warning('Belum Waktu Ujian', 'Silahkan Hubungi Guru BK');
            return redirect()->route('ujian.index');
        }
    }

    public function storedisc(Request $request)
    {
        // hal 27
        $a = $request->except('_token');
        // dd($a);
        $id_peserta = auth()->user()->id;
        $id_sekolah = auth()->user()->sekolahid;
        $jumlah     = count($a);
        $D_MOST = 0;
        $I_MOST = 0;
        $S_MOST = 0;
        $C_MOST = 0;
        $bintang_MOST = 0;
        $D_LEST = 0;
        $I_LEST = 0;
        $S_LEST = 0;
        $C_LEST = 0;
        $bintang_LEST = 0;
        // dd($jumlah);
        $mulai = 9;
        for ($i = 1; $i <= $jumlah; $i++) {
            if ($i % 2 == 1) {
                // most
                // echo $a[$mulai .'M'];
                if ($a[$mulai . 'M'] == 'd') {
                    $D_MOST++;
                }
                if ($a[$mulai . 'M'] == 'i') {
                    $I_MOST++;
                }
                if ($a[$mulai . 'M'] == 's') {
                    $S_MOST++;
                }
                if ($a[$mulai . 'M'] == 'c') {
                    $C_MOST++;
                }
                if ($a[$mulai . 'M'] == '*') {
                    $bintang_MOST++;
                }
            } else {
                // lest
                // echo $a[$mulai . 'L'];
                if ($a[$mulai . 'L'] == 'd') {
                    $D_LEST++;
                }
                if ($a[$mulai . 'L'] == 'i') {
                    $I_LEST++;
                }
                if ($a[$mulai . 'L'] == 's') {
                    $S_LEST++;
                }
                if ($a[$mulai . 'L'] == 'c') {
                    $C_LEST++;
                }
                if ($a[$mulai . 'L'] == '*') {
                    $bintang_LEST++;
                }
                $mulai++;
            }
        }

        DB::beginTransaction();

        try {
            hasilakhir::create([
                'D_MOST' => $D_MOST,
                'I_MOST' => $I_MOST,
                'S_MOST' => $S_MOST,
                'C_MOST' => $C_MOST,
                'bintang_MOST' => $bintang_MOST,
                'D_LEST' => $D_LEST,
                'I_LEST' => $I_LEST,
                'S_LEST' => $S_LEST,
                'C_LEST' => $C_LEST,
                'bintang_LEST' => $bintang_LEST,
                'userid' => auth()->user()->id,
                'nama' => auth()->user()->nama,
                'namasekolah' => auth()->user()->sekolah['namasekolah'],
                'sekolahid' => auth()->user()->sekolahid,
                'afiliatorid' => auth()->user()->afiliatorid,
                'nisn' => auth()->user()->nisn,
                'jeniskelamin' => auth()->user()->jeniskelamin,
                'tanggallahir' => auth()->user()->tanggallahir,
            ]);

            DB::commit();
            Alert::success('Berhasil', 'Data Ujian Anda Telah Tersimpan');
            return redirect()->route('ujian.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::warning('Ada Yang Salah', 'Silahkan Hubungi Guru BK');
            return redirect()->route('ujian.index');
        }
    }

    public function hasildisc()
    {
        $data = hasilakhir::where('userid', auth()->user()->id)->get();
        return view('Siswa.Ujian.hasildisc', compact('data'));
    }

    // HOLLAND START
    public function ujianHolland()
    {
        $R1 = SoalHolland::where('typesoal', 'R1')->get();
        $I1 = SoalHolland::where('typesoal', 'I1')->get();
        $A1 = SoalHolland::where('typesoal', 'A1')->get();
        $S1 = SoalHolland::where('typesoal', 'S1')->get();
        $E1 = SoalHolland::where('typesoal', 'E1')->get();
        $C1 = SoalHolland::where('typesoal', 'C1')->get();
        $R2 = SoalHolland::where('typesoal', 'R2')->get();
        $I2 = SoalHolland::where('typesoal', 'I2')->get();
        $A2 = SoalHolland::where('typesoal', 'A2')->get();
        $S2 = SoalHolland::where('typesoal', 'S2')->get();
        $E2 = SoalHolland::where('typesoal', 'E2')->get();
        $C2 = SoalHolland::where('typesoal', 'C2')->get();
        $R3 = SoalHolland::where('typesoal', 'R3')->get();
        $I3 = SoalHolland::where('typesoal', 'I3')->get();
        $A3 = SoalHolland::where('typesoal', 'A3')->get();
        $S3 = SoalHolland::where('typesoal', 'S3')->get();
        $E3 = SoalHolland::where('typesoal', 'E3')->get();
        $C3 = SoalHolland::where('typesoal', 'C3')->get();
        return view('Siswa.Ujian.Holland.holland', compact('R1', 'I1', 'A1', 'S1', 'E1', 'C1', 'R2', 'I2', 'A2', 'S2', 'E2', 'C2', 'R3', 'I3', 'A3', 'S3', 'E3', 'C3'));
    }

    public function petunjukujianholland($params)
    {
        $now = Carbon\Carbon::now();
        $cek = setsoal::where('sekolahid', auth()->user()->sekolahid)->first();
        if (empty($cek)) {
            Alert::warning('Belum Waktu Ujian', 'Silahkan Hubungi Guru BK');
            return redirect()->route('ujian.holland');
        }
        if ($cek->status == 'aktif') {
            if ($now >= $cek->tanggalmulai && $now <= $cek->tanggalselesai) {
                if ($params == 'holland') {
                    return view('Siswa.Ujian.Holland.petunjukholland');
                }
            }
            Alert::warning('Belum Waktu Ujian', 'Silahkan Hubungi Guru BK');
            return redirect()->route('ujian.holland');
        }
    }

    public function storeHolland(Request $request)
    {
        // hal 27
        $a = $request->except('_token');
        dd($a);
        $id_peserta = auth()->user()->id;
        $id_sekolah = auth()->user()->sekolahid;
        $jumlah     = count($a);
        $D_MOST = 0;
        $I_MOST = 0;
        $S_MOST = 0;
        $C_MOST = 0;
        $bintang_MOST = 0;
        $D_LEST = 0;
        $I_LEST = 0;
        $S_LEST = 0;
        $C_LEST = 0;
        $bintang_LEST = 0;
        // dd($jumlah);
        $mulai = 9;
        for ($i = 1; $i <= $jumlah; $i++) {
            if ($i % 2 == 1) {
                // most
                // echo $a[$mulai .'M'];
                if ($a[$mulai . 'M'] == 'd') {
                    $D_MOST++;
                }
                if ($a[$mulai . 'M'] == 'i') {
                    $I_MOST++;
                }
                if ($a[$mulai . 'M'] == 's') {
                    $S_MOST++;
                }
                if ($a[$mulai . 'M'] == 'c') {
                    $C_MOST++;
                }
                if ($a[$mulai . 'M'] == '*') {
                    $bintang_MOST++;
                }
            } else {
                // lest
                // echo $a[$mulai . 'L'];
                if ($a[$mulai . 'L'] == 'd') {
                    $D_LEST++;
                }
                if ($a[$mulai . 'L'] == 'i') {
                    $I_LEST++;
                }
                if ($a[$mulai . 'L'] == 's') {
                    $S_LEST++;
                }
                if ($a[$mulai . 'L'] == 'c') {
                    $C_LEST++;
                }
                if ($a[$mulai . 'L'] == '*') {
                    $bintang_LEST++;
                }
                $mulai++;
            }
        }

        DB::beginTransaction();

        try {
            hasilakhir::create([
                'D_MOST' => $D_MOST,
                'I_MOST' => $I_MOST,
                'S_MOST' => $S_MOST,
                'C_MOST' => $C_MOST,
                'bintang_MOST' => $bintang_MOST,
                'D_LEST' => $D_LEST,
                'I_LEST' => $I_LEST,
                'S_LEST' => $S_LEST,
                'C_LEST' => $C_LEST,
                'bintang_LEST' => $bintang_LEST,
                'userid' => auth()->user()->id,
                'nama' => auth()->user()->nama,
                'namasekolah' => auth()->user()->sekolah['namasekolah'],
                'sekolahid' => auth()->user()->sekolahid,
                'afiliatorid' => auth()->user()->afiliatorid,
                'nisn' => auth()->user()->nisn,
                'jeniskelamin' => auth()->user()->jeniskelamin,
                'tanggallahir' => auth()->user()->tanggallahir,
            ]);

            DB::commit();
            Alert::success('Berhasil', 'Data Ujian Anda Telah Tersimpan');
            return redirect()->route('ujian.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::warning('Ada Yang Salah', 'Silahkan Hubungi Guru BK');
            return redirect()->route('ujian.index');
        }
    }

    public function hasilHolland()
    {
        $data = hasilakhir::where('userid', auth()->user()->id)->get();
        $dataholland = HasilakhirHolland::where('userid', auth()->user()->id)->get();
        return view('Siswa.Ujian.hasildisc', compact('data', 'dataholland'));
    }
}

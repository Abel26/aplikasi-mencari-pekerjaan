<?php

namespace App\Http\Controllers;

use App\Models\JobCandidate;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // menampilkan daftar pekerjaan yang telah dilamar oleh employee
    public function my_applications()
    {
        $user = Auth::user();
        // mengambil pekerjaan yang dilamar oleh employee
        $my_applications = JobCandidate::where('candidate_id', $user->id)->orderByDesc('id')->paginate(10);

        return view('dashboard.my_applications', compact('my_applications'));
    }

    // untuk menampilkan detail dari aplikasi pekerjaan tertentu yang dilamar oleh employee
    // menerima parameter secara otomatis akan injeksi model berdasarkan id yang diberikan di url
    public function my_applications_details(JobCandidate $jobCandidate)
    {
        $user = Auth::user();
        // cek apakah candidate_id dari jobCandidate sesuai dengan id yg login, jika tidak maka tidak memiliki hak untuk melihat detail lamaran orang lain
        if ($jobCandidate->candidate_id != $user->id) {
            abort(403);
        }

        return view('dashboard.my_application_details', compact('jobCandidate'));
    }
}

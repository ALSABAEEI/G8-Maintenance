<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    /**
     * Display the user report grouped by program.
     */
    public function userReport()
    {
        // Fetch users grouped by program
        $usersByProgram = User::select('Program')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('Program')
            ->get();

        return view('admin.reports.users', compact('usersByProgram'));
    }

    /**
     * Export the user report as a PDF.
     */
    public function exportUserReportPDF()
    {
        // Fetch users grouped by program
        $usersByProgram = User::select('Program')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('Program')
            ->get();

        // Generate the PDF
        $pdf = Pdf::loadView('admin.reports.user_report_pdf', compact('usersByProgram'));

        // Return the PDF for download
        return $pdf->download('user_report_by_program.pdf');
    }
}

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
    public function userReport(Request $request)
    {
        // Get all unique programs for filter dropdown (exclude Default and admins)
        $allPrograms = User::distinct()
            ->where('Role', '!=', 'admin')
            ->where('Program', '!=', 'Default')
            ->whereNotNull('Program')
            ->pluck('Program')
            ->filter()
            ->values();

        // Query users based on filter (exclude admins and Default program)
        $query = User::where('Role', '!=', 'admin')
            ->where('Program', '!=', 'Default')
            ->whereNotNull('Program');

        if ($request->filled('program')) {
            $query->where('Program', $request->program);
        }

        $users = $query->orderBy('Program')->orderBy('UserName')->get();

        // Fetch users grouped by program (for PDF export, exclude admins and Default)
        $usersByProgram = User::select('Program')
            ->selectRaw('COUNT(*) as total')
            ->where('Role', '!=', 'admin')
            ->where('Program', '!=', 'Default')
            ->whereNotNull('Program')
            ->groupBy('Program')
            ->get();

        return view('admin.reports.users', compact('users', 'allPrograms', 'usersByProgram'));
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

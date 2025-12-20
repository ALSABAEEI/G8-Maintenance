<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Slot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AppointmentController extends Controller
{
    // Method to manage appointments based on role
    public function manageAppointments()
    {
        $user = Auth::user();  // Get the logged-in user

        if (!$user) {
            return abort(403, 'User not logged in.');
        }

        // Admin view all appointments
        if ($user->Role === 'admin') {
            $appointments = Appointment::with('student', 'slot.supervisor')->get();
            return view('admin.appointments', compact('appointments'));
        }

        // Supervisor manages their own appointments and slots
        if ($user->Role === 'supervisor') {
            $slots = Slot::where('supervisor_id', $user->id)->get();
            $appointments = Appointment::with('student', 'slot')
                ->whereHas('slot', function ($query) use ($user) {
                    $query->where('supervisor_id', $user->id);
                })
                ->get();
            return view('supervisor.appointments', compact('appointments', 'slots'));
        }

        // Student views their own appointments
        if ($user->Role === 'student') {
            $appointments = Appointment::with('slot')
                ->where('student_id', $user->id)
                ->get();

            // Fetch available slots for students to request
            $availableSlots = Slot::where('available', true)->get();
            return view('student.appointments', compact('appointments', 'availableSlots'));
        }

        // Default case if the role doesn't match
        return abort(403, 'Unauthorized action.');
    }

    // Method for students to request an appointment
    public function requestAppointment(Request $request)
    {
        $user = Auth::user();

        if ($user->Role === 'student') {
            $validated = $request->validate([
                'slot_id' => 'required|exists:slots,id',
            ]);

            $slot = Slot::findOrFail($validated['slot_id']);
            if (!$slot->available) {
                return back()->withErrors(['slot' => 'This slot is no longer available.']);
            }

            // Create the appointment for the student
            Appointment::create([
                'student_id' => $user->id,
                'slot_id' => $slot->id,
                'status' => 'Pending',
            ]);

            // Mark the slot as unavailable after appointment request
            $slot->update(['available' => false]);

            return redirect()->route('appointments.manage')->with('success', 'Appointment requested successfully.');
        }

        return abort(403, 'Unauthorized action.');
    }

    // Method for adding a new slot (only for supervisor)
    public function addSlot(Request $request)
    {
        $user = Auth::user();

        if ($user->Role === 'supervisor') {
            $validated = $request->validate([
                'date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
            ]);

            Slot::create([
                'supervisor_id' => $user->id,
                'date' => $validated['date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'available' => true,
            ]);

            return redirect()->route('appointments.manage')->with('success', 'Slot added successfully.');
        }

        return abort(403, 'Unauthorized action.');
    }

    // Method to handle toggling slot availability (only for supervisor)
    public function toggleSlotAvailability($slotId)
    {
        $user = Auth::user();

        if ($user->Role === 'supervisor') {
            $slot = Slot::findOrFail($slotId);
            $slot->available = !$slot->available;  // Toggle availability
            $slot->save();

            return back()->with('success', 'Slot availability updated.');
        }

        return abort(403, 'Unauthorized action.');
    }

    // Method to handle appointment status management (only for supervisor)
    public function manageAppointmentStatus(Request $request, Appointment $appointment)
    {
        $user = Auth::user();

        if ($user->Role === 'supervisor') {
            $validated = $request->validate([
                'status' => 'required|in:Approved,Rejected',
            ]);

            // Ensure the supervisor is managing their own appointment
            if ($appointment->slot->supervisor_id !== $user->id) {
                return abort(403, 'Unauthorized action.');
            }

            // Update the appointment status
            $appointment->update(['status' => $validated['status']]);

            return redirect()->route('appointments.manage')->with('success', 'Appointment status updated successfully.');
        }

        return abort(403, 'Unauthorized action.');
    }
}

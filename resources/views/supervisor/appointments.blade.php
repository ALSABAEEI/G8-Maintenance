@extends('layouts.app')

@section('content')
@php
    use Carbon\Carbon;
    use Carbon\CarbonPeriod;

    $formatTime = fn(string $time) => Carbon::parse($time)->format('h:i A');

    $timeOptions = collect(CarbonPeriod::create('08:00', '30 minutes', '18:00'))
        ->map(fn ($time) => [
            'value' => $time->format('H:i'),
            'label' => $time->format('h:i A'),
        ])->values();

    $slotTimeline = $slots->map(fn ($slot) => [
        'date' => $slot->date,
        'start' => $slot->start_time,
        'end' => $slot->end_time,
    ])->values();
@endphp
 
<style>
    .time-picker {
        position: relative;
    }

    .time-picker__display {
        width: 100%;
        border: 1px solid #cbd5f5;
        background-color: #fff;
        border-radius: 0.5rem;
        padding: 0.55rem 0.75rem;
        font-size: 0.95rem;
        color: #1f2937;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 0.5rem;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .time-picker__display:focus-visible {
        outline: none;
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.2);
    }

    .time-picker__display[data-open="true"] {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.2);
    }

    .time-picker__chevron {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .time-wheel__panel {
        position: absolute;
        left: 0;
        right: 0;
        top: calc(100% + 0.25rem);
        background-color: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        box-shadow: 0 20px 45px rgba(15, 23, 42, 0.18);
        z-index: 40;
        padding: 0.35rem;
        display: none;
    }

    .time-wheel__panel[data-open="true"] {
        display: block;
    }

    .time-wheel {
        border-radius: 0.5rem;
        max-height: 230px;
        overflow-y: auto;
        scroll-snap-type: y mandatory;
        padding: 0.25rem;
    }

    .time-wheel__item {
        width: 100%;
        border: none;
        background: transparent;
        padding: 0.35rem 0.4rem;
        text-align: center;
        border-radius: 0.4rem;
        font-size: 0.95rem;
        color: #1f2937;
        cursor: pointer;
        transition: background-color 0.15s ease, color 0.15s ease;
        scroll-snap-align: center;
    }

    .time-wheel__item:not(.time-wheel__item--blocked):hover {
        background-color: #E0ECFF;
        color: #0f4591;
    }

    .time-wheel__item--selected {
        background-color: #0d6efd;
        color: #fff;
        font-weight: 600;
    }

    .time-wheel__item--blocked {
        color: #9ca3af;
        cursor: not-allowed;
        opacity: 0.6;
    }

    .time-wheel__item--blocked::after {
        content: 'Booked';
        display: block;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #9ca3af;
    }
</style>
</style>
<div class="container">
    <h1>Manage Available Slots</h1>

    <form action="{{ route('appointments.addSlot') }}" method="POST" id="slot-form">
        @csrf
        <div class="form-group">
            <label for="slot-date">Date</label>
            <input type="date" class="form-control" name="date" id="slot-date" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="hidden" name="start_time" id="start_time" required>
            <div class="time-picker" data-picker-container="start_time">
                <button type="button" class="time-picker__display" data-picker-trigger="start_time" aria-haspopup="listbox" aria-expanded="false" aria-controls="time-panel-start">
                    <span data-picker-display="start_time" data-picker-default="Select a start time.">Select a start time.</span>
                    <span class="time-picker__chevron" aria-hidden="true">&#9662;</span>
                </button>
                <div class="time-wheel__panel" id="time-panel-start" data-picker-panel="start_time" data-open="false">
                    <div class="time-wheel" data-wheel="start_time" role="listbox" aria-label="Start time options">
                        @foreach ($timeOptions as $option)
                            <button type="button" class="time-wheel__item" data-value="{{ $option['value'] }}" data-label="{{ $option['label'] }}" aria-pressed="false">
                                {{ $option['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <small class="form-text text-muted" data-selected-label="start_time" data-empty-label="Select a start time.">Select a start time.</small>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="hidden" name="end_time" id="end_time" required>
            <div class="time-picker" data-picker-container="end_time">
                <button type="button" class="time-picker__display" data-picker-trigger="end_time" aria-haspopup="listbox" aria-expanded="false" aria-controls="time-panel-end">
                    <span data-picker-display="end_time" data-picker-default="Select an end time.">Select an end time.</span>
                    <span class="time-picker__chevron" aria-hidden="true">&#9662;</span>
                </button>
                <div class="time-wheel__panel" id="time-panel-end" data-picker-panel="end_time" data-open="false">
                    <div class="time-wheel" data-wheel="end_time" role="listbox" aria-label="End time options">
                        @foreach ($timeOptions as $option)
                            <button type="button" class="time-wheel__item" data-value="{{ $option['value'] }}" data-label="{{ $option['label'] }}" aria-pressed="false">
                                {{ $option['label'] }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
            <small class="form-text text-muted" data-selected-label="end_time" data-empty-label="Select an end time.">Select an end time.</small>
        </div>
        <button type="submit" class="btn btn-primary">Add Slot</button>
        <div class="alert alert-danger d-none mt-3" id="slot-conflict-alert"></div>
    </form>

    <h2>Available Slots</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Availability</th>
            </tr>
        </thead>
        <tbody>
            @foreach($slots as $slot)
            <tr>
                <td>{{ $slot->date }}</td>
                <td>{{ $formatTime($slot->start_time) }} - {{ $formatTime($slot->end_time) }}</td>
                <td>
                    <form action="{{ route('appointments.toggleAvailability', $slot->id) }}" method="POST" class="toggle-availability-form" data-available="{{ $slot->available ? '1' : '0' }}" data-slot-info="{{ $slot->date }} {{ $slot->start_time }} - {{ $slot->end_time }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-{{ $slot->available ? 'danger' : 'success' }}">
                            {{ $slot->available ? 'Mark Unavailable' : 'Mark Available' }}
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Manage Appointments</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->student->name }}</td>
                <td>{{ $appointment->slot->date }}</td>
                <td>{{ $formatTime($appointment->slot->start_time) }} - {{ $formatTime($appointment->slot->end_time) }}</td>
                <td>{{ $appointment->status }}</td>
                <td>
                    <button type="button" class="btn btn-primary" onclick="openManageModal({{ $appointment->id }})">
                        Manage
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal for Accept/Reject Appointment -->
<div class="modal fade" id="manageModal" tabindex="-1" aria-labelledby="manageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="manageModalLabel">Manage Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="manageForm" method="POST" action="">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="Approved">Approve</option>
                            <option value="Rejected">Reject</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const slotTimeline = @json($slotTimeline);
        const dateInput = document.getElementById('slot-date');
        const slotForm = document.getElementById('slot-form');
        const submitButton = slotForm ? slotForm.querySelector('button[type="submit"]') : null;
        const conflictAlert = document.getElementById('slot-conflict-alert');
        const wheelFieldNames = ['start_time', 'end_time'];
        const wheelRegistry = {};

        const timeToMinutes = (timeString) => {
            if (!timeString) {
                return null;
            }
            const parts = timeString.split(':');
            const hours = parseInt(parts[0], 10) || 0;
            const minutes = parseInt(parts[1], 10) || 0;
            return hours * 60 + minutes;
        };

        const blockedLookup = slotTimeline.reduce((accumulator, slot) => {
            if (!accumulator[slot.date]) {
                accumulator[slot.date] = [];
            }
            const start = timeToMinutes(slot.start);
            const end = timeToMinutes(slot.end);
            if (start === null || end === null) {
                return accumulator;
            }
            accumulator[slot.date].push({ start, end });
            return accumulator;
        }, {});

        const setDisplayText = (fieldName, text) => {
            const registry = wheelRegistry[fieldName];
            if (registry && registry.displayNode) {
                registry.displayNode.textContent = text;
            }
        };

        const closePanel = (fieldName) => {
            const registry = wheelRegistry[fieldName];
            if (!registry) {
                return;
            }
            if (registry.panel) {
                registry.panel.dataset.open = 'false';
            }
            if (registry.trigger) {
                registry.trigger.dataset.open = 'false';
                registry.trigger.setAttribute('aria-expanded', 'false');
            }
        };

        const openPanel = (fieldName) => {
            const registry = wheelRegistry[fieldName];
            if (!registry) {
                return;
            }
            if (registry.panel) {
                registry.panel.dataset.open = 'true';
            }
            if (registry.trigger) {
                registry.trigger.dataset.open = 'true';
                registry.trigger.setAttribute('aria-expanded', 'true');
            }
        };

        const closeAllPanels = () => {
            wheelFieldNames.forEach((fieldName) => closePanel(fieldName));
        };

        const showConflict = (message) => {
            if (!conflictAlert || !submitButton) {
                return;
            }
            conflictAlert.textContent = message;
            conflictAlert.classList.remove('d-none');
            submitButton.disabled = true;
        };

        const clearConflict = () => {
            if (!conflictAlert || !submitButton) {
                return;
            }
            conflictAlert.textContent = '';
            conflictAlert.classList.add('d-none');
            submitButton.disabled = false;
        };

        const evaluateFormConstraints = () => {
            if (!submitButton) {
                return;
            }

            const selectedDate = dateInput ? dateInput.value : '';
            const startRegistry = wheelRegistry.start_time;
            const endRegistry = wheelRegistry.end_time;

            const startValue = startRegistry ? startRegistry.hiddenInput.value : '';
            const endValue = endRegistry ? endRegistry.hiddenInput.value : '';

            if (!selectedDate || !startValue || !endValue) {
                clearConflict();
                return;
            }

            const startMinutes = timeToMinutes(startValue);
            const endMinutes = timeToMinutes(endValue);

            if (startMinutes === null || endMinutes === null) {
                clearConflict();
                return;
            }

            if (endMinutes <= startMinutes) {
                showConflict('End time must be later than start time.');
                return;
            }

            const dayRanges = blockedLookup[selectedDate] || [];
            const overlapsExisting = dayRanges.some((range) => {
                return startMinutes < range.end && endMinutes > range.start;
            });

            if (overlapsExisting) {
                showConflict('Selected time range overlaps an existing slot.');
            } else {
                clearConflict();
            }
        };

        const initializeWheel = (fieldName) => {
            const wheelElement = document.querySelector(`[data-wheel="${fieldName}"]`);
            const hiddenInput = document.getElementById(fieldName);
            const helperText = document.querySelector(`[data-selected-label="${fieldName}"]`);
            const panel = document.querySelector(`[data-picker-panel="${fieldName}"]`);
            const trigger = document.querySelector(`[data-picker-trigger="${fieldName}"]`);
            const displayNode = document.querySelector(`[data-picker-display="${fieldName}"]`);
            if (!wheelElement || !hiddenInput) {
                return;
            }

            const buttons = Array.from(wheelElement.querySelectorAll('.time-wheel__item'));
            wheelRegistry[fieldName] = { wheelElement, hiddenInput, helperText, buttons, panel, trigger, displayNode };

            buttons.forEach((button) => {
                button.addEventListener('click', () => handleSelection(fieldName, button));
            });

            if (trigger && panel) {
                trigger.addEventListener('click', (event) => {
                    event.preventDefault();
                    const currentlyOpen = panel.dataset.open === 'true';
                    closeAllPanels();
                    if (!currentlyOpen) {
                        openPanel(fieldName);
                    }
                });
            }
        };

        const handleSelection = (fieldName, button) => {
            if (button.classList.contains('time-wheel__item--blocked')) {
                return;
            }

            const registry = wheelRegistry[fieldName];
            if (!registry) {
                return;
            }

            registry.buttons.forEach((btn) => {
                btn.classList.remove('time-wheel__item--selected');
                btn.setAttribute('aria-pressed', 'false');
            });

            button.classList.add('time-wheel__item--selected');
            button.setAttribute('aria-pressed', 'true');
            registry.hiddenInput.value = button.dataset.value;

            if (registry.helperText) {
                registry.helperText.textContent = `Selected: ${button.dataset.label}`;
            }

            setDisplayText(fieldName, button.dataset.label);
            closePanel(fieldName);

            evaluateFormConstraints();
        };

        const resetHelperText = (fieldName) => {
            const registry = wheelRegistry[fieldName];
            if (!registry) {
                return;
            }
            const fallback = (registry.helperText && registry.helperText.dataset.emptyLabel) ? registry.helperText.dataset.emptyLabel : 'Select a time.';
            if (registry.helperText) {
                registry.helperText.textContent = fallback;
            }
            const defaultDisplay = (registry.displayNode && registry.displayNode.dataset.pickerDefault) ? registry.displayNode.dataset.pickerDefault : fallback;
            setDisplayText(fieldName, defaultDisplay);
        };

        const refreshWheels = (selectedDate) => {
            const blockedRanges = selectedDate ? blockedLookup[selectedDate] || [] : [];

            wheelFieldNames.forEach((fieldName) => {
                const registry = wheelRegistry[fieldName];
                if (!registry) {
                    return;
                }

                registry.buttons.forEach((button) => {
                    const minutesValue = timeToMinutes(button.dataset.value);
                    const isBlocked = blockedRanges.some((range) => {
                        return minutesValue !== null && minutesValue >= range.start && minutesValue < range.end;
                    });
                    button.classList.toggle('time-wheel__item--blocked', isBlocked);
                    button.setAttribute('aria-disabled', isBlocked ? 'true' : 'false');
                });

                if (
                    blockedRanges.length &&
                    registry.hiddenInput.value &&
                    blockedRanges.some((range) => {
                        const minutesValue = timeToMinutes(registry.hiddenInput.value);
                        return minutesValue !== null && minutesValue >= range.start && minutesValue < range.end;
                    })
                ) {
                    registry.hiddenInput.value = '';
                    registry.buttons.forEach((btn) => {
                        btn.classList.remove('time-wheel__item--selected');
                        btn.setAttribute('aria-pressed', 'false');
                    });
                    resetHelperText(fieldName);
                    evaluateFormConstraints();
                }
            });
        };

        wheelFieldNames.forEach(initializeWheel);

        refreshWheels(dateInput ? dateInput.value : '');

        if (dateInput) {
            dateInput.addEventListener('change', (event) => {
                refreshWheels(event.target.value);
                evaluateFormConstraints();
                closeAllPanels();
            });
        }

        evaluateFormConstraints();

        document.addEventListener('click', (event) => {
            if (!event.target.closest('.time-picker')) {
                closeAllPanels();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAllPanels();
            }
        });

        const toggleForms = document.querySelectorAll('.toggle-availability-form');

        toggleForms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (form.dataset.confirmed === 'true') {
                    form.dataset.confirmed = 'false';
                    return;
                }

                event.preventDefault();

                const isCurrentlyAvailable = form.dataset.available === '1';
                const actionText = isCurrentlyAvailable ? 'mark this slot as unavailable' : 'mark this slot as available';
                const confirmButtonText = isCurrentlyAvailable ? 'Yes, mark unavailable' : 'Yes, mark available';
                const slotInfo = form.dataset.slotInfo;

                Swal.fire({
                    title: 'Confirm change?',
                    text: `Do you want to ${actionText} (${slotInfo})?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: 'Cancel',
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.dataset.confirmed = 'true';
                        form.submit();
                    }
                });
            });
        });
    });

    function openManageModal(appointmentId) {
        var form = document.getElementById('manageForm');
        form.action = '/appointments/' + appointmentId + '/manage'; // Correct route
        $('#manageModal').modal('show'); // Show the modal
    }
</script>
@endsection